@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-pencil-square"></i> Modifier la Voiture
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- Informations générales -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> Informations Générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nom de la voiture <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $car->name) }}" required
                                   placeholder="Ex: Mercedes Classe C Élégante">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Marque <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required
                                   placeholder="Ex: Mercedes-Benz">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Modèle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $car->model) }}" required
                                   placeholder="Ex: Classe C">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">Année <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                   id="year" name="year" value="{{ old('year', $car->year) }}" 
                                   min="1990" max="{{ date('Y') + 1 }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="license_plate" class="form-label">Plaque d'immatriculation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                   id="license_plate" name="license_plate" value="{{ old('license_plate', $car->license_plate) }}" required
                                   placeholder="Ex: AB-123-CD" style="text-transform: uppercase;">
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="seats" class="form-label">Nombre de places <span class="text-danger">*</span></label>
                            <select class="form-select @error('seats') is-invalid @enderror" id="seats" name="seats" required>
                                <option value="">Choisir...</option>
                                @for($i = 2; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ old('seats', $car->seats) == $i ? 'selected' : '' }}>
                                        {{ $i }} places
                                    </option>
                                @endfor
                            </select>
                            @error('seats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fuel_type" class="form-label">Type de carburant <span class="text-danger">*</span></label>
                            <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type" required>
                                <option value="">Choisir...</option>
                                <option value="essence" {{ old('fuel_type', $car->fuel_type) === 'essence' ? 'selected' : '' }}>Essence</option>
                                <option value="diesel" {{ old('fuel_type', $car->fuel_type) === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electrique" {{ old('fuel_type', $car->fuel_type) === 'electrique' ? 'selected' : '' }}>Électrique</option>
                                <option value="hybride" {{ old('fuel_type', $car->fuel_type) === 'hybride' ? 'selected' : '' }}>Hybride</option>
                            </select>
                            @error('fuel_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="transmission" class="form-label">Transmission <span class="text-danger">*</span></label>
                            <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                <option value="">Choisir...</option>
                                <option value="manuelle" {{ old('transmission', $car->transmission) === 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                                <option value="automatique" {{ old('transmission', $car->transmission) === 'automatique' ? 'selected' : '' }}>Automatique</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Choisir...</option>
                                <option value="available" {{ old('status', $car->status) === 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="reserved" {{ old('status', $car->status) === 'reserved' ? 'selected' : '' }}>Réservée</option>
                                <option value="maintenance" {{ old('status', $car->status) === 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4"
                                      placeholder="Description détaillée de la voiture, équipements, etc.">{{ old('description', $car->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarification -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-currency-exchange"></i> Tarification Journalière
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Système de tarification :</strong> Prix par jour avec réductions automatiques selon la durée.
                        <ul class="mb-0 mt-2">
                            <li>7-9 jours : 15% de réduction</li>
                            <li>10-13 jours : 18% de réduction</li>
                            <li>14+ jours : 20% de réduction</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="daily_price_without_driver" class="form-label">Prix par jour sans chauffeur (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('daily_price_without_driver') is-invalid @enderror" 
                                   id="daily_price_without_driver" name="daily_price_without_driver" 
                                   value="{{ old('daily_price_without_driver', $car->daily_price_without_driver ?? 20000) }}" 
                                   min="0" step="1000" required>
                            <div class="form-text">Prix recommandé : 20 000 FCFA</div>
                            @error('daily_price_without_driver')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="daily_price_with_driver" class="form-label">Prix par jour avec chauffeur (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('daily_price_with_driver') is-invalid @enderror" 
                                   id="daily_price_with_driver" name="daily_price_with_driver" 
                                   value="{{ old('daily_price_with_driver', $car->daily_price_with_driver ?? 30000) }}" 
                                   min="0" step="1000" required>
                            <div class="form-text">Prix recommandé : 30 000 FCFA</div>
                            @error('daily_price_with_driver')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Simulateur de prix -->
                        <div class="col-12 mt-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-calculator"></i> Simulateur de prix
                                    </h6>
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label for="simulation_days" class="form-label">Nombre de jours</label>
                                            <input type="number" class="form-control" id="simulation_days" min="1" max="365" value="1">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Prix sans chauffeur</label>
                                            <div class="form-control-plaintext fw-bold text-primary" id="price_simulation_without">
                                                {{ number_format($car->daily_price_without_driver ?? 20000, 0, ',', ' ') }} FCFA
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Prix avec chauffeur</label>
                                            <div class="form-control-plaintext fw-bold text-success" id="price_simulation_with">
                                                {{ number_format($car->daily_price_with_driver ?? 30000, 0, ',', ' ') }} FCFA
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="badge bg-info" id="discount_badge" style="display: none;">-0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Migration des anciens prix (si existants) -->
                    @if($car->price_24h || $car->price_48h || $car->price_72h || $car->price_week)
                        <div class="alert alert-warning mt-4">
                            <h6><i class="bi bi-exclamation-triangle"></i> Anciens tarifs détectés</h6>
                            <p class="mb-2">Cette voiture utilise encore l'ancien système de tarification par durée prédéfinie :</p>
                            <div class="row small">
                                @if($car->price_24h)
                                    <div class="col-md-6">
                                        <strong>24h sans chauffeur:</strong> {{ number_format($car->price_24h, 0, ',', ' ') }} FCFA
                                    </div>
                                @endif
                                @if($car->price_24h_with_driver)
                                    <div class="col-md-6">
                                        <strong>24h avec chauffeur:</strong> {{ number_format($car->price_24h_with_driver, 0, ',', ' ') }} FCFA
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="migrateOldPrices()">
                                    <i class="bi bi-arrow-clockwise"></i> Migrer vers le nouveau système
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Image principale et galerie -->
        <div class="col-lg-4">
            <!-- Image principale -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-image"></i> Image principale
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Image actuelle -->
                    @if($car->image)
                        <div class="mb-3">
                            <label class="form-label">Image actuelle</label>
                            <div class="text-center">
                                <img src="{{ $car->getImageUrl() }}" alt="{{ $car->name }}" 
                                     class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">{{ $car->image ? 'Changer l\'image' : 'Ajouter une image' }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">
                            Formats acceptés: JPG, PNG, GIF. Taille max: 2MB.
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Aperçu de la nouvelle image -->
                    <div id="imagePreview" class="text-center" style="display: none;">
                        <img id="previewImg" src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 200px;">
                        <p class="mt-2 text-muted">Nouvelle image</p>
                    </div>
                </div>
            </div>

            <!-- Galerie d'images -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-images"></i> Galerie d'images
                    </h5>
                    <small class="text-muted">Maximum 4 images total</small>
                </div>
                <div class="card-body">
                    <!-- Images existantes -->
                    @if($car->galleries->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Images actuelles ({{ $car->galleries->count() }}/4)</label>
                            <div class="row g-2">
                                @foreach($car->galleries as $gallery)
                                    <div class="col-6">
                                        <div class="card">
                                            <img src="{{ $gallery->getImageUrl() }}" 
                                                 alt="{{ $gallery->alt_text }}" 
                                                 class="card-img-top" 
                                                 style="height: 100px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="remove_gallery_images[]" 
                                                           value="{{ $gallery->id }}"
                                                           id="remove_{{ $gallery->id }}">
                                                    <label class="form-check-label small text-danger" 
                                                           for="remove_{{ $gallery->id }}">
                                                        Supprimer
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Ajouter de nouvelles images -->
                    @if($car->galleries->count() < 4)
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">
                                {{ $car->galleries->count() > 0 ? 'Ajouter des images' : 'Images de la galerie' }}
                            </label>
                            <input type="file" class="form-control @error('gallery_images') is-invalid @enderror" 
                                   id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                            <div class="form-text">
                                Vous pouvez avoir {{ 4 - $car->galleries->count() }} image(s) supplémentaire(s). 
                                Formats: JPG, PNG, GIF. Taille max: 2MB par image.
                            </div>
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Aperçu des nouvelles images -->
                        <div id="galleryPreview" class="row g-2" style="display: none;"></div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Limite de 4 images atteinte. 
                            Supprimez des images existantes pour en ajouter de nouvelles.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check"></i> Mettre à jour
                        </button>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Aperçu de l'image principale
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Aperçu des images de galerie (seulement si l'input existe)
    const galleryInput = document.getElementById('gallery_images');
    if (galleryInput) {
        galleryInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const preview = document.getElementById('galleryPreview');
            const currentCount = {{ $car->galleries->count() }};
            const maxAllowed = 4 - currentCount;

            // Vérifier la limite
            if (files.length > maxAllowed) {
                alert(`Vous ne pouvez ajouter que ${maxAllowed} image(s) supplémentaire(s).`);
                this.value = '';
                return;
            }

            if (files.length > 0) {
                preview.innerHTML = '';
                preview.style.display = 'flex';

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" alt="Nouvelle image ${index + 1}" style="height: 100px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-success">Nouvelle image ${index + 1}</small>
                                </div>
                            </div>
                        `;
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                preview.style.display = 'none';
            }
        });
    }

    // Synchronisation automatique : prix avec chauffeur = prix sans chauffeur + 10000
    document.getElementById('daily_price_without_driver').addEventListener('input', function() {
        const withoutDriverPrice = parseFloat(this.value) || 0;
        const withDriverInput = document.getElementById('daily_price_with_driver');
        
        if (withoutDriverPrice > 0 && !withDriverInput.dataset.manuallySet) {
            withDriverInput.value = withoutDriverPrice + 10000;
        }
        
        updatePriceSimulation();
    });

    // Marquer comme défini manuellement si l'utilisateur modifie le prix avec chauffeur
    document.getElementById('daily_price_with_driver').addEventListener('input', function() {
        this.dataset.manuallySet = 'true';
        updatePriceSimulation();
    });

    // Simulateur de prix
    document.getElementById('simulation_days').addEventListener('input', updatePriceSimulation);

    function updatePriceSimulation() {
        const days = parseInt(document.getElementById('simulation_days').value) || 1;
        const dailyPriceWithout = parseFloat(document.getElementById('daily_price_without_driver').value) || 0;
        const dailyPriceWith = parseFloat(document.getElementById('daily_price_with_driver').value) || 0;

        // Calculer la réduction
        let discountPercentage = 0;
        if (days >= 14) {
            discountPercentage = 20;
        } else if (days >= 10) {
            discountPercentage = 18;
        } else if (days >= 7) {
            discountPercentage = 15;
        }

        // Calculer les prix
        const subtotalWithout = dailyPriceWithout * days;
        const subtotalWith = dailyPriceWith * days;
        
        const discountAmountWithout = subtotalWithout * (discountPercentage / 100);
        const discountAmountWith = subtotalWith * (discountPercentage / 100);
        
        const finalPriceWithout = subtotalWithout - discountAmountWithout;
        const finalPriceWith = subtotalWith - discountAmountWith;

        // Afficher les résultats
        document.getElementById('price_simulation_without').textContent = 
            formatNumber(finalPriceWithout) + ' FCFA';
        document.getElementById('price_simulation_with').textContent = 
            formatNumber(finalPriceWith) + ' FCFA';

        // Afficher le badge de réduction
        const discountBadge = document.getElementById('discount_badge');
        if (discountPercentage > 0) {
            discountBadge.textContent = `-${discountPercentage}%`;
            discountBadge.style.display = 'inline';
        } else {
            discountBadge.style.display = 'none';
        }
    }

    function formatNumber(number) {
        return Math.round(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    // Migration des anciens prix
    function migrateOldPrices() {
        const oldPrice24h = {{ $car->price_24h ?? 0 }};
        const oldPrice24hWithDriver = {{ $car->price_24h_with_driver ?? 0 }};
        
        if (oldPrice24h > 0) {
            document.getElementById('daily_price_without_driver').value = oldPrice24h;
            document.getElementById('daily_price_without_driver').dispatchEvent(new Event('input'));
        }
        
        if (oldPrice24hWithDriver > 0) {
            document.getElementById('daily_price_with_driver').value = oldPrice24hWithDriver;
            document.getElementById('daily_price_with_driver').dataset.manuallySet = 'true';
            document.getElementById('daily_price_with_driver').dispatchEvent(new Event('input'));
        }
        
        alert('Prix migrés avec succès ! Vérifiez les valeurs et enregistrez.');
    }

    // Formatage de la plaque d'immatriculation
    document.getElementById('license_plate').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Initialiser la simulation
    updatePriceSimulation();
</script>
@endpush
@endsection