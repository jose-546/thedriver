@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-car-front"></i> {{ $car->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informations principales -->
    <div class="col-lg-8">
        <!-- Détails de la voiture -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Informations Détaillées
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Marque:</strong><br>
                        <span class="text-muted">{{ $car->brand }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Modèle:</strong><br>
                        <span class="text-muted">{{ $car->model }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Année:</strong><br>
                        <span class="text-muted">{{ $car->year }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Immatriculation:</strong><br>
                        <code class="bg-light p-1">{{ $car->license_plate }}</code>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Nombre de places:</strong><br>
                        <span class="text-muted">{{ $car->seats }} places</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Statut:</strong><br>
                        @if($car->status === 'available')
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-check-circle"></i> Disponible
                            </span>
                        @elseif($car->status === 'reserved')
                            <span class="badge bg-warning fs-6">
                                <i class="bi bi-clock"></i> Réservée
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="bi bi-wrench"></i> Maintenance
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Type de carburant:</strong><br>
                        <span class="text-muted">{{ ucfirst($car->fuel_type) }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Transmission:</strong><br>
                        <span class="text-muted">{{ ucfirst($car->transmission) }}</span>
                    </div>
                    
                    @if($car->description)
                    <div class="col-12 mb-3">
                        <strong>Description:</strong><br>
                        <p class="text-muted mt-2">{{ $car->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grille tarifaire -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-currency-exchange"></i> Tarification Journalière
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person"></i> Sans chauffeur
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-primary mb-2">
                                    {{ number_format($car->daily_price_without_driver, 0, ',', ' ') }}
                                    <small class="text-muted">FCFA</small>
                                </h3>
                                <small class="text-muted">par jour</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person-check"></i> Avec chauffeur
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="text-success mb-2">
                                    {{ number_format($car->daily_price_with_driver, 0, ',', ' ') }}
                                    <small class="text-muted">FCFA</small>
                                </h3>
                                <small class="text-muted">par jour</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Système de réductions -->
                <div class="mt-4">
                    <h6 class="text-info mb-3">
                        <i class="bi bi-percent"></i> Réductions pour location longue durée
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5 class="text-warning">15%</h5>
                                <small class="text-muted">7 à 9 jours</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5 class="text-info">18%</h5>
                                <small class="text-muted">10 à 13 jours</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <h5 class="text-success">20%</h5>
                                <small class="text-muted">14+ jours</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exemples de calculs -->
                <div class="mt-4">
                    <h6 class="text-secondary mb-3">
                        <i class="bi bi-calculator"></i> Exemples de tarification
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Durée</th>
                                    <th>Sans chauffeur</th>
                                    <th>Avec chauffeur</th>
                                    <th>Réduction</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>3 jours</td>
                                    <td>{{ number_format($car->daily_price_without_driver * 3, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($car->daily_price_with_driver * 3, 0, ',', ' ') }} FCFA</td>
                                    <td>Aucune</td>
                                </tr>
                                <tr>
                                    <td>7 jours</td>
                                    <td>
                                        <s class="text-muted">{{ number_format($car->daily_price_without_driver * 7, 0, ',', ' ') }}</s><br>
                                        <strong class="text-success">{{ number_format(($car->daily_price_without_driver * 7) * 0.85, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        <s class="text-muted">{{ number_format($car->daily_price_with_driver * 7, 0, ',', ' ') }}</s><br>
                                        <strong class="text-success">{{ number_format(($car->daily_price_with_driver * 7) * 0.85, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td><span class="badge bg-warning">15%</span></td>
                                </tr>
                                <tr>
                                    <td>14 jours</td>
                                    <td>
                                        <s class="text-muted">{{ number_format($car->daily_price_without_driver * 14, 0, ',', ' ') }}</s><br>
                                        <strong class="text-success">{{ number_format(($car->daily_price_without_driver * 14) * 0.80, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        <s class="text-muted">{{ number_format($car->daily_price_with_driver * 14, 0, ',', ' ') }}</s><br>
                                        <strong class="text-success">{{ number_format(($car->daily_price_with_driver * 14) * 0.80, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td><span class="badge bg-success">20%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des réservations -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Historique des Réservations
                </h5>
                <small class="text-muted">Dernières réservations pour cette voiture</small>
            </div>
            <div class="card-body">
                @if($car->reservations && $car->reservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Période</th>
                                    <th>Durée</th>
                                    <th>Tarif/jour</th>
                                    <th>Réduction</th>
                                    <th>Montant final</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($car->reservations->take(10) as $reservation)
                                <tr>
                                    <td>
                                        <strong>{{ $reservation->user->name }}</strong><br>
                                        <small class="text-muted">{{ $reservation->user->email }}</small>
                                    </td>
                                    <td>
                                        @if($reservation->reservation_start_date && $reservation->reservation_end_date)
                                            {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }}<br>
                                            <small class="text-muted">au {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }}</small>
                                        @else
                                            <!-- Compatibilité avec anciennes données -->
                                            {{ $reservation->start_date?->format('d/m/Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">au {{ $reservation->end_date?->format('d/m/Y H:i') ?? 'N/A' }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->total_days)
                                            {{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}
                                        @else
                                            {{ $reservation->duration ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->daily_rate)
                                            {{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->discount_percentage > 0)
                                            <span class="badge bg-success">{{ $reservation->discount_percentage }}%</span><br>
                                            <small class="text-success">-{{ number_format($reservation->discount_amount, 0, ',', ' ') }} FCFA</small>
                                        @else
                                            <span class="text-muted">Aucune</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->final_total)
                                            <strong>{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</strong>
                                            @if($reservation->subtotal && $reservation->discount_amount > 0)
                                                <br><small class="text-muted">
                                                    ({{ number_format($reservation->subtotal, 0, ',', ' ') }} - {{ number_format($reservation->discount_amount, 0, ',', ' ') }})
                                                </small>
                                            @endif
                                        @else
                                            {{ number_format($reservation->total_price ?? 0, 0, ',', ' ') }} FCFA
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($reservation->status === 'completed')
                                            <span class="badge bg-secondary">Terminée</span>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="badge bg-danger">Annulée</span>
                                        @else
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-clock-history fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Aucune réservation pour cette voiture</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Image de la voiture -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-image"></i> Photo
                </h5>
            </div>
            <div class="card-body text-center">
                @if($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" 
                         class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                @else
                    <div class="bg-light rounded p-5">
                        <i class="bi bi-car-front fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Aucune image</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Actions Rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    
                    @if($car->status === 'available')
                        <button class="btn btn-warning" onclick="changeStatus('maintenance')">
                            <i class="bi bi-wrench"></i> Mettre en maintenance
                        </button>
                    @elseif($car->status === 'maintenance')
                        <button class="btn btn-success" onclick="changeStatus('available')">
                            <i class="bi bi-check"></i> Remettre disponible
                        </button>
                    @endif

                    @if(Route::has('cars.show'))
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-info" target="_blank">
                            <i class="bi bi-eye"></i> Voir côté client
                        </a>
                    @endif

                    @if($car->status !== 'reserved')
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Statistiques
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary">{{ $car->reservations ? $car->reservations->count() : 0 }}</h4>
                        <small class="text-muted">Réservations</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success">
                            @php
                                $totalRevenue = 0;
                                if($car->reservations) {
                                    foreach($car->reservations as $reservation) {
                                        if($reservation->final_total) {
                                            $totalRevenue += $reservation->final_total;
                                        } else {
                                            $totalRevenue += $reservation->total_price ?? 0;
                                        }
                                    }
                                }
                            @endphp
                            {{ number_format($totalRevenue, 0, ',', ' ') }}
                        </h4>
                        <small class="text-muted">FCFA générés</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-info">
                            @php
                                $totalDays = 0;
                                if($car->reservations) {
                                    foreach($car->reservations as $reservation) {
                                        if($reservation->total_days) {
                                            $totalDays += $reservation->total_days;
                                        }
                                    }
                                }
                            @endphp
                            {{ $totalDays }}
                        </h4>
                        <small class="text-muted">Jours loués</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-warning">
                            @php
                                $averageDays = 0;
                                $activeReservations = 0;
                                if($car->reservations) {
                                    foreach($car->reservations as $reservation) {
                                        if($reservation->total_days) {
                                            $averageDays += $reservation->total_days;
                                            $activeReservations++;
                                        }
                                    }
                                    if($activeReservations > 0) {
                                        $averageDays = round($averageDays / $activeReservations, 1);
                                    }
                                }
                            @endphp
                            {{ $averageDays }}
                        </h4>
                        <small class="text-muted">Jours/résa (moy.)</small>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">
                            Ajoutée le {{ $car->created_at->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer définitivement la voiture <strong>{{ $car->name }}</strong> ?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Cette action est irréversible et supprimera également l'historique des réservations.
                </div>
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

@push('scripts')
<script>
        function changeStatus(newStatus) {
        if (confirm('Êtes-vous sûr de vouloir changer le statut de cette voiture ?')) {
            // Créer un formulaire pour envoyer la requête
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.cars.update", $car) }}';
            
            // Ajouter le token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Ajouter la méthode PATCH
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            form.appendChild(methodField);
            
            // Ajouter le nouveau statut
            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = newStatus;
            form.appendChild(statusField);
            
            // Copier les autres champs obligatoires du modèle avec les nouveaux noms
            const carData = {!! json_encode($car->only([
                'name', 'brand', 'model', 'year', 'license_plate', 
                'fuel_type', 'transmission', 'seats', 'description',
                'daily_price_without_driver', 'daily_price_with_driver'
            ])) !!};
            
            Object.keys(carData).forEach(fieldName => {
                if (carData[fieldName] !== null && carData[fieldName] !== undefined) {
                    const field = document.createElement('input');
                    field.type = 'hidden';
                    field.name = fieldName;
                    field.value = carData[fieldName];
                    form.appendChild(field);
                }
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection