@extends('admin.layouts.app')

@section('title', 'Réservations en cours')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Réservations en cours</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Toutes les réservations
            </a>
            <a href="{{ route('admin.reservations.expired') }}" class="btn btn-outline-warning">
                <i class="fas fa-clock"></i> Réservations expirées
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-car"></i> {{ $reservations->total() }} réservation(s) en cours
            </h6>
            <span class="badge bg-success">Actives</span>
        </div>
        <div class="card-body">
            @if($reservations->count() > 0)
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>Information :</strong> Les temps restants et montants affichés incluent les extensions confirmées.
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
                                <th>Temps restant</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                @php
                                    $realEndDate = $reservation->getRealEndDate();
                                    $hasExtensions = $reservation->extensions()->where('payment_status', 'paid')->exists();
                                    $totalPrice = $reservation->getTotalPriceWithExtensions();
                                    $isUrgent = $realEndDate->diffInHours(now()) <= 24;
                                    $timeRemaining = $realEndDate->locale('fr')->diffForHumans(null, true);
                                    
                                    $startDateTime = \Carbon\Carbon::parse($reservation->reservation_start_date);
                                    $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-primary">N°{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</strong>
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
                                                    <i class="fas fa-arrow-right"></i> Fin réelle: {{ $realEndDate->format('d/m/Y H:i') }}
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
                                        
                                        @if($reservation->hasActiveSelfExtension())
                                            <small class="text-warning d-block">
                                                <i class="fas fa-clock"></i> Extension en attente
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $isUrgent ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ $timeRemaining }}
                                        </span>
                                        @if($isUrgent)
                                            <br><small>Restant(e)</small>
                                        @endif
                                        @if($hasExtensions)
                                            <br><small class="text-info">
                                                <i class="fas fa-plus-circle"></i> Avec extensions
                                            </small>
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
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if(!$reservation->hasActiveSelfExtension())
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Annuler la réservation"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#cancelModal{{ $reservation->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @else
                                                <span class="badge bg-warning" title="Annulation bloquée - Extension en attente">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Modal d'annulation -->
                                        @if(!$reservation->hasActiveSelfExtension())
                                        <div class="modal fade" id="cancelModal{{ $reservation->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Annuler la réservation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.reservations.cancel', $reservation) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p class="mb-3">
                                                                Êtes-vous sûr de vouloir annuler la réservation 
                                                                <strong>{{ $reservation->id }}</strong> ?
                                                            </p>
                                                            @if($hasExtensions)
                                                                <div class="alert alert-warning">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    <strong>Attention :</strong> Cette réservation a {{ $extensionsCount }} extension(s) confirmée(s).
                                                                    L'annulation affectera toute la réservation.
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- Récapitulatif des montants -->
                                                            <div class="alert alert-info">
                                                                <strong>Récapitulatif financier :</strong>
                                                                <ul class="mb-0 mt-2">
                                                                    <li>Période : {{ $reservation->total_days }} jour(s) à {{ number_format($reservation->daily_rate, 0, ',', ' ') }} F/jour</li>
                                                                    @if($reservation->discount_amount > 0)
                                                                        <li>Réduction appliquée : -{{ number_format($reservation->discount_amount, 0, ',', ' ') }} F ({{ $reservation->discount_percentage }}%)</li>
                                                                    @endif
                                                                    <li>Montant initial : {{ number_format($reservation->final_total, 0, ',', ' ') }} F</li>
                                                                    @if($hasExtensions)
                                                                        <li>Extensions : +{{ number_format($totalPrice - $reservation->final_total, 0, ',', ' ') }} F</li>
                                                                        <li><strong>Total avec extensions : {{ number_format($totalPrice, 0, ',', ' ') }} F</strong></li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="reason{{ $reservation->id }}" class="form-label">
                                                                    Raison de l'annulation <span class="text-danger">*</span>
                                                                </label>
                                                                <textarea class="form-control" 
                                                                         id="reason{{ $reservation->id }}" 
                                                                         name="reason" 
                                                                         rows="3" 
                                                                         required 
                                                                         placeholder="Expliquez pourquoi cette réservation est annulée..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Fermer
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-times"></i> Annuler la réservation
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
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune réservation en cours</h5>
                    <p class="text-muted">Toutes les réservations sont terminées ou il n'y a pas encore de réservations.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistiques rapides -->
    @if($reservations->count() > 0)
        <div class="row">
            <div class="col-md-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Avec extensions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $reservations->filter(function($r) { return $r->extensions()->where('payment_status', 'paid')->exists(); })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-plus-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Extensions en attente
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $reservations->filter(function($r) { return $r->hasActiveSelfExtension(); })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Avec réductions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $reservations->filter(function($r) { return $r->discount_percentage > 0; })->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percent fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Revenus totaux 
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($reservations->sum(function($r) { return $r->getTotalPriceWithExtensions(); }), 0, ',', ' ') }} F
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh de la page toutes les 5 minutes pour mettre à jour les temps restants
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 minutes
});
</script>
@endpush