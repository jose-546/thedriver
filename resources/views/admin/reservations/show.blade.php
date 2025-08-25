@extends('admin.layouts.app')

@section('title', 'Détails de la réservation #' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                Réservation N°{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}
                @if($reservation->reservation_start_date)
                    <span class="badge bg-primary ms-2">Nouveau système</span>
                @else
                    <span class="badge bg-secondary ms-2">Ancien système</span>
                @endif
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">Réservations</a></li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            @if($reservation->status === 'active' && $isExpired)
                <form action="{{ route('admin.reservations.make-available', $reservation) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Confirmer la remise en disponibilité ?')">
                        <i class="fas fa-check"></i> Rendre disponible
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la réservation</h6>
                    @if($reservation->status === 'active')
                        @if($isExpired)
                            <span class="badge bg-danger">Expirée</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    @elseif($reservation->status === 'completed')
                        <span class="badge bg-secondary">Terminée</span>
                    @elseif($reservation->status === 'cancelled')
                        <span class="badge bg-danger">Annulée</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Détails de la réservation</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Numéro :</strong></td>
                                    <td>{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date de création :</strong></td>
                                    <td>{{ $reservation->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                @if($reservation->reservation_start_date)
                                    {{-- Nouveau système --}}
                                    <tr>
                                        <td><strong>Durée totale :</strong></td>
                                        <td>
                                            <span class="fw-bold">{{ $reservation->total_days }} jour{{ $reservation->total_days > 1 ? 's' : '' }}</span>
                                            @if($reservation->discount_percentage > 0)
                                                <br><span class="badge bg-success">Réduction -{{ $reservation->discount_percentage }}%</span>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    {{-- Ancien système - Compatibilité --}}
                                    <tr>
                                        <td><strong>Durée :</strong></td>
                                        <td>
                                            @if(isset($reservation->duration))
                                                {{ ucfirst($reservation->duration) }}
                                            @else
                                                @php
                                                    $startDate = $reservation->start_date ?? $reservation->created_at;
                                                    $endDate = $reservation->end_date ?? $reservation->created_at->addDay();
                                                    $diffInDays = $startDate->diffInDays($endDate);
                                                    if ($diffInDays < 1) {
                                                        echo $startDate->diffInHours($endDate) . ' heure(s)';
                                                    } else {
                                                        echo $diffInDays . ' jour(s)';
                                                    }
                                                @endphp
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Avec chauffeur :</strong></td>
                                    <td>
                                        @if($reservation->with_driver)
                                            <span class="badge bg-info">Oui</span>
                                        @else
                                            <span class="badge bg-secondary">Non</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Montant total :</strong></td>
                                    <td>
                                        @if($reservation->final_total)
                                            {{-- Nouveau système --}}
                                            <strong class="text-success">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</strong>
                                        @elseif($reservation->total_price)
                                            {{-- Ancien système --}}
                                            <strong class="text-success">{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</strong>
                                        @else
                                            <strong class="text-muted">Non défini</strong>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Période de location</h6>
                            <table class="table table-borderless">
                                @if($reservation->reservation_start_date)
                                    {{-- Nouveau système --}}
                                    <tr>
                                        <td><strong>Début :</strong></td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }}
                                            @if($reservation->reservation_start_time)
                                                à {{ \Carbon\Carbon::parse($reservation->reservation_start_time)->format('H:i') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fin prévue :</strong></td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }}
                                            @if($reservation->reservation_end_time)
                                                à {{ \Carbon\Carbon::parse($reservation->reservation_end_time)->format('H:i') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Durée totale :</strong></td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->locale('fr')->diffForHumans(\Carbon\Carbon::parse($reservation->reservation_end_date), true) }}
                                        </td>
                                    </tr>
                                    @if($reservation->status === 'active' && !$isExpired)
                                        <tr>
                                            <td><strong>Temps restant :</strong></td>
                                            <td>
                                                <span class="badge bg-success">{{ $timeRemaining }}</span>
                                            </td>
                                        </tr>
                                    @elseif($reservation->status === 'active' && $isExpired)
                                        <tr>
                                            <td><strong>Dépassement :</strong></td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    @php
                                                        $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date . ' ' . ($reservation->reservation_end_time ?? '23:59:59'));
                                                        echo $endDateTime->locale('fr')->diffForHumans(now(), true);
                                                    @endphp
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    {{-- Ancien système - Compatibilité --}}
                                    <tr>
                                        <td><strong>Début :</strong></td>
                                        <td>
                                            @if($reservation->start_date)
                                                {{ $reservation->start_date->format('d/m/Y à H:i') }}
                                            @else
                                                {{ $reservation->created_at->format('d/m/Y à H:i') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fin prévue :</strong></td>
                                        <td>
                                            @if($reservation->end_date)
                                                {{ $reservation->end_date->format('d/m/Y à H:i') }}
                                            @else
                                                @php
                                                    $startDate = $reservation->start_date ?? $reservation->created_at;
                                                    echo $startDate->addDay()->format('d/m/Y à H:i');
                                                @endphp
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Durée totale :</strong></td>
                                        <td>
                                            @php
                                                $startDate = $reservation->start_date ?? $reservation->created_at;
                                                $endDate = $reservation->end_date ?? $startDate->copy()->addDay();
                                            @endphp
                                            {{ $startDate->locale('fr')->diffForHumans($endDate, true) }}
                                        </td>
                                    </tr>
                                    @if($reservation->status === 'active' && !$isExpired)
                                        <tr>
                                            <td><strong>Temps restant :</strong></td>
                                            <td>
                                                <span class="badge bg-success">{{ $timeRemaining }}</span>
                                            </td>
                                        </tr>
                                    @elseif($reservation->status === 'active' && $isExpired)
                                        <tr>
                                            <td><strong>Dépassement :</strong></td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    @php
                                                        $endDate = $reservation->end_date ?? $reservation->created_at->addDay();
                                                        echo $endDate->locale('fr')->diffForHumans(now(), true);
                                                    @endphp
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- Détails de calcul pour nouveau système --}}
                    @if($reservation->reservation_start_date && $reservation->total_days)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Détails du calcul tarifaire</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tr>
                                                        <td><strong>Tarif journalier :</strong></td>
                                                        <td>{{ number_format($reservation->daily_rate ?? 0, 0, ',', ' ') }} FCFA/jour</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nombre de jours :</strong></td>
                                                        <td>{{ $reservation->total_days }} jour(s)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Type de service :</strong></td>
                                                        <td>
                                                            @if($reservation->with_driver)
                                                                <span class="badge bg-info">Avec chauffeur (30 000 FCFA/jour)</span>
                                                            @else
                                                                <span class="badge bg-secondary">Sans chauffeur (20 000 FCFA/jour)</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tr>
                                                        <td><strong>Sous-total :</strong></td>
                                                        <td>{{ number_format($reservation->subtotal ?? 0, 0, ',', ' ') }} FCFA</td>
                                                    </tr>
                                                    @if($reservation->discount_percentage > 0)
                                                        <tr>
                                                            <td><strong>Réduction ({{ $reservation->discount_percentage }}%) :</strong></td>
                                                            <td class="text-success">-{{ number_format($reservation->discount_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                                                        </tr>
                                                    @endif
                                                    <tr class="border-top">
                                                        <td><strong>Montant final :</strong></td>
                                                        <td><strong class="text-primary">{{ number_format($reservation->final_total ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        @if($reservation->discount_percentage > 0)
                                            <div class="mt-2">
                                                <small class="text-success">
                                                    <i class="fas fa-info-circle"></i>
                                                    @if($reservation->discount_percentage == 15)
                                                        Réduction de 15% appliquée pour une durée de 7 à 9 jours
                                                    @elseif($reservation->discount_percentage == 18)
                                                        Réduction de 18% appliquée pour une durée de 10 à 13 jours
                                                    @elseif($reservation->discount_percentage == 20)
                                                        Réduction de 20% appliquée pour une durée de 14 jours ou plus
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($reservation->status === 'cancelled')
                        <div class="alert alert-danger mt-3">
                            <h6><i class="fas fa-times-circle"></i> Réservation annulée</h6>
                            <p class="mb-1"><strong>Date d'annulation :</strong> {{ $reservation->cancelled_at?->format('d/m/Y à H:i') }}</p>
                            @if($reservation->cancellation_reason)
                                <p class="mb-0"><strong>Raison :</strong> {{ $reservation->cancellation_reason }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations sur la voiture -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Voiture réservée</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($reservation->car->image)
                                <img src="{{ Storage::url($reservation->car->image) }}" 
                                     alt="{{ $reservation->car->name }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-car fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $reservation->car->name }}</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Marque :</strong> {{ $reservation->car->brand }}</p>
                                    <p class="mb-1"><strong>Modèle :</strong> {{ $reservation->car->model }}</p>
                                    <p class="mb-1"><strong>Année :</strong> {{ $reservation->car->year }}</p>
                                    <p class="mb-1"><strong>Immatriculation :</strong> {{ $reservation->car->license_plate }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Carburant :</strong> {{ ucfirst($reservation->car->fuel_type) }}</p>
                                    <p class="mb-1"><strong>Transmission :</strong> {{ ucfirst($reservation->car->transmission) }}</p>
                                    <p class="mb-1"><strong>Places :</strong> {{ $reservation->car->seats }}</p>
                                    <p class="mb-1">
                                        <strong>Statut actuel :</strong> 
                                        <span class="badge bg-{{ $reservation->car->status === 'available' ? 'success' : ($reservation->car->status === 'reserved' ? 'warning' : 'danger') }}">
                                            @if($reservation->car->status === 'available')
                                                Disponible
                                            @elseif($reservation->car->status === 'reserved')
                                                Réservé
                                            @elseif($reservation->car->status === 'maintenance')
                                                Maintenance
                                            @else
                                                {{ ucfirst($reservation->car->status) }}
                                            @endif
                                        </span>
                                    </p>
                                    {{-- Prix journalier avec nouveau système --}}
                                    @if($reservation->reservation_start_date)
                                        <p class="mb-1">
                                            <strong>Prix journalier :</strong>
                                            <span class="text-success fw-bold">
                                                @if($reservation->with_driver)
                                                    {{ number_format($reservation->car->daily_price_with_driver ?? 30000, 0, ',', ' ') }} FCFA/jour
                                                @else
                                                    {{ number_format($reservation->car->daily_price_without_driver ?? 20000, 0, ',', ' ') }} FCFA/jour
                                                @endif
                                            </span>
                                        </p>
                                    @else
                                        {{-- Ancien système - afficher l'ancien prix si disponible --}}
                                        <p class="mb-1">
                                            <strong>Prix appliqué :</strong>
                                            <span class="text-success fw-bold">
                                                {{ number_format($reservation->total_price ?? 0, 0, ',', ' ') }} FCFA
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec informations client et actions -->
        <div class="col-lg-4">
            <!-- Informations client -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations client</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    </div>
                    <h6 class="text-center">{{ $reservation->user->name }}</h6>
                    <hr>
                    <p class="mb-2">
                        <strong><i class="fas fa-envelope text-muted"></i> Email :</strong><br>
                        <a href="mailto:{{ $reservation->user->email }}">{{ $reservation->user->email }}</a>
                    </p>
                    @if($reservation->user->phone)
                        <p class="mb-2">
                            <strong><i class="fas fa-phone text-muted"></i> Téléphone :</strong><br>
                            <a href="tel:{{ $reservation->user->phone }}">{{ $reservation->user->phone }}</a>
                        </p>
                    @endif
                    @if($reservation->user->address)
                        <p class="mb-2">
                            <strong><i class="fas fa-map-marker-alt text-muted"></i> Adresse :</strong><br>
                            {{ $reservation->user->address }}
                        </p>
                    @endif
                    <p class="mb-0">
                        <strong><i class="fas fa-calendar text-muted"></i> Membre depuis :</strong>
                        {{ $reservation->user->created_at->locale('fr')->isoFormat('MMMM YYYY') }}
                    </p>
                </div>
            </div>

            <!-- Actions rapides -->
            @if($reservation->status === 'active')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($isExpired)
                                <form action="{{ route('admin.reservations.make-available', $reservation) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Confirmer la remise en disponibilité ?')">
                                        <i class="fas fa-check"></i> Rendre disponible
                                    </button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="fas fa-times"></i> Annuler la réservation
                            </button>
                            <a href="mailto:{{ $reservation->user->email }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope"></i> Contacter le client
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistiques du client -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historique client</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $userHistory->count() + 1 }}</h4>
                                <small class="text-muted">Réservations</small>
                            </div>
                        </div>
                        <div class="col-6">
                            @php
                                // Calcul du total avec compatibilité ancien/nouveau système
                                $currentTotal = $reservation->final_total ?? $reservation->total_price ?? 0;
                                $historyTotal = $userHistory->sum(function($hist) {
                                    return $hist->final_total ?? $hist->total_price ?? 0;
                                });
                                $grandTotal = $currentTotal + $historyTotal;
                            @endphp
                            <h4 class="text-success">{{ number_format($grandTotal, 0, ',', ' ') }} FCFA</h4>
                            <small class="text-muted">Total dépensé</small>
                        </div>
                    </div>
                    
                    @if($userHistory->count() > 0)
                        <hr>
                        <h6 class="text-muted mb-3">Réservations précédentes</h6>
                        @foreach($userHistory->take(3) as $hist)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <small class="text-muted">{{ $hist->car->name }}</small><br>
                                    <small class="text-muted">{{ $hist->created_at->format('d/m/Y') }}</small>
                                </div>
                                <span class="badge bg-{{ $hist->status === 'completed' ? 'success' : ($hist->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($hist->status) }}
                                </span>
                            </div>
                        @endforeach
                        @if($userHistory->count() > 3)
                            <small class="text-muted">Et {{ $userHistory->count() - 3 }} autre(s)...</small>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'annulation -->
<div class="modal fade" id="cancelModal" tabindex="-1">
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
                        <strong>#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</strong> ?
                    </p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">
                            Raison de l'annulation <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" 
                                 id="reason" 
                                 name="reason" 
                                 rows="3" 
                                 required 
                                 placeholder="Expliquez pourquoi cette réservation est annulée..."></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Attention :</strong> Cette action remettra automatiquement la voiture en disponibilité.
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
@endsection