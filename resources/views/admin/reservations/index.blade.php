@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-calendar-check"></i> Toutes les Réservations
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.reservations.current') }}" class="btn btn-success">
                <i class="bi bi-clock"></i> En cours
            </a>
            <a href="{{ route('admin.reservations.expired') }}" class="btn btn-warning">
                <i class="bi bi-clock-history"></i> Expirées
            </a>
            <a href="{{ route('admin.reservations.stats') }}" class="btn btn-info">
                <i class="bi bi-graph-up"></i> Statistiques
            </a>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reservations.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Recherche</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Client, voiture...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Statut</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminée</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="with_driver" class="form-label">Chauffeur</label>
                <select class="form-select" id="with_driver" name="with_driver">
                    <option value="">Tous</option>
                    <option value="1" {{ request('with_driver') === '1' ? 'selected' : '' }}>Avec chauffeur</option>
                    <option value="0" {{ request('with_driver') === '0' ? 'selected' : '' }}>Sans chauffeur</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="period" class="form-label">Période</label>
                <select class="form-select" id="period" name="period">
                    <option value="">Toutes</option>
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                    <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Cette semaine</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Ce mois</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="date_from" class="form-label">Du</label>
                <input type="date" class="form-control" id="date_from" name="date_from" 
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label for="date_to" class="form-label">Au</label>
                <input type="date" class="form-control" id="date_to" name="date_to" 
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <label class="form-label d-block">&nbsp;</label>
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            @if(request()->hasAny(['search', 'status', 'with_driver', 'period', 'date_from', 'date_to']))
                <div class="col-md-1">
                    <label class="form-label d-block">&nbsp;</label>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary w-100" title="Réinitialiser">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Statistiques rapides -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">{{ $stats['total'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Total réservations</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ $stats['active'] ?? 0 }}</h3>
                <p class="text-muted mb-0">En cours</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ $stats['completed'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Terminées</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} FCFA</h3>
                <p class="text-muted mb-0">Chiffre d'affaires</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des réservations -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            Liste des réservations
            @if(isset($reservations))
                ({{ $reservations->total() }} au total)
            @endif
        </h5>
    </div>
    <div class="card-body">
        @if(isset($reservations) && $reservations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Réf.</th>
                            <th>Client</th>
                            <th>Voiture</th>
                            <th>Période</th>
                            <th>Durée/Type</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                <code>N°{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</code>
                                <br>
                                <small class="text-muted">{{ $reservation->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <strong>{{ $reservation->user->name }}</strong><br>
                                <small class="text-muted">{{ $reservation->user->email }}</small><br>
                                @if($reservation->user->phone)
                                    <small class="text-muted">{{ $reservation->user->phone }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $reservation->car->name }}</strong><br>
                                <small class="text-muted">{{ $reservation->car->brand }} {{ $reservation->car->model }}</small><br>
                                <code class="small">{{ $reservation->car->license_plate }}</code>
                            </td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }}</strong>
                                @if($reservation->reservation_start_time)
                                    à {{ \Carbon\Carbon::parse($reservation->reservation_start_time)->format('H:i') }}
                                @endif
                                <br>
                                <small class="text-muted">
                                    au {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }}
                                    @if($reservation->reservation_end_time)
                                        à {{ \Carbon\Carbon::parse($reservation->reservation_end_time)->format('H:i') }}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                @if($reservation->discount_percentage > 0)
                                    <br><span class="badge bg-success">-{{ $reservation->discount_percentage }}%</span>
                                @endif
                                <br>
                                @if($reservation->with_driver)
                                    <span class="badge bg-info">
                                        <i class="bi bi-person-check"></i> Avec chauffeur
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-person"></i> Sans chauffeur
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="price-details">
                                    <strong class="text-primary">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</strong>
                                    @if($reservation->discount_amount > 0)
                                        <br>
                                        <small class="text-muted">
                                            <del>{{ number_format($reservation->subtotal, 0, ',', ' ') }} FCFA</del>
                                        </small>
                                        <br>
                                        <small class="text-success">
                                            Économie: {{ number_format($reservation->discount_amount, 0, ',', ' ') }} FCFA
                                        </small>
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        {{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA/jour
                                    </small>
                                </div>
                                <br>
                                @if($reservation->payment_status == 'paid')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Payé
                                    </span>
                                @elseif($reservation->payment_status == 'pending')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock"></i> En attente
                                    </span>
                                @elseif($reservation->payment_status == 'failed')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Échec
                                    </span>
                                @elseif($reservation->payment_status == 'refunded')
                                    <span class="badge bg-info">
                                        <i class="bi bi-arrow-counterclockwise"></i> Remboursé
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-question-circle"></i> Inconnu
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Active
                                    </span>
                                @php
                                    try {
                                        // Gérer le cas où reservation_end_time pourrait contenir une date complète
                                        $timeString = $reservation->reservation_end_time;
                                        if ($timeString && strlen($timeString) > 8) {
                                            // Si c'est une datetime complète, extraire seulement l'heure
                                            $timeString = \Carbon\Carbon::parse($timeString)->format('H:i:s');
                                        }
                                        $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date . ' ' . ($timeString ?? '23:59:59'));
                                        $isExpired = $endDateTime->isPast();
                                    } catch (\Exception $e) {
                                        // En cas d'erreur, considérer comme non expiré
                                        $isExpired = false;
                                    }
                                @endphp
                                    @if($isExpired)
                                        <br><span class="badge bg-warning">Expirée</span>
                                    @endif
                                @elseif($reservation->status === 'completed')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-check-all"></i> Terminée
                                    </span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Annulée
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                       class="btn btn-sm btn-outline-info" title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                               @php
                                    $canMarkCompleted = false;
                                    if($reservation->status === 'active') {
                                        try {
                                            $timeString = $reservation->reservation_end_time;
                                            if ($timeString && strlen($timeString) > 8) {
                                                $timeString = \Carbon\Carbon::parse($timeString)->format('H:i:s');
                                            }
                                            $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date . ' ' . ($timeString ?? '23:59:59'));
                                            $canMarkCompleted = $endDateTime->isPast();
                                        } catch (\Exception $e) {
                                            $canMarkCompleted = false;
                                        }
                                    }
                                @endphp
                                    
                                    @if($canMarkCompleted)
                                        <button class="btn btn-sm btn-outline-success" 
                                                onclick="markAsCompleted({{ $reservation->id }})" 
                                                title="Marquer comme terminée">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    @endif
                                    
                                    @if($reservation->status === 'active')
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="cancelReservation({{ $reservation->id }})" 
                                                title="Annuler">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $reservations->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <h4 class="mt-3 text-muted">Aucune réservation trouvée</h4>
                @if(request()->hasAny(['search', 'status', 'with_driver', 'period', 'date_from', 'date_to']))
                    <p class="text-muted">Aucune réservation ne correspond aux critères de recherche.</p>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Voir toutes les réservations
                    </a>
                @else
                    <p class="text-muted">Les réservations apparaîtront ici une fois qu'elles seront effectuées.</p>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal d'annulation -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Annuler la réservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Raison de l'annulation *</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required 
                                  placeholder="Expliquez pourquoi cette réservation est annulée..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer l'annulation</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .price-details {
        min-width: 120px;
    }
    .badge-sm {
        font-size: 0.65em;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    function markAsCompleted(reservationId) {
        if (confirm('Marquer cette réservation comme terminée ?')) {
            fetch(`/admin/reservations/${reservationId}/make-available`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la mise à jour');
            });
        }
    }

    function cancelReservation(reservationId) {
        const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
        const form = document.getElementById('cancelForm');
        form.action = `/admin/reservations/${reservationId}/cancel`;
        modal.show();
    }

    // Auto-submit du formulaire de recherche avec délai
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });

    // Réinitialisation des filtres de dates
    document.getElementById('period').addEventListener('change', function() {
        if (this.value !== '') {
            document.getElementById('date_from').value = '';
            document.getElementById('date_to').value = '';
        }
    });

    // Soumission automatique pour certains filtres
    ['status', 'with_driver', 'period'].forEach(function(fieldId) {
        document.getElementById(fieldId).addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush
@endsection