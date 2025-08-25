<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Location - {{ $contract_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #860000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #860000;
            margin-bottom: 10px;
        }
        
        .contract-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        
        .contract-number {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
        
        .parties {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .party {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding: 15px;
            border: 1px solid #ddd;
            margin-right: 2%;
        }
        
        .party-title {
            font-weight: bold;
            font-size: 16px;
            color: #860000;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        .info-row {
            margin-bottom: 8px;
        }
        
        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .car-details {
            background-color: #f8f9fa;
            border: 2px solid #860000;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .car-details h3 {
            color: #860000;
            margin-top: 0;
            font-size: 18px;
        }
        
        .car-specs {
            display: table;
            width: 100%;
        }
        
        .car-spec {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
        }
        
        .spec-label {
            font-weight: bold;
            color: #666;
            font-size: 12px;
        }
        
        .spec-value {
            font-size: 14px;
            margin-top: 5px;
        }
        
        .rental-details {
            background-color: #f0f8ff;
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .financial-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .financial-table th,
        .financial-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        .financial-table th {
            background-color: #860000;
            color: white;
            font-weight: bold;
        }
        
        .financial-table .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .terms {
            margin-top: 30px;
        }
        
        .terms h3 {
            color: #860000;
            border-bottom: 2px solid #860000;
            padding-bottom: 5px;
        }
        
        .terms ul {
            padding-left: 20px;
        }
        
        .terms li {
            margin-bottom: 8px;
        }
        
        .signatures {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        
        .signature-block {
            display: table-cell;
            width: 48%;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
        }
        
        .date-place {
            text-align: center;
            margin: 30px 0 20px 0;
            font-style: italic;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-active { background-color: #d4edda; color: #155724; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-expired { background-color: #f8d7da; color: #721c24; }
        
        .discount-row {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- En-tête du contrat -->
    <div class="header">
        <div class="company-name">RENTALY</div>
        <div style="font-size: 14px; color: #666;">Plateforme de Location de Véhicules</div>
        <div class="contract-title">CONTRAT DE LOCATION DE VÉHICULE</div>
        <div class="contract-number">
            Contrat N° {{ $contract_number }}<br>
            Généré le {{ $generated_at->format('d/m/Y à H:i') }}
        </div>
    </div>

    <!-- Informations des parties -->
    <div class="parties">
        <div class="party" style="float: left; width: 48%;">
            <div class="party-title">🏢 LE BAILLEUR</div>
            <div class="info-row">
                <span class="label">Société :</span> RENTALY
            </div>
            <div class="info-row">
                <span class="label">Adresse :</span> Cotonou, Bénin
            </div>
            <div class="info-row">
                <span class="label">Téléphone :</span> +229 XX XX XX XX
            </div>
            <div class="info-row">
                <span class="label">Email :</span> contact@rentaly.com
            </div>
        </div>
        
        <div class="party" style="float: right; width: 48%;">
            <div class="party-title">👤 LE LOCATAIRE</div>
            <div class="info-row">
                <span class="label">Nom :</span> {{ $client->name }}
            </div>
            <div class="info-row">
                <span class="label">Email :</span> {{ $reservation->client_email }}
            </div>
            <div class="info-row">
                <span class="label">Téléphone :</span> {{ $reservation->client_phone }}
            </div>
            <div class="info-row">
                <span class="label">Position :</span> {{ $reservation->client_location }}
            </div>
            <div class="info-row">
                <span class="label">Zone :</span> {{ $reservation->deployment_zone }}
            </div>
        </div>
    </div>
    
    <div style="clear: both;"></div>

    <!-- Détails du véhicule -->
    <div class="car-details">
        <h3>🚗 VÉHICULE LOUÉ</h3>
        <div class="info-row">
            <span class="label">Véhicule :</span> {{ $car->brand }} {{ $car->model }} 
            @if($car->year) ({{ $car->year }}) @endif
        </div>
        
        <div class="car-specs">
            <div class="car-spec">
                <div class="spec-label">PLACES</div>
                <div class="spec-value">{{ $car->seats ?? 'N/A' }}</div>
            </div>
            <div class="car-spec">
                <div class="spec-label">CARBURANT</div>
                <div class="spec-value">{{ $car->fuel_type ?? 'N/A' }}</div>
            </div>
            <div class="car-spec">
                <div class="spec-label">TRANSMISSION</div>
                <div class="spec-value">{{ $car->transmission ?? 'N/A' }}</div>
            </div>
            <div class="car-spec">
                <div class="spec-label">CHAUFFEUR</div>
                <div class="spec-value">{{ $reservation->with_driver ? 'INCLUS' : 'EXCLU' }}</div>
            </div>
        </div>
    </div>

    <!-- Détails de la location -->
    <div class="rental-details">
        <h3 style="color: #007bff; margin-top: 0;">📅 PÉRIODE DE LOCATION</h3>
        <div style="display: table; width: 100%;">
            <div style="display: table-cell; width: 50%;">
                <div class="info-row">
                    <span class="label">Début :</span> {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }} à {{ $reservation->reservation_start_time }}
                </div>
                <div class="info-row">
                    <span class="label">Fin :</span> {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }} à {{ $reservation->reservation_end_time }}
                </div>
            </div>
            <div style="display: table-cell; width: 50%; text-align: center;">
                <div style="background: white; border: 2px solid #007bff; border-radius: 8px; padding: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $reservation->total_days }}</div>
                    <div style="color: #666;">{{ $reservation->total_days > 1 ? 'JOURS' : 'JOUR' }}</div>
                </div>
            </div>
        </div>
        
        <div class="info-row" style="margin-top: 15px;">
            <span class="label">Statut :</span> 
            <span class="status-badge status-{{ strtolower($reservation->status) }}">
                {{ ucfirst($reservation->status) }}
            </span>
        </div>
    </div>

    <!-- Détails financiers -->
    <table class="financial-table">
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th style="text-align: center;">QUANTITÉ</th>
                <th style="text-align: right;">PRIX UNITAIRE</th>
                <th style="text-align: right;">MONTANT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Location {{ $reservation->with_driver ? 'avec chauffeur' : 'sans chauffeur' }}
                    <br><small style="color: #666;">{{ $car->brand }} {{ $car->model }}</small>
                </td>
                <td style="text-align: center;">{{ $reservation->total_days }} jour(s)</td>
                <td style="text-align: right;">{{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA</td>
                <td style="text-align: right;">{{ number_format($reservation->subtotal, 0, ',', ' ') }} FCFA</td>
            </tr>
            
            @if($reservation->discount_percentage > 0)
            <tr class="discount-row">
                <td colspan="3">Réduction ({{ $reservation->discount_percentage }}%)</td>
                <td style="text-align: right;">- {{ number_format($reservation->discount_amount, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td colspan="3"><strong>MONTANT TOTAL TTC</strong></td>
                <td style="text-align: right; font-size: 18px; color: #860000;">
                    <strong>{{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Termes et conditions -->
    <div class="terms">
        <h3>📋 TERMES ET CONDITIONS</h3>
        
        <h4 style="color: #333; margin-top: 20px;">1. Obligations du Locataire</h4>
        <ul>
            <li><strong>Documents requis :</strong> Présenter un permis de conduire valide et une pièce d'identité officielle.</li>
            @if(!$reservation->with_driver)
            <li><strong>Caution :</strong> Versement d'une caution de 200 000 FCFA, restituée après retour du véhicule.</li>
            @endif
            <li><strong>Usage :</strong> Utiliser le véhicule conformément au code de la route et aux bonnes pratiques.</li>
            <li><strong>Carburant :</strong> Retourner le véhicule avec le même niveau de carburant qu'à la prise en charge.</li>
            <li><strong>Entretien :</strong> Signaler immédiatement tout problème technique ou incident.</li>
        </ul>
        
        <h4 style="color: #333;">2. Obligations du Bailleur</h4>
        <ul>
            <li>Fournir un véhicule en bon état de fonctionnement et d'entretien.</li>
            <li>S'assurer que le véhicule est couvert par une assurance valide.</li>
            @if($reservation->with_driver)
            <li>Fournir un chauffeur professionnel qualifié et expérimenté.</li>
            @endif
            <li>Assurer un service d'assistance en cas de panne ou d'urgence.</li>
        </ul>
        
        <h4 style="color: #333;">3. Responsabilités et Assurances</h4>
        <ul>
            <li>Le locataire est responsable de tout dommage causé au véhicule pendant la période de location.</li>
            <li>L'assurance de base est incluse dans le tarif de location.</li>
            <li>Les dommages non couverts par l'assurance sont à la charge du locataire.</li>
            <li>En cas d'accident, contacter immédiatement les autorités compétentes et RENTALY.</li>
        </ul>
        
        <h4 style="color: #333;">4. Conditions d'Annulation</h4>
        <ul>
            <li>Annulation gratuite jusqu'à 24 heures avant le début de la location.</li>
            <li>Annulation entre 24h et 12h : retenue de 25% du montant total.</li>
            <li>Annulation moins de 12h avant : retenue de 50% du montant total.</li>
            <li>Non-présentation sans annulation : facturation intégrale.</li>
        </ul>
    </div>

    <!-- Date et lieu -->
    <div class="date-place">
        Fait à Cotonou, le {{ $generated_at->format('d/m/Y') }}
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-block" style="float: left;">
            <div style="height: 60px;"></div>
            <div><strong>Le Bailleur</strong></div>
            <div>RENTALY</div>
        </div>
        <div class="signature-block" style="float: right;">
            <div style="height: 60px;"></div>
            <div><strong>Le Locataire</strong></div>
            <div>{{ $client->name }}</div>
        </div>
    </div>
    
    <div style="clear: both;"></div>

    <!-- Page 2 : Conditions détaillées -->
    <div class="page-break">
        <h2 style="color: #860000; text-align: center; border-bottom: 2px solid #860000; padding-bottom: 10px;">
            CONDITIONS GÉNÉRALES DE LOCATION
        </h2>
        
        <h3 style="color: #860000;">Article 1 : Objet du Contrat</h3>
        <p>Le présent contrat a pour objet la location du véhicule décrit en première page, dans les conditions définies ci-après.</p>
        
        <h3 style="color: #860000;">Article 2 : Durée de Location</h3>
        <p>La location débute le {{ \Carbon\Carbon::parse($reservation->reservation_start_date)->format('d/m/Y') }} à {{ $reservation->reservation_start_time }} et se termine le {{ \Carbon\Carbon::parse($reservation->reservation_end_date)->format('d/m/Y') }} à {{ $reservation->reservation_end_time }}.</p>
        
        <h3 style="color: #860000;">Article 3 : Tarification</h3>
        <p>Le tarif de location est de {{ number_format($reservation->daily_rate, 0, ',', ' ') }} FCFA par jour {{ $reservation->with_driver ? 'avec chauffeur inclus' : 'sans chauffeur' }}.</p>
        @if($reservation->discount_percentage > 0)
        <p>Une réduction de {{ $reservation->discount_percentage }}% a été appliquée pour une location de {{ $reservation->total_days }} jours.</p>
        @endif
        
        <h3 style="color: #860000;">Article 4 : État du Véhicule</h3>
        <p>Le locataire reconnaît avoir reçu le véhicule en parfait état de marche et d'entretien. Il s'engage à le restituer dans le même état.</p>
        
        <h3 style="color: #860000;">Article 5 : Usage du Véhicule</h3>
        <p>Le véhicule ne peut être utilisé que dans la zone convenue : {{ $reservation->deployment_zone }}. Toute utilisation hors de cette zone doit faire l'objet d'un accord préalable.</p>
        
        <h3 style="color: #860000;">Article 6 : Interdictions</h3>
        <ul>
            <li>Sous-louer le véhicule à des tiers</li>
            <li>Utiliser le véhicule pour des activités illégales</li>
            <li>Conduire sous l'influence de l'alcool ou de stupéfiants</li>
            <li>Transporter des matières dangereuses</li>
            <li>Utiliser le véhicule pour des courses ou des épreuves</li>
        </ul>
        
        <h3 style="color: #860000;">Article 7 : Assurance</h3>
        <p>Le véhicule est couvert par une assurance tous risques. Le locataire reste responsable des dommages non couverts par l'assurance.</p>
        
        <h3 style="color: #860000;">Article 8 : Paiement</h3>
        <p>Le montant total de {{ number_format($reservation->final_total, 0, ',', ' ') }} FCFA est payable selon les modalités convenues via la plateforme RENTALY.</p>
        
        <h3 style="color: #860000;">Article 9 : Litiges</h3>
        <p>Tout litige relatif à l'exécution du présent contrat sera de la compétence des tribunaux de Cotonou.</p>
        
        <div style="text-align: center; margin-top: 40px; padding: 20px; border: 2px solid #860000; background-color: #f8f8f8;">
            <h4 style="color: #860000; margin-top: 0;">CONTACT D'URGENCE</h4>
            <p style="margin: 5px 0;"><strong>Téléphone :</strong> +229 XX XX XX XX</p>
            <p style="margin: 5px 0;"><strong>Email :</strong> support@rentaly.com</p>
            <p style="margin: 5px 0;"><strong>Disponible 24h/24, 7j/7</strong></p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Contrat généré automatiquement par RENTALY - {{ $contract_number }} - Page <span class="pagenum"></span>
    </div>
</body>
</html>