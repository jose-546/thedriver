<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Détails de la Réservation #{{ $reservation->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .progress-ring {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        
        .countdown-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .status-active { @apply bg-green-100 text-green-800 border-green-200; }
        .status-pending { @apply bg-yellow-100 text-yellow-800 border-yellow-200; }
        .status-expired { @apply bg-red-100 text-red-800 border-red-200; }
        .status-scheduled { @apply bg-blue-100 text-blue-800 border-blue-200; }
        .status-urgent { @apply bg-red-100 text-red-800 border-red-200 animate-pulse; }
        .status-warning { @apply bg-orange-100 text-orange-800 border-orange-200; }
        .status-confirmed { @apply bg-green-100 text-green-800 border-green-200; }
        .status-cancelled { @apply bg-gray-100 text-gray-800 border-gray-200; }

        .countdown-digits {
            font-family: 'Courier New', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button onclick="history.back()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-900">Détails de la Réservation #{{ $reservation->id }}</h1>
                </div>
                <span id="reservationStatus" class="px-3 py-1 rounded-full text-sm font-medium status-{{ strtolower(str_replace(' ', '-', $reservation->status)) }}">
                    {{ ucfirst($reservation->status) }}
                </span>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Carte de compte à rebours -->
                <div class="countdown-card rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-2">Temps restant</h2>
                            <p class="text-white/80" id="reservationDates">
                                Du {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d M Y') }} à {{ $reservation->reservation_start_time }} 
                                au {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d M Y') }} à {{ $reservation->reservation_end_time }}
                            </p>
                        </div>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16" viewBox="0 0 36 36">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                      fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                                <path id="progressRing" class="progress-ring" 
                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                      fill="none" stroke="white" stroke-width="2" 
                                      stroke-dasharray="100, 100" stroke-dashoffset="0"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-medium" id="progressPercent">0%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Compte à rebours avec jours-heures-minutes-secondes -->
                    <div class="grid grid-cols-4 gap-3 text-center">
                        <div class="bg-white/10 rounded-lg p-3">
                            <div class="text-2xl font-bold countdown-digits" id="daysLeft">--</div>
                            <div class="text-sm text-white/80">Jours</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3">
                            <div class="text-2xl font-bold countdown-digits" id="hoursLeft">--</div>
                            <div class="text-sm text-white/80">Heures</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3">
                            <div class="text-2xl font-bold countdown-digits" id="minutesLeft">--</div>
                            <div class="text-sm text-white/80">Minutes</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3">
                            <div class="text-2xl font-bold countdown-digits" id="secondsLeft">--</div>
                            <div class="text-sm text-white/80">Secondes</div>
                        </div>
                    </div>

                    <!-- Message de statut dynamique -->
                    <div class="mt-4 text-center">
                        <p id="countdownMessage" class="text-white/90 text-sm font-medium"></p>
                    </div>

                    @if($reservation->status === 'active' && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($reservation->reservation_end_date)->setTimeFromTimeString($reservation->reservation_end_time)))
                    <div class="mt-6 text-center">
                        @php
                            $now = \Carbon\Carbon::now();
                            $endDateTime = \Carbon\Carbon::parse($reservation->reservation_end_date)->setTimeFromTimeString($reservation->reservation_end_time);
                            $remainingSeconds = $endDateTime->diffInSeconds($now);
                            $canExtend = $remainingSeconds >= 3600; // >= 1 heure
                        @endphp
                        
                        @if($canExtend)
                            <a href="{{ route('reservations.extend.form', $reservation) }}" 
                               class="inline-block bg-white text-blue-600 py-2 px-6 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                                <i data-lucide="clock" class="w-4 h-4 inline mr-2"></i>
                                Prolonger la réservation
                            </a>
                        @else
                            <span class="inline-block bg-white/20 text-white/60 py-2 px-6 rounded-lg font-medium cursor-not-allowed"
                                  title="Prolongation impossible (moins d'1h restante)">
                                <i data-lucide="clock" class="w-4 h-4 inline mr-2"></i>
                                Prolongation bloquée
                            </span>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Informations de la voiture -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-start space-x-6">
                        @if($reservation->car->image)
                            <img src="{{ Storage::url($reservation->car->image) }}" 
                                 alt="{{ $reservation->car->brand }} {{ $reservation->car->model }}" 
                                 class="w-32 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i data-lucide="car" class="w-8 h-8 text-gray-400"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $reservation->car->brand }} {{ $reservation->car->model }} 
                                @if($reservation->car->year)
                                    ({{ $reservation->car->year }})
                                @endif
                            </h3>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                @if($reservation->car->seats)
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                    <span>{{ $reservation->car->seats }} places</span>
                                </div>
                                @endif
                                @if($reservation->car->fuel_type)
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="fuel" class="w-4 h-4"></i>
                                    <span>{{ $reservation->car->fuel_type }}</span>
                                </div>
                                @endif
                                @if($reservation->car->transmission)
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    <span>{{ $reservation->car->transmission }}</span>
                                </div>
                                @endif
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                    <span>{{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails de la période -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Période de réservation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="calendar" class="w-5 h-5 text-green-500"></i>
                                <div>
                                    <div class="font-medium text-gray-900">Début</div>
                                    <div class="text-gray-600">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }} 
                                        à {{ $reservation->reservation_start_time }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i data-lucide="calendar" class="w-5 h-5 text-red-500"></i>
                                <div>
                                    <div class="font-medium text-gray-900">Fin</div>
                                    <div class="text-gray-600">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }} 
                                        à {{ $reservation->reservation_end_time }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="text-center bg-blue-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-blue-600">{{ $reservation->total_days }}</div>
                                <div class="text-sm text-blue-600">{{ $reservation->total_days > 1 ? 'jours' : 'jour' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extensions -->
                @if(isset($reservation->extensions) && $reservation->extensions->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Extensions</h3>
                    <div class="space-y-3">
                        @foreach($reservation->extensions as $extension)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <div>
                                    <div class="font-medium text-gray-900">Extension #{{ $extension->id }}</div>
                                    <div class="text-sm text-gray-600">
                                        Du {{ \Carbon\Carbon::parse($extension->start_date)->format('d/m/Y H:i') }} 
                                        au {{ \Carbon\Carbon::parse($extension->end_date)->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">{{ number_format($extension->price, 0, ',', ' ') }} FCFA</div>
                                <div class="text-xs {{ $extension->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $extension->status === 'paid' ? 'Payé' : 'En attente' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Résumé de la réservation -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Résumé financier</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Réservation</span>
                            <span class="font-medium">#{{ $reservation->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Durée</span>
                            <span class="font-medium">{{ $reservation->total_days }} {{ $reservation->total_days > 1 ? 'jours' : 'jour' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tarif journalier</span>
                            <span class="font-medium">{{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ number_format($reservation->subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if($reservation->discount_percentage > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Remise ({{ $reservation->discount_percentage }}%)</span>
                            <span>-{{ number_format($reservation->discount_amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        <hr class="my-3">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total final</span>
                            <span class="text-blue-600">{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="mt-3 text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $reservation->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $reservation->payment_status === 'paid' ? 'Payé' : 'En attente de paiement' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ajoutez cette section dans votre sidebar, après la "Résumé financier" -->

<!-- Section Contrat de Réservation -->
<div class="bg-white rounded-xl shadow-sm border p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        <i data-lucide="file-text" class="w-5 h-5 inline mr-2"></i>
        Contrat de Réservation
    </h3>
    
    <div class="space-y-3">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <i data-lucide="info" class="w-5 h-5 text-blue-500 mt-0.5"></i>
                <div class="flex-1">
                    <h4 class="font-medium text-blue-900 mb-1">Votre contrat de location</h4>
                    <p class="text-sm text-blue-700">
                        Consultez ou téléchargez votre contrat officiel de location avec tous les détails de votre réservation.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-2">
            <!-- Bouton Voir le contrat -->
            <a href="{{ route('reservations.contract.preview', $reservation) }}" 
               target="_blank"
               class="flex items-center justify-center w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                Voir le contrat
            </a>
            
            <!-- Bouton Télécharger PDF -->
            <a href="{{ route('reservations.contract.download', $reservation) }}" 
               class="flex items-center justify-center w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Télécharger PDF
            </a>
        </div>

        <div class="text-xs text-gray-500 text-center mt-3">
            <i data-lucide="shield-check" class="w-3 h-3 inline mr-1"></i>
            Document officiel sécurisé
        </div>
    </div>
</div>

                <!-- Informations de contact -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="user" class="w-4 h-4 text-gray-500"></i>
                            <span class="text-sm text-gray-600">{{ $reservation->client_name }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-500"></i>
                            <span class="text-sm text-gray-600">{{ $reservation->client_email }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i data-lucide="phone" class="w-4 h-4 text-gray-500"></i>
                            <span class="text-sm text-gray-600">{{ $reservation->client_phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        @if($reservation->status === 'pending')
                        <button onclick="confirmReservation()" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                            Confirmer la réservation
                        </button>
                        @endif
                        @if(in_array($reservation->status, ['pending', 'active']))
                        <button onclick="cancelReservation()" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                            Annuler la réservation
                        </button>
                        @endif
                        <button onclick="downloadInvoice()" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Télécharger la facture
                        </button>
                        <a href="{{ route('reservations.index') }}" class="block w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors text-center">
                            Retour aux réservations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialiser Lucide
        lucide.createIcons();

        // Démarrer le compte à rebours
        function startCountdown() {
            // Construire les dates correctement avec les nouveaux champs
            const startDateTime = '{{ $reservation->reservation_start_date }}T{{ $reservation->reservation_start_time }}';
            const endDateTime = '{{ $reservation->reservation_end_date }}T{{ $reservation->reservation_end_time }}';
            
            const startDate = new Date(startDateTime);
            const endDate = new Date(endDateTime);
            const circle = document.getElementById('progressRing');
            const circumference = 2 * Math.PI * 15.9155;

            // Initialiser le cercle de progression
            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = circumference;

            function updateCountdown() {
                const now = new Date();
                let diff, totalDiff, elapsed, progress;
                let days, hours, minutes, seconds;
                let message = '';

                if (now >= endDate) {
                    // Réservation expirée
                    document.getElementById('daysLeft').textContent = '00';
                    document.getElementById('hoursLeft').textContent = '00';
                    document.getElementById('minutesLeft').textContent = '00';
                    document.getElementById('secondsLeft').textContent = '00';
                    document.getElementById('progressPercent').textContent = '100%';
                    document.getElementById('countdownMessage').textContent = 'Réservation expirée';
                    updateStatus('expired');
                    return;
                }

                if (now < startDate) {
                    // Réservation pas encore commencée - compte à rebours jusqu'au début
                    diff = startDate - now;
                    totalDiff = endDate - startDate;
                    progress = 0;
                    message = 'Temps avant le début de la réservation';
                    updateStatus('scheduled');
                } else {
                    // Réservation en cours - compte à rebours jusqu'à la fin
                    diff = endDate - now;
                    totalDiff = endDate - startDate;
                    elapsed = now - startDate;
                    progress = Math.min(100, Math.max(0, (elapsed / totalDiff) * 100));
                    message = 'Temps restant avant la fin';
                    
                    // Déterminer le statut selon le temps restant
                    const totalHours = Math.floor(diff / (1000 * 60 * 60));
                    if (totalHours < 1) {
                        updateStatus('urgent');
                    } else if (totalHours < 24) {
                        updateStatus('warning');
                    } else {
                        updateStatus('active');
                    }
                }

                // Calculer jours, heures, minutes, secondes
                days = Math.floor(diff / (1000 * 60 * 60 * 24));
                hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((diff % (1000 * 60)) / 1000);

                // Mettre à jour l'affichage avec zéros de remplissage
                document.getElementById('daysLeft').textContent = String(days).padStart(2, '0');
                document.getElementById('hoursLeft').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutesLeft').textContent = String(minutes).padStart(2, '0');
                document.getElementById('secondsLeft').textContent = String(seconds).padStart(2, '0');
                document.getElementById('progressPercent').textContent = Math.round(progress) + '%';
                document.getElementById('countdownMessage').textContent = message;

                // Mettre à jour le cercle de progression
                const offset = circumference - (progress / 100) * circumference;
                circle.style.strokeDashoffset = offset;
            }

            function updateStatus(status) {
                const statusElement = document.getElementById('reservationStatus');
                let className, text;
                
                switch(status) {
                    case 'scheduled':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-scheduled';
                        text = 'Programmé';
                        break;
                    case 'urgent':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-urgent';
                        text = 'Urgent';
                        break;
                    case 'warning':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-warning';
                        text = 'Attention';
                        break;
                    case 'active':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-active';
                        text = 'En cours';
                        break;
                    case 'expired':
                        className = 'px-3 py-1 rounded-full text-sm font-medium status-expired';
                        text = 'Expiré';
                        break;
                    default:
                        return;
                }
                
                statusElement.textContent = text;
                statusElement.className = className;
            }

            // Mettre à jour immédiatement puis toutes les secondes
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Actions
        function confirmReservation() {
            if (confirm('Confirmer cette réservation ?')) {
                fetch('/reservations/{{ $reservation->id }}/confirm', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la confirmation');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                });
            }
        }

        function cancelReservation() {
            if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                fetch('/reservations/{{ $reservation->id }}/cancel', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'annulation');
                    }
                }).catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                });
            }
        }

        function downloadInvoice() {
            window.open('/reservations/{{ $reservation->id }}/invoice', '_blank');
        }

        // Démarrer le compte à rebours au chargement
        document.addEventListener('DOMContentLoaded', startCountdown);
    </script>
</body>
</html>