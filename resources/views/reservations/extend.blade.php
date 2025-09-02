<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prolonger la réservation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9fafb;
        }
        
        /* Container principal */
        .page-container {
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* En-tête */
        .reservation-header {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .header-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.25rem;
        }
        
        .header-title p {
            color: #4b5563;
            font-size: 1rem;
        }
        
        .header-info {
            text-align: right;
        }
        
        .reservation-number {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }
        
        .reservation-status {
            font-size: 0.875rem;
            font-weight: 500;
            color: #059669;
        }
        
        /* Cartes d'information */
        .info-section {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
        }
        
        /* Grille des dates */
        .dates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .date-card {
            text-align: center;
            padding: 1.5rem 1rem;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        
        .date-card:hover {
            transform: translateY(-2px);
        }
        
        .date-card-start {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
        }
        
        .date-card-current {
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
        }
        
        .date-card-remaining {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
        }
        
        .date-label {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: inherit;
        }
        
        .date-value {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: inherit;
        }
        
        .date-time {
            font-size: 0.875rem;
            color: inherit;
        }
        
        .date-card-start .date-label {
            color: #1d4ed8;
        }
        
        .date-card-current .date-label {
            color: #ea580c;
        }
        
        .date-card-remaining .date-label {
            color: #059669;
        }
        
        .reservation-meta {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 1rem;
        }
        
        /* Message d'erreur */
        .error-alert {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #b91c1c;
            margin-bottom: 1.5rem;
        }
        
        .error-icon {
            flex-shrink: 0;
            margin-right: 0.75rem;
            color: #dc2626;
        }
        
        .error-content h3 {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .error-content p {
            font-size: 0.875rem;
        }
        
        /* Formulaire de nouvelle date */
        .date-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        /* Résumé de l'extension */
        .extension-summary {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            opacity: 0;
            height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .extension-summary.visible {
            opacity: 1;
            height: auto;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            background: linear-gradient(to right, #eff6ff, #eef2ff);
            border-radius: 8px;
            padding: 1.5rem;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-label {
            font-size: 0.875rem;
            color: #4b5563;
        }
        
        .summary-value {
            font-weight: 600;
            margin-top: 0.25rem;
            color: #111827;
        }
        
        .summary-value.new-date {
            color: #1d4ed8;
        }
        
        .summary-value.price {
            color: #059669;
        }
        
        .summary-value.discount {
            color: #dc2626;
        }
        
        /* Checkbox conditions */
        .terms-container {
            display: flex;
            align-items: flex-start;
        }
        
        .terms-checkbox {
            margin-right: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .terms-label {
            font-size: 0.875rem;
            color: #374151;
        }
        
        .terms-link {
            color: #3b82f6;
            text-decoration: underline;
        }
        
        /* Boutons */
        .actions-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        
        .btn-back {
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
        }
        
        .btn-back:hover {
            background-color: #f9fafb;
        }
        
        .btn-submit {
            background-color: #3b82f6;
            color: white;
            border: 1px solid transparent;
        }
        
        .btn-submit:hover {
            background-color: #2563eb;
        }
        
        .btn-submit:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }
        
        .btn-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
        }
        
        /* Compte à rebours */
        .countdown {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .reservation-header {
                flex-direction: column;
                text-align: center;
            }
            
            .header-info {
                text-align: center;
                margin-top: 0.5rem;
            }
            
            .actions-container {
                flex-direction: column-reverse;
                align-items: stretch;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="content-wrapper">
            <!-- En-tête -->
            <div class="reservation-header">
                <div class="header-title">
                    <h1>Prolonger la réservation</h1>
                    <p>{{ $reservation->car->brand }} {{ $reservation->car->model }} - {{ $reservation->car->specification }}</p>
                </div>
                <div class="header-info">
                    <div class="reservation-number">Réservation #{{ $reservation->id }}</div>
                    <div class="reservation-status" style="color: {{ $reservation->getDetailedStatus()['color'] }}">
                        {{ $reservation->getDetailedStatus()['label'] }}
                    </div>
                </div>
            </div>

            <!-- Informations actuelles -->
            <div class="info-section">
                <h2 class="section-title">Réservation actuelle</h2>
                
                <div class="dates-grid">
                    <div class="date-card date-card-start">
                        <div class="date-label">Début</div>
                        <div class="date-value">
                            {{ is_string($reservation->reservation_start_date) ? 
                                \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') : 
                                $reservation->reservation_start_date->format('d/m/Y') }}
                        </div>
                        <div class="date-time">
                            {{ is_string($reservation->reservation_start_time) ? 
                                \Carbon\Carbon::parse($reservation->reservation_start_time)->format('H:i') : 
                                $reservation->reservation_start_time->format('H:i') }}
                        </div>
                    </div>
                    
                    <div class="date-card date-card-current">
                        <div class="date-label">Fin actuelle</div>
                        <div class="date-value">
                            {{ is_string($reservation->reservation_end_date) ? 
                                \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') : 
                                $reservation->reservation_end_date->format('d/m/Y') }}
                        </div>
                        <div class="date-time">
                            {{ is_string($reservation->reservation_end_time) ? 
                                \Carbon\Carbon::parse($reservation->reservation_end_time)->format('H:i') : 
                                $reservation->reservation_end_time->format('H:i') }}
                        </div>
                    </div>
                    
                    <div class="date-card date-card-remaining">
                        <div class="date-label">Temps restant</div>
                        <div class="date-value countdown">{{ $reservation->getRemainingTimeFormatted() }}</div>
                        <div class="date-time">{{ round($reservation->getRemainingHours(), 1) }}h restantes</div>
                    </div>
                </div>
                
                <div class="reservation-meta">
                    <span>Durée actuelle : {{ $reservation->total_days }} jour(s)</span>
                    <span>Prix payé : {{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</span>
                    <span>{{ $reservation->with_driver ? 'Avec chauffeur' : 'Sans chauffeur' }}</span>
                    @if($reservation->discount_percentage > 0)
                        <span>Réduction appliquée : {{ $reservation->discount_percentage }}%</span>
                    @endif
                </div>
            </div>

            @if(!$reservation->canBeExtended())
                <!-- Message d'erreur si la réservation ne peut pas être prolongée -->
                <div class="error-alert">
                    <div class="error-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="error-content">
                        <h3>Prolongation impossible</h3>
                        <p>{{ $reservation->getExtensionErrorMessage() }}</p>
                    </div>
                </div>
            @else
                <!-- Formulaire de prolongation -->
                <form method="POST" action="{{ route('reservations.extend', $reservation) }}" id="extensionForm">
                    @csrf
                    
                    <!-- CHAMP CACHÉ POUR extension_days - CORRECTION PRINCIPALE -->
                    <input type="hidden" id="extension_days" name="extension_days" value="">
                    
                    <!-- Sélection de nouvelle date de fin -->
                    <div class="info-section">
                        <h2 class="section-title">Nouvelle date de fin</h2>
                        
                        <div class="date-selection">
                            <div class="form-group">
                                <label for="new_end_date" class="form-label">Nouvelle date de fin *</label>
                                <input type="date" 
                                id="new_end_date" 
                                name="new_end_date" 
                                min="{{ is_string($reservation->reservation_end_date) ? 
                                        \Carbon\Carbon::parse($reservation->reservation_end_date)->addDay()->format('Y-m-d') : 
                                        $reservation->reservation_end_date->addDay()->format('Y-m-d') }}"
                                required
                                class="form-input">

                            </div>
                            
                            <div class="form-group">
                                <label for="new_end_time" class="form-label">Heure de fin</label>
                                <input type="time" 
                                       id="new_end_time" 
                                       name="new_end_time" 
                                       value="{{ $reservation->reservation_end_time->format('H:i') }}"
                                       class="form-input">
                            </div>
                        </div>
                        
                       <p class="text-sm text-gray-600">
                        La nouvelle date de fin doit être au minimum le {{ is_string($reservation->reservation_end_date) ? 
                            \Carbon\Carbon::parse($reservation->reservation_end_date)->addDay()->format('d/m/Y') : 
                            $reservation->reservation_end_date->addDay()->format('d/m/Y') }}.
                       </p>
                    </div>

                    <!-- Résumé de l'extension -->
                    <div id="extensionSummary" class="extension-summary">
                        <h3 class="section-title">Résumé de l'extension</h3>
                        
                        <div class="summary-grid">
                            <div class="summary-item">
                                <div class="summary-label">Fin actuelle</div>
                                <div class="summary-value">
                                    {{ is_string($reservation->reservation_end_date) ? 
                                        \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y H:i') : 
                                        $reservation->reservation_end_date->format('d/m/Y') }} 
                                    {{ is_string($reservation->reservation_end_time) ? 
                                        \Carbon\Carbon::parse($reservation->reservation_end_time)->format('H:i') : 
                                        $reservation->reservation_end_time->format('H:i') }}
                                </div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Nouvelle fin</div>
                                <div id="newEndDate" class="summary-value new-date">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Jours supplémentaires</div>
                                <div id="additionalDays" class="summary-value">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Sous-total</div>
                                <div id="subtotalAmount" class="summary-value">-</div>
                            </div>
                            <div class="summary-item" id="discountItem" style="display: none;">
                                <div class="summary-label">Réduction</div>
                                <div id="discountAmount" class="summary-value discount">-</div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-label">Prix extension</div>
                                <div id="extensionPrice" class="summary-value price">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations client -->
                    <div class="info-section">
                        <h3 class="section-title">Informations de contact</h3>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="client_email" class="form-label">Email *</label>
                                <input type="email" 
                                       id="client_email" 
                                       name="client_email" 
                                       value="{{ old('client_email', $reservation->client_email) }}"
                                       required
                                       class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="client_phone" class="form-label">Téléphone *</label>
                                <input type="tel" 
                                       id="client_phone" 
                                       name="client_phone" 
                                       value="{{ old('client_phone', $reservation->client_phone) }}"
                                       required
                                       class="form-input">
                            </div>

                                <!-- NOUVEAU CHAMP À AJOUTER -->
                            <div class="form-group">
                                <label for="client_location" class="form-label">Lieu de prise en charge *</label>
                                <input type="text" 
                                    id="client_location" 
                                    name="client_location" 
                                    value="{{ old('client_location', $reservation->client_location) }}"
                                    required
                                    class="form-input"
                                    placeholder="Adresse ou lieu de récupération">
                            </div>

                             <div class="form-group">
                                <label for="deployment_zone" class="form-label">Lieu de prise en charge *</label>
                                <input type="text" 
                                    id="deployment_zone" 
                                    name="deployment_zone" 
                                    value="{{ old('deployment_zone', $reservation->deployment_zone) }}"
                                    required
                                    class="form-input"
                                    placeholder="Adresse ou lieu de récupération">
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="info-section">
                        <div class="terms-container">
                            <input type="checkbox" 
                                   id="terms_accepted" 
                                   name="terms_accepted" 
                                   required
                                   class="terms-checkbox">
                            <label for="terms_accepted" class="terms-label">
                                J'accepte les <a href="#" class="terms-link">conditions générales</a> 
                                et je confirme vouloir prolonger ma réservation. *
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="actions-container">
                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-back">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour
                        </a>
                        
                        <button type="submit" 
                                id="submitButton"
                                disabled
                                class="btn btn-submit">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Procéder au paiement
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const dailyRate = {{ $reservation->with_driver ? $reservation->car->daily_price_with_driver : $reservation->car->daily_price_without_driver }};
            const withDriver = {{ $reservation->with_driver ? 'true' : 'false' }};
            const currentEndDate = new Date('{{ $reservation->reservation_end_date->format('Y-m-d') }}');
            const currentEndTime = '{{ $reservation->reservation_end_time->format('H:i') }}';
            
            // Éléments du DOM
            const newEndDateInput = document.getElementById('new_end_date');
            const newEndTimeInput = document.getElementById('new_end_time');
            const extensionDaysInput = document.getElementById('extension_days'); // NOUVEAU
            const extensionSummary = document.getElementById('extensionSummary');
            const newEndDate = document.getElementById('newEndDate');
            const additionalDays = document.getElementById('additionalDays');
            const subtotalAmount = document.getElementById('subtotalAmount');
            const discountItem = document.getElementById('discountItem');
            const discountAmount = document.getElementById('discountAmount');
            const extensionPrice = document.getElementById('extensionPrice');
            const submitButton = document.getElementById('submitButton');
            const termsCheckbox = document.getElementById('terms_accepted');
            const form = document.getElementById('extensionForm');
            
            // Variables globales
            let calculationData = null;
            let conditionsAccepted = false;
            let isSubmitting = false;
            
            // Fonction pour calculer l'extension
            function calculateExtension() {
                const selectedEndDate = newEndDateInput.value;
                const selectedEndTime = newEndTimeInput.value || currentEndTime;
                
                if (!selectedEndDate) {
                    extensionSummary.classList.remove('visible');
                    extensionDaysInput.value = ''; // NOUVEAU - vider le champ caché
                    return;
                }
                
                const endDate = new Date(selectedEndDate);
                const diffTime = endDate - currentEndDate;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays <= 0) {
                    extensionSummary.classList.remove('visible');
                    extensionDaysInput.value = ''; // NOUVEAU - vider le champ caché
                    return;
                }
                
                // NOUVEAU - mettre à jour le champ caché extension_days
                extensionDaysInput.value = diffDays;
                
                // Calcul du prix
                const subtotal = diffDays * dailyRate;
                
                // Calcul de la réduction basée sur la nouvelle durée totale
                const currentTotalDays = {{ $reservation->total_days }};
                const newTotalDays = currentTotalDays + diffDays;
                let discountPercentage = 0;
                
                if (newTotalDays >= 14) {
                    discountPercentage = 20;
                } else if (newTotalDays >= 10) {
                    discountPercentage = 18;
                } else if (newTotalDays >= 7) {
                    discountPercentage = 15;
                }
                
                const discountAmountValue = (subtotal * discountPercentage) / 100;
                const finalPrice = subtotal - discountAmountValue;
                
                // Mise à jour de l'affichage
                newEndDate.textContent = endDate.toLocaleDateString('fr-FR') + ' ' + selectedEndTime;
                additionalDays.textContent = diffDays + ' jour' + (diffDays > 1 ? 's' : '');
                subtotalAmount.textContent = new Intl.NumberFormat('fr-FR').format(subtotal) + ' FCFA';
                
                if (discountPercentage > 0) {
                    discountItem.style.display = 'block';
                    discountAmount.textContent = '-' + discountPercentage + '% (' + new Intl.NumberFormat('fr-FR').format(discountAmountValue) + ' FCFA)';
                } else {
                    discountItem.style.display = 'none';
                }
                
                extensionPrice.textContent = new Intl.NumberFormat('fr-FR').format(finalPrice) + ' FCFA';
                
                // Stocker les données pour la soumission
                calculationData = {
                    days: diffDays,
                    subtotal: subtotal,
                    discountPercentage: discountPercentage,
                    discountAmount: discountAmountValue,
                    finalPrice: finalPrice,
                    newEndDate: selectedEndDate,
                    newEndTime: selectedEndTime
                };
                
                extensionSummary.classList.add('visible');
                checkFormValidity();
                
                // DEBUG - Log des données calculées
                console.log('Extension calculée:', {
                    diffDays: diffDays,
                    extensionDaysInputValue: extensionDaysInput.value,
                    finalPrice: finalPrice
                });
            }
            
            // Événements pour les champs de date/heure
            newEndDateInput.addEventListener('change', calculateExtension);
            newEndTimeInput.addEventListener('change', calculateExtension);
            
            // Gérer l'acceptation des conditions
            termsCheckbox.addEventListener('change', function() {
                conditionsAccepted = this.checked;
                checkFormValidity();
            });
            
            function checkFormValidity() {
                const clientEmail = document.getElementById('client_email').value.trim();
                const clientPhone = document.getElementById('client_phone').value.trim();
                const clientLocation = document.getElementById('client_location').value.trim(); // NOUVEAU
                const clientDeployement = document.getElementById('deployment_zone').value.trim(); // NOUVEAU
                
                const isValid = calculationData && conditionsAccepted && clientEmail && clientPhone && clientLocation && clientDeployement && !isSubmitting; // Modifié
                submitButton.disabled = !isValid;
            }
            
            // Vérifier la validité lors de la saisie des champs
            document.getElementById('client_email').addEventListener('input', checkFormValidity);
            document.getElementById('client_phone').addEventListener('input', checkFormValidity);
            document.getElementById('client_location').addEventListener('input', checkFormValidity);
            document.getElementById('deployment_zone').addEventListener('input', checkFormValidity);

            
            // Compte à rebours en temps réel
            function updateCountdown() {
                const endDateTime = new Date('{{ $reservation->reservation_end_date->format('Y-m-d') }}T{{ $reservation->reservation_end_time->format('H:i:s') }}');
                const now = new Date();
                const diff = endDateTime - now;
                
                if (diff <= 0) {
                    document.querySelector('.countdown').textContent = 'Expiré';
                    return;
                }
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                
                let timeString = '';
                if (days > 0) timeString += days + 'j-';
                if (hours > 0 || days > 0) timeString += hours + 'h-';
                timeString += minutes + 'm';
                
                document.querySelector('.countdown').textContent = timeString;
            }
            
            // Mettre à jour le compte à rebours toutes les minutes
            updateCountdown();
            setInterval(updateCountdown, 60000);
            
            // Gestion de la soumission du formulaire - CORRIGÉE
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (isSubmitting) {
                    return;
                }
                
                // Validation finale avant soumission
                if (!validateForm()) {
                    return;
                }
                
                // DEBUG - Vérifier les données avant soumission
                console.log('=== SOUMISSION FORMULAIRE ===');
                console.log('extension_days:', extensionDaysInput.value);
                console.log('client_email:', document.getElementById('client_email').value);
                console.log('client_phone:', document.getElementById('client_phone').value);
                console.log('terms_accepted:', termsCheckbox.checked);
                
                // Soumettre le formulaire normalement (pas AJAX)
                form.submit();
            });
            
            function validateForm() {
                const clientEmail = document.getElementById('client_email').value.trim();
                const clientPhone = document.getElementById('client_phone').value.trim();
                const extensionDays = extensionDaysInput.value;
                
                console.log('=== VALIDATION FORMULAIRE ===');
                console.log('Email:', clientEmail);
                console.log('Phone:', clientPhone);
                console.log('Extension days:', extensionDays);
                console.log('Terms accepted:', conditionsAccepted);
                
                if (!clientEmail || !clientPhone) {
                    alert('Veuillez remplir tous les champs obligatoires (email et téléphone)');
                    return false;
                }
                
                if (!extensionDays || extensionDays <= 0) {
                    alert('Veuillez sélectionner une nouvelle date de fin valide.');
                    return false;
                }
                
                if (!conditionsAccepted) {
                    alert('Veuillez accepter les conditions générales.');
                    return false;
                }
                
                return true;
            }
            
            // Vérification initiale de la validité du formulaire
            checkFormValidity();
        });
    </script>
</body>
</html>