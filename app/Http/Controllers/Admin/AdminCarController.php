<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminCarController extends Controller
{
    /**
     * Affiche la liste des voitures
     */
    public function index(Request $request)
    {
        $query = Car::query();
        
        // Filtre par recherche (nom, marque, modèle)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }
        
        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filtre par marque
        if ($request->filled('brand')) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }

        // Filtre par gamme de prix
        if ($request->filled('min_price')) {
            $query->where('daily_price_without_driver', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('daily_price_without_driver', '<=', $request->max_price);
        }
        
        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['name', 'brand', 'year', 'daily_price_without_driver', 'status', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $cars = $query->with('galleries')->paginate(10)->appends($request->query());
        
        // Statistiques pour le tableau de bord
        $stats = [
            'total' => Car::count(),
            'available' => Car::where('status', 'available')->count(),
            'reserved' => Car::where('status', 'reserved')->count(),
            'maintenance' => Car::where('status', 'maintenance')->count(),
            'avg_price' => Car::avg('daily_price_without_driver')
        ];
        
        return view('admin.cars.index', compact('cars', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Enregistre une nouvelle voiture
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:cars',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'fuel_type' => 'required|in:essence,diesel,electrique,hybride',
            'transmission' => 'required|in:manuelle,automatique',
            'seats' => 'required|integer|min:2|max:9',
            'daily_price_without_driver' => 'required|numeric|min:0|max:999999.99',
            'daily_price_with_driver' => 'required|numeric|min:0|max:999999.99',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Validation métier
        if ($validated['daily_price_with_driver'] <= $validated['daily_price_without_driver']) {
            return back()->withErrors(['daily_price_with_driver' => 'Le prix avec chauffeur doit être supérieur au prix sans chauffeur.'])
                        ->withInput();
        }

        // Validation personnalisée pour la galerie (max 4 images)
        if ($request->hasFile('gallery_images') && count($request->file('gallery_images')) > 4) {
            return back()->withErrors(['gallery_images' => 'Vous ne pouvez ajouter que 4 images maximum à la galerie.'])
                        ->withInput();
        }

        DB::beginTransaction();
        
        try {
            // Définir le statut par défaut
            $validated['status'] = 'available';

            // Gérer l'upload de l'image principale
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('cars', 'public');
            }

            // Créer la voiture
            $car = Car::create($validated);

            // Gérer les images de la galerie
            if ($request->hasFile('gallery_images')) {
                $this->storeGalleryImages($car, $request->file('gallery_images'));
            }

            DB::commit();

            return redirect()->route('admin.cars.index')->with('success', 'Voiture ajoutée avec succès.');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Nettoyer l'image uploadée en cas d'erreur
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Affiche les détails d'une voiture
     */
    public function show(Car $car)
    {
        $car->load(['galleries', 'reservations' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);
        
        // Statistiques de la voiture
        $stats = $car->getUsageStats();
        
        // Réservations récentes
        $recentReservations = $car->reservations()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Réservation active
        $activeReservation = $car->activeReservation();
        
        // Prochaines réservations
        $upcomingReservations = $car->upcomingReservations()
            ->with('user')
            ->limit(3)
            ->get();
        
        return view('admin.cars.show', compact(
            'car', 
            'stats', 
            'recentReservations', 
            'activeReservation', 
            'upcomingReservations'
        ));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Car $car)
    {
        $car->load('galleries');
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Met à jour une voiture
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $car->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'fuel_type' => 'required|in:essence,diesel,electrique,hybride',
            'transmission' => 'required|in:manuelle,automatique',
            'seats' => 'required|integer|min:2|max:9',
            'status' => 'required|in:available,reserved,maintenance',
            'daily_price_without_driver' => 'required|numeric|min:0|max:999999.99',
            'daily_price_with_driver' => 'required|numeric|min:0|max:999999.99',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'integer|exists:car_galleries,id',
        ]);

        // Validation métier
        if ($validated['daily_price_with_driver'] <= $validated['daily_price_without_driver']) {
            return back()->withErrors(['daily_price_with_driver' => 'Le prix avec chauffeur doit être supérieur au prix sans chauffeur.'])
                        ->withInput();
        }

        // Vérification si on peut changer le statut
        if ($request->status !== $car->status) {
            $canChangeStatus = $this->canChangeStatus($car, $request->status);
            if (!$canChangeStatus['allowed']) {
                return back()->withErrors(['status' => $canChangeStatus['message']])
                            ->withInput();
            }
        }

        // Validation pour la galerie (images existantes + nouvelles)
        $existingCount = $car->galleries()->count();
        $removeCount = $request->filled('remove_gallery_images') ? count($request->remove_gallery_images) : 0;
        $newCount = $request->hasFile('gallery_images') ? count($request->file('gallery_images')) : 0;
        $finalCount = $existingCount - $removeCount + $newCount;

        if ($finalCount > 4) {
            return back()->withErrors(['gallery_images' => 'Vous ne pouvez avoir que 4 images maximum dans la galerie.'])
                        ->withInput();
        }

        DB::beginTransaction();
        
        try {
            $oldImage = $car->image;

            // Gérer l'upload de la nouvelle image principale
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('cars', 'public');
            }

            // Mettre à jour la voiture
            $car->update($validated);

            // Supprimer l'ancienne image si une nouvelle a été uploadée
            if ($request->hasFile('image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            // Supprimer les images de galerie sélectionnées
            if ($request->filled('remove_gallery_images')) {
                $this->removeGalleryImages($car, $request->remove_gallery_images);
            }

            // Ajouter les nouvelles images de galerie
            if ($request->hasFile('gallery_images')) {
                $this->storeGalleryImages($car, $request->file('gallery_images'));
            }

            DB::commit();

            return redirect()->route('admin.cars.show', $car)->with('success', 'Voiture mise à jour avec succès.');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Nettoyer la nouvelle image en cas d'erreur
            if (isset($validated['image']) && $validated['image'] !== $oldImage) {
                Storage::disk('public')->delete($validated['image']);
            }
            
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Supprime une voiture
     */
    public function destroy(Car $car)
    {
        // Vérifier qu'il n'y a pas de réservations actives ou futures
        $activeReservations = $car->reservations()
            ->whereIn('status', ['active', 'pending'])
            ->count();

        if ($activeReservations > 0) {
            return redirect()->route('admin.cars.index')
                ->with('error', 'Impossible de supprimer une voiture avec des réservations actives ou en attente.');
        }

        DB::beginTransaction();
        
        try {
            // Supprimer les images de la galerie
            foreach ($car->galleries as $gallery) {
                if ($gallery->image_path) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                $gallery->delete();
            }

            // Supprimer l'image principale
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            $carName = $car->getFullName();
            $car->delete();

            DB::commit();

            return redirect()->route('admin.cars.index')->with('success', "Voiture \"{$carName}\" supprimée avec succès.");
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.cars.index')
                ->with('error', 'Une erreur est survenue lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Clone une voiture existante
     */
    public function clone(Car $car)
    {
        DB::beginTransaction();
        
        try {
            $newCar = $car->replicate();
            $newCar->name = $car->name . ' (Copie)';
            $newCar->license_plate = null; // À définir manuellement
            $newCar->status = 'available';
            $newCar->save();

            // Copier les images de galerie
            foreach ($car->galleries as $gallery) {
                $newGallery = $gallery->replicate();
                $newGallery->car_id = $newCar->id;
                $newGallery->save();
            }

            DB::commit();

            return redirect()->route('admin.cars.edit', $newCar)
                ->with('success', 'Voiture dupliquée avec succès. N\'oubliez pas de modifier la plaque d\'immatriculation.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.cars.index')
                ->with('error', 'Une erreur est survenue lors de la duplication : ' . $e->getMessage());
        }
    }

    /**
     * Met à jour rapidement le statut d'une voiture
     */
    public function updateStatus(Request $request, Car $car)
    {
        $request->validate([
            'status' => 'required|in:available,reserved,maintenance'
        ]);

        $canChange = $this->canChangeStatus($car, $request->status);
        
        if (!$canChange['allowed']) {
            return response()->json(['error' => $canChange['message']], 422);
        }

        $car->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès.',
            'new_status' => $car->getStatusLabel(),
            'new_color' => $car->getStatusColor()
        ]);
    }

    /**
     * Obtient les statistiques de pricing pour une voiture
     */
    public function pricingStats(Car $car)
    {
        $simulations = $car->getSimulatedPrices();
        $pricingInfo = $car->getPricingInfo();
        
        return response()->json([
            'pricing_info' => $pricingInfo,
            'simulations' => $simulations
        ]);
    }

    // ========== MÉTHODES PRIVÉES ==========

    /**
     * Stocke les images de la galerie
     */
    private function storeGalleryImages(Car $car, array $images)
    {
        $currentMaxOrder = $car->galleries()->max('sort_order') ?? 0;
        
        foreach ($images as $index => $image) {
            $imagePath = $image->store('cars/gallery', 'public');
            
            CarGallery::create([
                'car_id' => $car->id,
                'image_path' => $imagePath,
                'alt_text' => $car->name . ' - Image ' . ($currentMaxOrder + $index + 1),
                'sort_order' => $currentMaxOrder + $index + 1,
            ]);
        }
    }

    /**
     * Supprime les images de galerie sélectionnées
     */
    private function removeGalleryImages(Car $car, array $galleryIds)
    {
        $galleries = $car->galleries()->whereIn('id', $galleryIds)->get();
        
        foreach ($galleries as $gallery) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->delete();
        }
    }

    /**
     * Vérifie si on peut changer le statut d'une voiture
     */
    private function canChangeStatus(Car $car, string $newStatus): array
    {
        $currentStatus = $car->status;
        
        // Si le statut ne change pas
        if ($currentStatus === $newStatus) {
            return ['allowed' => true];
        }

        // Vérifier les réservations actives
        $hasActiveReservations = $car->activeReservations()->exists();
        $hasUpcomingReservations = $car->upcomingReservations()->exists();

        switch ($newStatus) {
            case 'available':
                if ($hasActiveReservations) {
                    return [
                        'allowed' => false,
                        'message' => 'Impossible de rendre disponible : la voiture a des réservations actives.'
                    ];
                }
                return ['allowed' => true];

            case 'maintenance':
                if ($hasActiveReservations) {
                    return [
                        'allowed' => false,
                        'message' => 'Impossible de mettre en maintenance : la voiture a des réservations actives.'
                    ];
                }
                return ['allowed' => true];

            case 'reserved':
                // Normalement géré automatiquement par les réservations
                return [
                    'allowed' => false,
                    'message' => 'Le statut "réservé" est géré automatiquement par les réservations.'
                ];

            default:
                return ['allowed' => false, 'message' => 'Statut invalide.'];
        }
    }
}