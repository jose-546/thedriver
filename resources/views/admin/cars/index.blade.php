@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-car-front"></i> Gestion des Voitures
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Ajouter une voiture
        </a>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.cars.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Recherche</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nom, marque, modèle...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Tous les statuts</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Réservée</option>
                    <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="brand" class="form-label">Marque</label>
                <input type="text" class="form-control" id="brand" name="brand" 
                       value="{{ request('brand') }}" placeholder="Toyota, Mercedes...">
            </div>
            <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <div class="d-grid gap-1">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                    @if(request()->hasAny(['search', 'status', 'brand']))
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetFilters()">
                            <i class="bi bi-x"></i> Reset
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistiques rapides -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $cars->where('status', 'available')->count() }}</h5>
                        <small>Disponibles</small>
                    </div>
                    <i class="bi bi-check-circle fs-2"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $cars->where('status', 'reserved')->count() }}</h5>
                        <small>Réservées</small>
                    </div>
                    <i class="bi bi-clock fs-2"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $cars->where('status', 'maintenance')->count() }}</h5>
                        <small>Maintenance</small>
                    </div>
                    <i class="bi bi-wrench fs-2"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $cars->total() }}</h5>
                        <small>Total</small>
                    </div>
                    <i class="bi bi-car-front fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des voitures -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            Liste des voitures ({{ $cars->total() }} au total)
        </h5>
    </div>
    <div class="card-body">
        @if($cars->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Marque/Modèle</th>
                            <th>Année</th>
                            <th>Immatriculation</th>
                            <th>Statut</th>
                            <th>Prix journalier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td>
                                @if($car->image)
                                    <img src="{{ $car->getImageUrl() }}" alt="{{ $car->name }}" 
                                         class="rounded" style="width: 60px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 45px;">
                                        <i class="bi bi-car-front text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $car->name }}</strong><br>
                                <small class="text-muted">{{ $car->seats }} places</small>
                            </td>
                            <td>
                                {{ $car->brand }} {{ $car->model }}<br>
                                <small class="text-muted">{{ ucfirst($car->fuel_type) }} - {{ ucfirst($car->transmission) }}</small>
                            </td>
                            <td>{{ $car->year }}</td>
                            <td><code>{{ $car->license_plate }}</code></td>
                            <td>
                                @if($car->status === 'available')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Disponible
                                    </span>
                                @elseif($car->status === 'reserved')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock"></i> Réservée
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-wrench"></i> Maintenance
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($car->daily_price_without_driver && $car->daily_price_with_driver)
                                    <!-- Nouveau système -->
                                    <strong class="text-success">{{ number_format($car->daily_price_without_driver, 0, ',', ' ') }} FCFA</strong><br>
                                    <small class="text-muted">
                                        +{{ number_format($car->daily_price_with_driver - $car->daily_price_without_driver, 0, ',', ' ') }} avec chauffeur
                                    </small>
                                @elseif($car->price_24h && $car->price_24h_with_driver)
                                    <!-- Ancien système (compatibilité) -->
                                    <strong class="text-warning">{{ number_format($car->price_24h, 0, ',', ' ') }} FCFA</strong><br>
                                    <small class="text-muted">
                                        +{{ number_format($car->price_24h_with_driver - $car->price_24h, 0, ',', ' ') }} avec chauffeur
                                    </small>
                                @else
                                    <span class="text-danger">
                                        <i class="bi bi-exclamation-triangle"></i> Prix non défini
                                    </span>
                                @endif
                            </td>
                           
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.cars.show', $car) }}" 
                                       class="btn btn-sm btn-outline-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.cars.edit', $car) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($car->status !== 'reserved')
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $car->id }}" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de suppression -->
                        <div class="modal fade" id="deleteModal{{ $car->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir supprimer la voiture <strong>{{ $car->name }}</strong> ?</p>
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle"></i> 
                                            <strong>Attention :</strong> Cette action supprimera également :
                                            <ul class="mb-0 mt-2">
                                                <li>Toutes les images associées</li>
                                                <li>L'historique des réservations</li>
                                            </ul>
                                        </div>
                                        <p class="text-muted">Cette action est irréversible.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Supprimer définitivement
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $cars->withQueryString()->links() }}
            </div>

            <!-- Actions groupées -->
            @if($cars->where('price_24h')->count() > 0 || $cars->whereNull('daily_price_without_driver')->count() > 0)
                <div class="mt-4 p-3 bg-light rounded">
                    <h6><i class="bi bi-tools"></i> Actions de migration</h6>
                    <div class="row">
                        @if($cars->where('price_24h')->count() > 0)
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>{{ $cars->where('price_24h')->count() }} voiture(s)</strong> utilisent encore l'ancien système de tarification.
                                    <br>
                                    <small>Utilisez l'édition individuelle pour migrer vers le nouveau système.</small>
                                </div>
                            </div>
                        @endif
                        @if($cars->whereNull('daily_price_without_driver')->count() > 0)
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    <i class="bi bi-x-circle"></i>
                                    <strong>{{ $cars->whereNull('daily_price_without_driver')->count() }} voiture(s)</strong> n'ont aucun prix défini.
                                    <br>
                                    <small>Modifiez ces voitures pour définir les prix journaliers.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-car-front fs-1 text-muted"></i>
                <h4 class="mt-3 text-muted">Aucune voiture trouvée</h4>
                @if(request()->hasAny(['search', 'status', 'brand']))
                    <p class="text-muted">Aucun résultat ne correspond à vos critères de recherche.</p>
                    <button type="button" class="btn btn-outline-secondary mb-3" onclick="resetFilters()">
                        <i class="bi bi-x"></i> Effacer les filtres
                    </button>
                @else
                    <p class="text-muted">Commencez par ajouter votre première voiture.</p>
                @endif
                <div>
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Ajouter une voiture
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit du formulaire de recherche avec délai
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const filterForm = document.querySelector('form[action*="cars.index"]');

    if (searchInput && filterForm) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Vérifier que ce n'est pas vide avant de soumettre
                if (this.value.length >= 2 || this.value.length === 0) {
                    filterForm.submit();
                }
            }, 800); // Délai de 800ms pour éviter trop de requêtes
        });
        
        // Empêcher la double soumission
        filterForm.addEventListener('submit', function() {
            clearTimeout(searchTimeout);
        });
    }

    // Gestion du bouton de reset des filtres
    function resetFilters() {
        const url = new URL(window.location);
        url.search = ''; // Supprimer tous les paramètres de recherche
        window.location.href = url.toString();
    }

    // Gestion des changements de statut/marque avec auto-submit
    const statusSelect = document.getElementById('status');
    const brandInput = document.getElementById('brand');

    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            if (filterForm) {
                filterForm.submit();
            }
        });
    }

    // Affichage conditionnel des tooltips pour les badges de migration
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les tooltips Bootstrap si disponible
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });

    // Confirmation améliorée pour la suppression
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const carName = this.closest('.modal-content').querySelector('.modal-body strong').textContent;
            
            // Double confirmation pour les voitures réservées (ne devrait pas arriver mais sécurité)
            const confirmation = confirm(`Voulez-vous vraiment supprimer la voiture "${carName}" ?\n\nCette action est irréversible.`);
            
            if (!confirmation) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection