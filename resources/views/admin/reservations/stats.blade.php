@extends('admin.layouts.app')

@section('title', 'Statistiques des réservations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Statistiques des réservations
            <span class="badge bg-info ms-2">Système unifié</span>
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Liste des réservations
            </a>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer
            </button>
        </div>
    </div>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Réservations totales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats->sum('total') }}
                            </div>
                            @if(($newSystemCount ?? 0) > 0)
                                <div class="text-xs text-success">
                                    {{ $newSystemCount }} avec nouveau système
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Revenus totaux
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($monthlyStats->sum('revenue'), 0, ',', ' ') }} FCFA
                            </div>
                            @if(($discountSavings ?? 0) > 0)
                                <div class="text-xs text-warning">
                                    -{{ number_format($discountSavings, 0, ',', ' ') }} FCFA en réductions
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Revenus moyens
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats->count() > 0 ? number_format($monthlyStats->sum('revenue') / $monthlyStats->sum('total'), 0, ',', ' ') : 0 }} FCFA
                            </div>
                            <div class="text-xs text-muted">Par réservation</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Voiture populaire
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $topCars->first()?->reservations_count ?? 0 }}
                            </div>
                            <div class="text-xs text-muted">
                                {{ $topCars->first()?->name ?? 'Aucune' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques du nouveau système -->
    @if(($newSystemCount ?? 0) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-info shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-bar"></i> Statistiques du nouveau système tarifaire
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <h4 class="text-info">{{ $newSystemCount ?? 0 }}</h4>
                            <small class="text-muted">Réservations nouveau système</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4 class="text-success">{{ $discountedReservations ?? 0 }}</h4>
                            <small class="text-muted">Réservations avec réduction</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4 class="text-warning">{{ number_format($averageDiscountPercent ?? 0, 1) }}%</h4>
                            <small class="text-muted">Réduction moyenne</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4 class="text-primary">{{ number_format($averageDuration ?? 0, 1) }}</h4>
                            <small class="text-muted">Durée moyenne (jours)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Graphique des réservations et revenus -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Évolution des réservations et revenus (12 derniers mois)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 400px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Répartition par type de service -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition par type de service</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 300px;">
                        <canvas id="serviceTypeChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-3 mb-2 d-inline-block">
                            <i class="fas fa-circle text-primary"></i>
                            Sans chauffeur ({{ $withoutDriverCount ?? 0 }})
                        </span>
                        <span class="mr-3 mb-2 d-inline-block">
                            <i class="fas fa-circle text-info"></i>
                            Avec chauffeur ({{ $withDriverCount ?? 0 }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition des durées et réductions -->
    @if(($newSystemCount ?? 0) > 0)
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition des durées (nouveau système)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie" style="height: 300px;">
                        <canvas id="durationChart"></canvas>
                    </div>
                    <div class="mt-3 text-center small">
                        @php
                            $durationRanges = [
                                ['label' => '1-6 jours', 'color' => '#4e73df', 'count' => $shortDurationCount ?? 0],
                                ['label' => '7-9 jours (-15%)', 'color' => '#1cc88a', 'count' => $mediumDurationCount ?? 0],
                                ['label' => '10-13 jours (-18%)', 'color' => '#f6c23e', 'count' => $longDurationCount ?? 0],
                                ['label' => '14+ jours (-20%)', 'color' => '#e74a3b', 'count' => $veryLongDurationCount ?? 0]
                            ];
                        @endphp
                        @foreach($durationRanges as $range)
                            <span class="mr-2 mb-2 d-inline-block">
                                <i class="fas fa-circle" style="color: {{ $range['color'] }}"></i>
                                {{ $range['label'] }} ({{ $range['count'] }})
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Impact des réductions</h6>
                </div>
                <div class="card-body">
                    @foreach([
                        ['percentage' => 15, 'range' => '7-9 jours', 'count' => $discount15Count ?? 0, 'savings' => $discount15Savings ?? 0],
                        ['percentage' => 18, 'range' => '10-13 jours', 'count' => $discount18Count ?? 0, 'savings' => $discount18Savings ?? 0],
                        ['percentage' => 20, 'range' => '14+ jours', 'count' => $discount20Count ?? 0, 'savings' => $discount20Savings ?? 0]
                    ] as $discount)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="mb-0">Réduction {{ $discount['percentage'] }}%</h6>
                                    <small class="text-muted">{{ $discount['range'] }}</small>
                                </div>
                                <span class="badge bg-primary">{{ $discount['count'] }} réservations</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" 
                                     role="progressbar" 
                                     style="width: {{ ($newSystemCount ?? 0) > 0 ? ($discount['count'] / $newSystemCount) * 100 : 0 }}%">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    {{ ($newSystemCount ?? 0) > 0 ? number_format(($discount['count'] / $newSystemCount) * 100, 1) : 0 }}% des réservations
                                </small>
                                <small class="text-success">
                                    {{ number_format($discount['savings'], 0, ',', ' ') }} FCFA économisés
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Analyse des durées anciennes (compatibilité) -->
    @if(isset($durationStats) && $durationStats->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-history"></i> Analyse par durée (ancien système)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($durationStats as $stat)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card bg-light border-left-secondary">
                                    <div class="card-body">
                                        <h6 class="text-secondary">{{ ucfirst($stat->duration ?? 'Non défini') }}</h6>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-primary font-weight-bold">{{ $stat->count ?? 0 }}</span>
                                            <small class="text-muted">réservations</small>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <span class="text-success">{{ number_format($stat->avg_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                                            <small class="text-muted">moyenne</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Top 5 des voitures -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 des voitures les plus réservées</h6>
                </div>
                <div class="card-body">
                    @if($topCars->count() > 0)
                        @foreach($topCars as $car)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($car->image)
                                        <img src="{{ Storage::url($car->image) }}" 
                                             alt="{{ $car->name }}" 
                                             class="rounded" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-car text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $car->name }}</h6>
                                    <small class="text-muted">{{ $car->license_plate }}</small>
                                    @if($car->daily_price_without_driver && $car->daily_price_with_driver)
                                        <div class="mt-1">
                                            <small class="badge bg-primary">{{ number_format($car->daily_price_without_driver, 0, ',', ' ') }} FCFA/jour</small>
                                            <small class="badge bg-info">{{ number_format($car->daily_price_with_driver, 0, ',', ' ') }} FCFA/jour</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="h6 mb-0 text-primary">{{ $car->reservations_count }}</div>
                                    <small class="text-muted">réservations</small>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="my-2">
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune donnée disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Comparaison des systèmes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Comparaison des systèmes</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4 class="text-secondary">{{ $oldSystemCount ?? 0 }}</h4>
                                    <small class="text-muted">Ancien système<br>(durées prédéfinies)</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h4 class="text-white">{{ $newSystemCount ?? 0 }}</h4>
                                    <small class="text-white-50">Nouveau système<br>(tarification unifiée)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $totalSystemCount = ($oldSystemCount ?? 0) + ($newSystemCount ?? 0);
                        $migrationRate = $totalSystemCount > 0 ? (($newSystemCount ?? 0) / $totalSystemCount) * 100 : 0;
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Taux d'adoption du nouveau système</small>
                            <small class="text-primary font-weight-bold">{{ number_format($migrationRate, 1) }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $migrationRate }}%"></div>
                        </div>
                    </div>

                    @if(($newSystemCount ?? 0) > 0)
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6 class="text-success mb-2">
                                <i class="fas fa-check-circle"></i> Avantages nouveau système
                            </h6>
                            <ul class="small text-muted mb-0">
                                <li>{{ $discountedReservations ?? 0 }} réservations avec réduction automatique</li>
                                <li>{{ number_format($discountSavings ?? 0, 0, ',', ' ') }} FCFA d'économies pour les clients</li>
                                <li>Tarification transparente et uniforme</li>
                                <li>Réductions automatiques selon la durée</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données depuis le backend
    const monthlyData = {!! json_encode($monthlyStats ?? []) !!};
    const serviceTypeData = {
        withoutDriver: {{ $withoutDriverCount ?? 0 }},
        withDriver: {{ $withDriverCount ?? 0 }}
    };
    const durationRangeData = {
        short: {{ $shortDurationCount ?? 0 }},
        medium: {{ $mediumDurationCount ?? 0 }},
        long: {{ $longDurationCount ?? 0 }},
        veryLong: {{ $veryLongDurationCount ?? 0 }}
    };

    // Graphique mensuel combiné
    if (monthlyData && monthlyData.length > 0) {
        const monthlyCtx = document.getElementById('monthlyChart');
        if (monthlyCtx) {
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => item.month),
                    datasets: [
                        {
                            label: 'Réservations',
                            data: monthlyData.map(item => item.total),
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.1)',
                            yAxisID: 'y',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Revenus (FCFA)',
                            data: monthlyData.map(item => item.revenue),
                            borderColor: '#1cc88a',
                            backgroundColor: 'rgba(28, 200, 138, 0.1)',
                            yAxisID: 'y1',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Nombre de réservations'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Revenus (FCFA)'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    }
                }
            });
        }
    }

    // Graphique type de service
    const serviceTypeCtx = document.getElementById('serviceTypeChart');
    if (serviceTypeCtx && (serviceTypeData.withoutDriver > 0 || serviceTypeData.withDriver > 0)) {
        new Chart(serviceTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sans chauffeur (20k FCFA/jour)', 'Avec chauffeur (30k FCFA/jour)'],
                datasets: [{
                    data: [serviceTypeData.withoutDriver, serviceTypeData.withDriver],
                    backgroundColor: ['#4e73df', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '60%',
            }
        });
    }

    // Graphique durées (nouveau système)
    const durationCtx = document.getElementById('durationChart');
    if (durationCtx && (durationRangeData.short > 0 || durationRangeData.medium > 0 || durationRangeData.long > 0 || durationRangeData.veryLong > 0)) {
        new Chart(durationCtx, {
            type: 'doughnut',
            data: {
                labels: ['1-6 jours', '7-9 jours (-15%)', '10-13 jours (-18%)', '14+ jours (-20%)'],
                datasets: [{
                    data: [durationRangeData.short, durationRangeData.medium, durationRangeData.long, durationRangeData.veryLong],
                    backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#f4b619', '#e02d1b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '60%',
            }
        });
    }
});
</script>
@endpush