@extends('admin.layouts.app')

@section('title', 'Réservations expirées')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Réservations expirées</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Toutes les réservations
            </a>
            <a href="{{ route('admin.reservations.current') }}" class="btn btn-outline-success">
                <i class="fas fa-clock"></i> Réservations en cours
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ $reservations->total() }} réservation(s) expirée(s)
            </h6>
            <span class="badge bg-warning text-dark">À traiter</span>
        </div>
        <div class="card-body">
            @if($reservations->count() > 0)
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>Information :</strong> Ces réservations ont dépassé leur durée prévue (extensions incluses). 
                    Utilisez le bouton "Rendre disponible" pour remettre les voitures en circulation.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Réservation</th>
                                <th>Client</th>
                                <th>Voiture</th>
                                <th>Période</th>
                                <th>Extensions</th>
                                <th>Dépassement</th>
                                <th>Montant Total</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                @php
                                    $realEndDate = $reservation->getRealEndDate();
                                    $hasExtensions = $reservation->extensions()->where('payment_status', 'paid')->exists();
                                    $totalPrice = $reservation->getTotalPriceWithExtensions();
                                    
                                    // Calcul des dates de début et fin avec les nouveaux champs
                                    $startDateTime = \Carbon\Carbon::parse($reservation->reservation_start_date . ' ' . $reservation->reservation_start_time);
                                    $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date . ' ' . $reservation->reservation_end_time);
                                @endphp
                                <tr class="{{ $reservation->status === 'active' ? 'table-warning' : '' }}">
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-primary">#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                            <small class="text-muted">{{ $reservation->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $reservation->user->name }}</strong>
                                            <small class="text-muted">{{ $reservation->user->email }}</small>
                                            @if($reservation->user->phone)
                                                <small class="text-muted">
                                                    <i class="fas fa-phone"></i> {{ $reservation->user->phone }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $reservation->car->name }}</strong>
                                            <small class="text-muted">{{ $reservation->car->license_plate }}</small>
                                            @if($reservation->with_driver)
                                                <span class="badge bg-info">Avec chauffeur</span>
                                            @else
                                                <span class="badge bg-secondary">Sans chauffeur</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</strong>
                                            <small class="text-muted">
                                                Du {{ $startDateTime->format('d/m/Y H:i') }}
                                            </small>
                                            <small class="text-muted">
                                                Au {{ $endDateTime->format('d/m/Y H:i') }}
                                            </small>
                                            @if($reservation->discount_percentage > 0)
                                                <small class="text-success">
                                                    <i class="fas fa-percent"></i> Réduction {{ $reservation->discount_percentage }}%
                                                </small>
                                            @endif
                                            @if($hasExtensions)
                                                <small class="text-info">
                                                    <i class="fas fa-arrow-right"></i> Fin réelle: {{ $realEndDate->locale('fr')->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($hasExtensions)
                                            @php
                                                $extensionsCount = $reservation->extensions()->where('payment_status', 'paid')->count();
                                                $totalExtensionHours = $reservation->getTotalDurationWithExtensions() - $reservation->getTotalDurationHours();
                                            @endphp
                                            <span class="badge bg-success">
                                                {{ $extensionsCount }} extension(s)
                                            </span>
                                            <small class="text-muted d-block">
                                                +{{ $totalExtensionHours }}h supplémentaires
                                            </small>
                                        @else
                                            <span class="badge bg-secondary">Aucune</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->status === 'active')
                                            @php
                                                $overdue = $realEndDate->locale('fr')->diffForHumans(now(), true);
                                            @endphp
                                            <span class="badge bg-danger">
                                                Dépassé de {{ $overdue }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Terminée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-success">{{ number_format($totalPrice, 0, ',', ' ') }} F</strong>
                                            
                                            @if($reservation->discount_amount > 0)
                                                <small class="text-muted">
                                                    Sous-total: {{ number_format($reservation->subtotal, 0, ',', ' ') }} F
                                                </small>
                                                <small class="text-success">
                                                    Économie: -{{ number_format($reservation->discount_amount, 0, ',', ' ') }} F
                                                </small>
                                            @endif
                                            
                                            @if($hasExtensions)
                                                <small class="text-muted">
                                                    Initial: {{ number_format($reservation->final_total, 0, ',', ' ') }} F
                                                </small>
                                                <small class="text-success">
                                                    Extensions: {{ number_format($totalPrice - $reservation->final_total, 0, ',', ' ') }} F
                                                </small>
                                            @endif
                                            
                                            <small class="text-muted">
                                                {{ number_format($reservation->daily_rate, 0, ',', ' ') }} F/jour
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($reservation->status === 'active')
                                            <div class="d-flex flex-column">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation-triangle"></i> Expirée
                                                </span>
                                                @if($hasExtensions)
                                                    <small class="text-info mt-1">Avec extensions</small>
                                                @endif
                                                @if($reservation->discount_percentage > 0)
                                                    <small class="text-success mt-1">
                                                        <i class="fas fa-tag"></i> {{ $reservation->discount_percentage }}% off
                                                    </small>
                                                @endif
                                            </div>
                                        @elseif($reservation->status === 'completed')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Terminée
                                            </span>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Annulée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($reservation->status === 'active' && !$reservation->hasActiveSelfExtension())
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Rendre disponible"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#makeAvailableModal{{ $reservation->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif($reservation->hasActiveSelfExtension())
                                                <span class="badge bg-info" title="Extension en attente">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Modal de confirmation pour rendre disponible -->
                                        @if($reservation->status === 'active' && !$reservation->hasActiveSelfExtension())
                                        <div class="modal fade" id="makeAvailableModal{{ $reservation->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Terminer la réservation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.reservations.make-available', $reservation) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p class="mb-3">
                                                                Voulez-vous terminer la réservation <strong>#{{ $reservation->id }}</strong> 
                                                                et rendre la voiture <strong>{{ $reservation->car->name }}</strong> disponible ?
                                                            </p>
                                                            
                                                            <!-- Récapitulatif de la réservation -->
                                                            <div class="alert alert-info">
                                                                <strong>Récapitulatif :</strong>
                                                                <ul class="mb-0 mt-2">
                                                                    <li>Client : {{ $reservation->user->name }}</li>
                                                                    <li>Période : {{ $reservation->total_days }} jour(s) à {{ number_format($reservation->daily_rate, 0, ',', ' ') }} F/jour</li>
                                                                    @if($reservation->discount_amount > 0)
                                                                        <li>Réduction appliquée : -{{ number_format($reservation->discount_amount, 0, ',', ' ') }} F ({{ $reservation->discount_percentage }}%)</li>
                                                                    @endif
                                                                    <li>Montant initial : {{ number_format($reservation->final_total, 0, ',', ' ') }} F</li>
                                                                    @if($hasExtensions)
                                                                        <li>Extensions : {{ $extensionsCount }} extension(s) (+{{ number_format($totalPrice - $reservation->final_total, 0, ',', ' ') }} F)</li>
                                                                        <li><strong>Total final : {{ number_format($totalPrice, 0, ',', ' ') }} F</strong></li>
                                                                    @endif
                                                                    <li>Dépassement : {{ $realEndDate->locale('fr')->diffForHumans(now(), true) }}</li>
                                                                </ul>
                                                            </div>

                                                            @if($hasExtensions)
                                                                <div class="alert alert-warning">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    <strong>Attention :</strong> Cette réservation a {{ $extensionsCount }} extension(s) confirmée(s).
                                                                    La finalisation terminera définitivement toute la réservation.
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Annuler
                                                            </button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-check"></i> Terminer et rendre disponible
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-muted">Aucune réservation expirée</h5>
                    <p class="text-muted">Toutes les réservations sont à jour ou ont été traitées.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions en lot -->
    @if($reservations->count() > 0)
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Actions en lot</h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Vous pouvez traiter plusieurs réservations expirées en même temps.
                    <strong>Attention :</strong> Seules les réservations sans extensions en attente seront traitées.
                </p>
                
                <!-- Statistiques rapides -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x me-3"></i>
                            <div>
                                <div class="h5 mb-0">{{ $reservations->where('status', 'active')->count() }}</div>
                                <small class="text-muted">Réservations actives expirées</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-percent text-success fa-2x me-3"></i>
                            <div>
                                <div class="h5 mb-0">{{ $reservations->filter(function($r) { return $r->discount_percentage > 0; })->count() }}</div>
                                <small class="text-muted">Avec réductions appliquées</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dollar-sign text-info fa-2x me-3"></i>
                            <div>
                                <div class="h5 mb-0">{{ number_format($reservations->sum(function($r) { return $r->getTotalPriceWithExtensions(); }), 0, ',', ' ') }} F</div>
                                <small class="text-muted">Revenus totaux</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-success" onclick="markAllAvailable()">
                        <i class="fas fa-check-double"></i> Rendre toutes disponibles
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="exportExpired()">
                        <i class="fas fa-download"></i> Exporter la liste
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal de confirmation pour actions en lot -->
<div class="modal fade" id="bulkActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation d'actions en lot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir rendre toutes les voitures expirées disponibles ?</p>
                <p class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette action affectera <span id="expiredCount">0</span> réservation(s).
                </p>
                <p class="text-info">
                    <i class="fas fa-info-circle"></i>
                    Les réservations avec extensions en attente seront ignorées.
                </p>
                
                <!-- Récapitulatif financier -->
                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-chart-line"></i> Impact financier estimé :</h6>
                    <ul class="mb-0">
                        <li>Réservations avec réductions : <span id="discountedReservations">0</span></li>
                        <li>Total des économies clients : <span id="totalSavings">0</span> F</li>
                        <li>Revenus totaux concernés : <span id="totalRevenue">0</span> F</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="confirmBulkAction()">
                    <i class="fas fa-check"></i> Confirmer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAllAvailable() {
    // Compter seulement les réservations actives sans extensions en attente
    const expiredCount = {{ $reservations->where('status', 'active')->filter(function($reservation) { 
        return !$reservation->hasActiveSelfExtension(); 
    })->count() }};
    
    const discountedCount = {{ $reservations->where('status', 'active')->filter(function($reservation) { 
        return $reservation->discount_percentage > 0; 
    })->count() }};
    
    const totalSavings = {{ $reservations->where('status', 'active')->sum('discount_amount') }};
    const totalRevenue = {{ $reservations->where('status', 'active')->sum(function($r) { return $r->getTotalPriceWithExtensions(); }) }};
    
    document.getElementById('expiredCount').textContent = expiredCount;
    document.getElementById('discountedReservations').textContent = discountedCount;
    document.getElementById('totalSavings').textContent = new Intl.NumberFormat('fr-FR').format(totalSavings);
    document.getElementById('totalRevenue').textContent = new Intl.NumberFormat('fr-FR').format(totalRevenue);
    
    if (expiredCount > 0) {
        new bootstrap.Modal(document.getElementById('bulkActionModal')).show();
    } else {
        alert('Aucune réservation expirée disponible pour traitement (vérifiez les extensions en attente).');
    }
}

function confirmBulkAction() {
    // Cette fonction sera implémentée si nécessaire
    alert('Fonctionnalité en cours de développement');
    bootstrap.Modal.getInstance(document.getElementById('bulkActionModal')).hide();
}

function exportExpired() {
    // Cette fonction sera implémentée si nécessaire
    alert('Export en cours de développement');
}
</script>
@endpush