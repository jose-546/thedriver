{{-- resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                {{-- Réservations actives --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ auth()->user()->reservations()->active()->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Réservations actives</div>
                    </div>
                </div>

                {{-- Réservations en attente --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ auth()->user()->reservations()->pending()->count() }}
                        </div>
                        <div class="text-sm text-gray-600">En attente de paiement</div>
                    </div>
                </div>

                {{-- Total des réservations --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">
                            {{ auth()->user()->reservations()->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Total réservations</div>
                    </div>
                </div>

                {{-- Montant total dépensé --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">
                            {{ number_format(auth()->user()->reservations()->where('payment_status', 'paid')->sum('total_price'), 0, ',', ' ') }}
                        </div>
                        <div class="text-sm text-gray-600">FCFA dépensés</div>
                    </div>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-car mr-2"></i>
                            Nouvelle réservation
                        </a>
                        <a href="{{ route('reservations.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-list mr-2"></i>
                            Mes réservations
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-user mr-2"></i>
                            Mon profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- Réservations actives avec compte à rebours --}}
            @php
                $activeReservations = auth()->user()->reservations()
                    ->with('car')
                    ->where('status', 'active')
                    ->where('end_date', '>', now())
                    ->orderBy('end_date', 'asc')
                    ->get();
            @endphp

            @if($activeReservations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Réservations en cours</h3>
                        <div class="space-y-4">
                            @foreach($activeReservations as $reservation)
                                <div class="border rounded-lg p-4 bg-gradient-to-r from-blue-50 to-green-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-lg">{{ $reservation->car->getFullName() }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                Active
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Compte à rebours --}}
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium">Temps restant</span>
                                            <span class="text-sm text-gray-600">
                                                Fin: {{ $reservation->end_date->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                        
                                        {{-- Barre de progression --}}
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-1000" 
                                                 style="width: {{ $reservation->getProgressPercentage() }}%"></div>
                                        </div>
                                        
                                        {{-- Affichage du temps restant --}}
                                        <div class="countdown-timer text-center text-2xl font-bold text-blue-600" 
                                             data-reservation-id="{{ $reservation->id }}">
                                            {{ $reservation->getTimeRemaining() }}
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-money-bill-wave mr-1"></i>
                                            {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('reservations.show', $reservation) }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                                Détails
                                            </a>
                                            @if($reservation->end_date->diffInHours(now()) > 1)
                                                <a href="{{ route('reservations.extend.form', $reservation) }}" 
                                                   class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded">
                                                    Prolonger
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Réservations récentes --}}
            @php
                $recentReservations = auth()->user()->reservations()
                    ->with('car')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($recentReservations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Réservations récentes</h3>
                            <a href="{{ route('reservations.index') }}" class="text-blue-600 hover:text-blue-800">
                                Voir tout
                            </a>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentReservations as $reservation)
                                <div class="flex justify-between items-center p-3 border rounded-lg hover:bg-gray-50">
                                    <div>
                                        <h4 class="font-medium">{{ $reservation->car->getFullName() }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $reservation->start_date->format('d/m/Y') }} - 
                                            {{ $reservation->end_date->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($reservation->status === 'active') bg-green-100 text-green-800
                                            @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($reservation->status === 'expired') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            @if($reservation->status === 'active') Active
                                            @elseif($reservation->status === 'pending') En attente
                                            @elseif($reservation->status === 'expired') Expirée
                                            @else {{ ucfirst($reservation->status) }}
                                            @endif
                                        </span>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Script pour le compte à rebours en temps réel --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownTimers = document.querySelectorAll('.countdown-timer');
            
            countdownTimers.forEach(timer => {
                const reservationId = timer.getAttribute('data-reservation-id');
                
                function updateCountdown() {
                    fetch(`/reservations/${reservationId}/time-remaining`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.expired) {
                                timer.textContent = 'Expiré';
                                timer.classList.add('text-red-600');
                                timer.classList.remove('text-blue-600');
                                // Recharger la page après 5 secondes
                                setTimeout(() => location.reload(), 5000);
                            } else {
                                const { days, hours, minutes, seconds } = data;
                                let display = '';
                                
                                if (days > 0) {
                                    display += `${days}j `;
                                }
                                if (hours > 0 || days > 0) {
                                    display += `${hours}h `;
                                }
                                display += `${minutes}m ${seconds}s`;
                                
                                timer.textContent = display;
                                
                                // Changer la couleur si moins de 1 heure
                                if (data.total_seconds < 3600) {
                                    timer.classList.add('text-red-600');
                                    timer.classList.remove('text-blue-600');
                                }
                            }
                        })
                        .catch(error => console.error('Erreur lors de la mise à jour du compte à rebours:', error));
                }
                
                // Mettre à jour toutes les secondes
                setInterval(updateCountdown, 1000);
            });
        });
    </script>
</x-app-layout>