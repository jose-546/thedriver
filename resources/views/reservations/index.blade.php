@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Messages de succès/erreur --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Statistiques rapides --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ $activeReservations->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Réservations actives</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ $pendingReservations->count() }}
                        </div>
                        <div class="text-sm text-gray-600">En attente de paiement</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-gray-600">
                            {{ $pastReservations->total() }}
                        </div>
                        <div class="text-sm text-gray-600">Réservations terminées</div>
                    </div>
                </div>
            </div>

            {{-- Réservations en attente de paiement --}}
            @if($pendingReservations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-yellow-600">
                            <i class="fas fa-clock mr-2"></i>
                            Réservations en attente de paiement
                        </h3>
                        <div class="space-y-4">
                            @foreach($pendingReservations as $reservation)
                                <div class="border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded-r-lg">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <img src="{{ $reservation->car->getImageUrl() }}" 
                                                     alt="{{ $reservation->car->getFullName() }}" 
                                                     class="w-16 h-16 object-cover rounded-lg mr-4">
                                                <div>
                                                    <h4 class="font-semibold text-lg">{{ $reservation->car->getFullName() }}</h4>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Période:</span>
                                                    <div class="font-medium">
                                                        {{ $reservation->start_date->format('d/m/Y H:i') }} - 
                                                        {{ $reservation->end_date->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Durée:</span>
                                                    <div class="font-medium">{{ $reservation->duration }}</div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Prix:</span>
                                                    <div class="font-medium text-lg">
                                                        {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 lg:mt-0 lg:ml-4">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="#" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-center">
                                                    <i class="fas fa-credit-card mr-2"></i>
                                                    Payer maintenant
                                                </a>
                                                <button onclick="cancelReservation({{ $reservation->id }})" 
                                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Annuler
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Réservations actives --}}
            @if($activeReservations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-green-600">
                            <i class="fas fa-car mr-2"></i>
                            Réservations actives
                        </h3>
                        <div class="space-y-4">
                            @foreach($activeReservations as $reservation)
                                <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-lg">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <img src="{{ $reservation->car->getImageUrl() }}" 
                                                     alt="{{ $reservation->car->getFullName() }}" 
                                                     class="w-16 h-16 object-cover rounded-lg mr-4">
                                                <div>
                                                    <h4 class="font-semibold text-lg">{{ $reservation->car->getFullName() }}</h4>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-4">
                                                <div>
                                                    <span class="text-gray-500">Période:</span>
                                                    <div class="font-medium">
                                                        {{ $reservation->start_date->format('d/m/Y H:i') }} - 
                                                        {{ $reservation->end_date->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Durée:</span>
                                                    <div class="font-medium">{{ $reservation->duration }}</div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Prix:</span>
                                                    <div class="font-medium text-lg">
                                                        {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Compte à rebours --}}
                                            <div class="bg-white p-3 rounded-lg border">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-sm font-medium">Temps restant</span>
                                                    <span class="text-sm text-gray-600">
                                                        Fin: {{ $reservation->end_date->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                
                                                {{-- Barre de progression --}}
                                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-1000" 
                                                         style="width: {{ $reservation->getProgressPercentage() }}%"></div>
                                                </div>
                                                
                                                {{-- Affichage du temps restant --}}
                                                <div class="countdown-timer text-center text-xl font-bold text-green-600" 
                                                     data-reservation-id="{{ $reservation->id }}"
                                                     data-end-date="{{ $reservation->end_date->toISOString() }}">
                                                    {{ $reservation->getTimeRemaining() }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 lg:mt-0 lg:ml-4">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('reservations.show', $reservation) }}" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    Détails
                                                </a>
                                                @if($reservation->end_date->diffInHours(now()) > 2)
                                                    <a href="#" 
                                                       class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-center">
                                                        <i class="fas fa-clock mr-2"></i>
                                                        Prolonger
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Réservations passées --}}
            @if($pastReservations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-600">
                            <i class="fas fa-history mr-2"></i>
                            Historique des réservations
                        </h3>
                        <div class="space-y-4">
                            @foreach($pastReservations as $reservation)
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <img src="{{ $reservation->car->getImageUrl() }}" 
                                                     alt="{{ $reservation->car->getFullName() }}" 
                                                     class="w-16 h-16 object-cover rounded-lg mr-4">
                                                <div>
                                                    <h4 class="font-semibold text-lg">{{ $reservation->car->getFullName() }}</h4>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Période:</span>
                                                    <div class="font-medium">
                                                        {{ $reservation->start_date->format('d/m/Y') }} - 
                                                        {{ $reservation->end_date->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Durée:</span>
                                                    <div class="font-medium">{{ $reservation->duration }}</div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Prix:</span>
                                                    <div class="font-medium">
                                                        {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Statut:</span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($reservation->status === 'completed') bg-green-100 text-green-800
                                                        @elseif($reservation->status === 'expired') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        @if($reservation->status === 'completed') 
                                                            <i class="fas fa-check-circle mr-1"></i> Terminée
                                                        @elseif($reservation->status === 'expired') 
                                                            <i class="fas fa-times-circle mr-1"></i> Expirée
                                                        @else 
                                                            {{ ucfirst($reservation->status) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 lg:mt-0 lg:ml-4">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('reservations.show', $reservation) }}" 
                                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-center">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    Voir détails
                                                </a>
                                                @if($reservation->contract_pdf_path)
                                                    <a href="{{ route('reservations.download-contract', $reservation) }}" 
                                                       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">
                                                        <i class="fas fa-file-pdf mr-2"></i>
                                                        Contrat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $pastReservations->links() }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Message si aucune réservation --}}
            @if($activeReservations->count() === 0 && $pendingReservations->count() === 0 && $pastReservations->count() === 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-gray-400 text-6xl mb-4">
                            <i class="fas fa-car-side"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucune réservation trouvée</h3>
                        <p class="text-gray-500 mb-4">Vous n'avez pas encore effectué de réservation.</p>
                        <a href="{{ route('home') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-car mr-2"></i>
                            Découvrir nos voitures
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Compte à rebours en temps réel
        document.addEventListener('DOMContentLoaded', function() {
            const countdownTimers = document.querySelectorAll('.countdown-timer');
            
            countdownTimers.forEach(timer => {
                const endDate = new Date(timer.getAttribute('data-end-date'));
                
                function updateCountdown() {
                    const now = new Date();
                    const diff = endDate - now;
                    
                    if (diff <= 0) {
                        timer.textContent = 'Expiré';
                        timer.classList.add('text-red-600');
                        timer.classList.remove('text-green-600');
                        return;
                    }
                    
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    let display = '';
                    if (days > 0) display += `${days}j `;
                    if (hours > 0 || days > 0) display += `${hours}h `;
                    display += `${minutes}m ${seconds}s`;
                    
                    timer.textContent = display;
                    
                    // Changer la couleur si moins de 1 heure
                    if (diff < 3600000) {
                        timer.classList.add('text-red-600');
                        timer.classList.remove('text-green-600');
                    }
                }
                
                // Mettre à jour toutes les secondes
                setInterval(updateCountdown, 1000);
                updateCountdown(); // Premier appel immédiat
            });
        });

        // Fonction pour annuler une réservation
        function cancelReservation(reservationId) {
            if (confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                fetch(`/reservations/${reservationId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'annulation: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur s\'est produite lors de l\'annulation.');
                });
            }
        }
    </script>
    @endsection