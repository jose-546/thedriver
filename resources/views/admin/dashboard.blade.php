@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-download"></i> Exporter
            </button>
        </div>
    </div>
</div>

<!-- Statistiques principales -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Voitures</h6>
                        <h2 class="mb-0">{{ $stats['total_cars'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-car-front fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Voitures Disponibles</h6>
                        <h2 class="mb-0 text-success">{{ $stats['available_cars'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Voitures Réservées</h6>
                        <h2 class="mb-0 text-warning">{{ $stats['reserved_cars'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock fs-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Clients</h6>
                        <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques des réservations -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Réservations En Cours</h6>
                        <h2 class="mb-0">{{ $stats['current_reservations'] }}</h2>
                        <small class="text-muted">Réservations actives</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar-check fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Réservations</h6>
                        <h2 class="mb-0">{{ $stats['total_reservations'] }}</h2>
                        <small class="text-muted">Toutes les réservations</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-graph-up fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Avec Réductions</h6>
                        <h2 class="mb-0 text-info">{{ $stats['discounted_reservations'] ?? 0 }}</h2>
                        <small class="text-muted">Réductions appliquées</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-percent fs-1 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques financières -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Revenus du Mois</h6>
                        <h2 class="mb-0 text-success">{{ number_format($stats['monthly_revenue'] ?? 0, 0, ',', ' ') }} FCFA</h2>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::now()->locale('fr')->monthName }} {{ \Carbon\Carbon::now()->year }}
                        </small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Économies Clients</h6>
                        <h2 class="mb-0 text-warning">{{ number_format($stats['total_savings'] ?? 0, 0, ',', ' ') }} FCFA</h2>
                        <small class="text-muted">Total des réductions accordées</small>
                        @if(($stats['average_discount'] ?? 0) > 0)
                            <div class="mt-1">
                                <small class="badge bg-warning">
                                    Moyenne: {{ number_format($stats['average_discount'], 1) }}%
                                </small>
                            </div>
                        @endif
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-tag fs-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Répartition des tarifs -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i> Répartition Sans/Avec Chauffeur
                </h5>
                <small class="text-muted">20 000 FCFA sans • 30 000 FCFA avec chauffeur (par jour)</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">{{ $stats['without_driver_reservations'] ?? 0 }}</h4>
                        <small class="text-muted">Sans chauffeur<br><strong>20 000 FCFA/jour</strong></small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info">{{ $stats['with_driver_reservations'] ?? 0 }}</h4>
                        <small class="text-muted">Avec chauffeur<br><strong>30 000 FCFA/jour</strong></small>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="progress" style="height: 10px;">
                        @php
                            $total = ($stats['without_driver_reservations'] ?? 0) + ($stats['with_driver_reservations'] ?? 0);
                            $withoutDriverPercent = $total > 0 ? (($stats['without_driver_reservations'] ?? 0) / $total) * 100 : 0;
                            $withDriverPercent = $total > 0 ? (($stats['with_driver_reservations'] ?? 0) / $total) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-primary" style="width: {{ $withoutDriverPercent }}%"></div>
                        <div class="progress-bar bg-info" style="width: {{ $withDriverPercent }}%"></div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between small text-muted">
                        <span>{{ number_format($withoutDriverPercent, 1) }}% sans chauffeur</span>
                        <span>{{ number_format($withDriverPercent, 1) }}% avec chauffeur</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Répartition des Réductions
                </h5>
                <small class="text-muted">Système de réduction automatique par durée</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-success">{{ $stats['discount_15_percent'] ?? 0 }}</h4>
                        <small class="text-muted"><strong>-15%</strong><br>(7-9 jours)</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning">{{ $stats['discount_18_percent'] ?? 0 }}</h4>
                        <small class="text-muted"><strong>-18%</strong><br>(10-13 jours)</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger">{{ $stats['discount_20_percent'] ?? 0 }}</h4>
                        <small class="text-muted"><strong>-20%</strong><br>(14+ jours)</small>
                    </div>
                </div>
                @if(($stats['discount_15_percent'] ?? 0) + ($stats['discount_18_percent'] ?? 0) + ($stats['discount_20_percent'] ?? 0) > 0)
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="bi bi-info-circle"></i>
                            {{ number_format((($stats['discount_15_percent'] ?? 0) + ($stats['discount_18_percent'] ?? 0) + ($stats['discount_20_percent'] ?? 0)) / max(1, $stats['total_reservations']) * 100, 1) }}% 
                            des réservations bénéficient d'une réduction
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Durées moyennes -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body text-center">
                <h6 class="card-title text-muted">Durée Moyenne</h6>
                <h3 class="mb-0 text-primary">{{ number_format($stats['average_duration'] ?? 0, 1) }}</h3>
                <small class="text-muted">jours par réservation</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body text-center">
                <h6 class="card-title text-muted">Réservation Moyenne</h6>
                <h3 class="mb-0 text-success">{{ number_format($stats['average_reservation_value'] ?? 0, 0, ',', ' ') }} FCFA</h3>
                <small class="text-muted">valeur moyenne</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card card-stat h-100">
            <div class="card-body text-center">
                <h6 class="card-title text-muted">Taux d'Occupation</h6>
                <h3 class="mb-0 text-warning">{{ number_format($stats['occupation_rate'] ?? 0, 1) }}%</h3>
                <small class="text-muted">du parc automobile</small>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Actions Rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary w-100 p-3">
                            <i class="bi bi-plus-circle"></i><br>
                            Ajouter une voiture
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reservations.current') }}" class="btn btn-success w-100 p-3">
                            <i class="bi bi-clock"></i><br>
                            Réservations en cours
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reservations.expired') }}" class="btn btn-warning w-100 p-3">
                            <i class="bi bi-exclamation-triangle"></i><br>
                            Réservations expirées
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reservations.stats') }}" class="btn btn-info w-100 p-3">
                            <i class="bi bi-graph-up"></i><br>
                            Voir les statistiques
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dernières voitures ajoutées -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-car-front"></i> Dernières Voitures Ajoutées
                </h5>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-outline-primary">
                    Voir toutes
                </a>
            </div>
            <div class="card-body">
                @if($recentCars->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Marque</th>
                                    <th>Année</th>
                                    <th>Statut</th>
                                    <th>Tarifs Journaliers</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCars as $car)
                                <tr>
                                    <td>
                                        @if($car->image)
                                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="rounded" style="width: 50px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                                <i class="bi bi-car-front text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->brand }}</td>
                                    <td>{{ $car->year }}</td>
                                    <td>
                                        @if($car->status === 'available')
                                            <span class="badge bg-success">Disponible</span>
                                        @elseif($car->status === 'reserved')
                                            <span class="badge bg-warning">Réservée</span>
                                        @else
                                            <span class="badge bg-danger">Maintenance</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">Sans chauffeur:</small>
                                            <strong class="text-primary">20 000 FCFA/jour</strong>
                                            <small class="text-muted">Avec chauffeur:</small>
                                            <strong class="text-info">30 000 FCFA/jour</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.cars.show', $car) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-car-front fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">Aucune voiture enregistrée</p>
                        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Ajouter la première voiture
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Actualiser les statistiques toutes les 5 minutes
    setInterval(function() {
        // Vérifier si la page est visible avant de recharger
        if (!document.hidden) {
            location.reload();
        }
    }, 300000); // 5 minutes

    // Animation des chiffres au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.card-stat h2, .card-stat h3');
        
        counters.forEach(counter => {
            const target = parseInt(counter.innerText.replace(/\s/g, ''));
            if (!isNaN(target) && target > 0) {
                let current = 0;
                const increment = target / 20;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.innerText = Math.floor(current).toLocaleString('fr-FR');
                }, 50);
            }
        });
    });
</script>
@endpush
@endsection