<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    /**
     * Génère et télécharge le contrat de réservation en PDF
     */
    public function downloadContract(Reservation $reservation)
    {
        // Vérification des droits d'accès
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce contrat.');
        }

        // Charger les relations nécessaires
        $reservation->load(['car', 'user']);

        // Données pour le contrat
        $contractData = [
            'reservation' => $reservation,
            'car' => $reservation->car,
            'client' => $reservation->user,
            'contract_number' => 'RENT-' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT),
            'generated_at' => now(),
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('contracts', $contractData)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        // Nom du fichier
        $filename = 'Contrat_Reservation_' . $reservation->id . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Affiche le contrat en ligne (preview)
     */
    public function viewContract(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce contrat.');
        }

        $reservation->load(['car', 'user']);

        $contractData = [
            'reservation' => $reservation,
            'car' => $reservation->car,
            'client' => $reservation->user,
            'contract_number' => 'RENT-' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT),
            'generated_at' => now(),
        ];

        return view('contracts', $contractData);
    }

    /**
     * Génère le PDF et l'affiche dans le navigateur (inline)
     */
    public function previewContract(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce contrat.');
        }

        $reservation->load(['car', 'user']);

        $contractData = [
            'reservation' => $reservation,
            'car' => $reservation->car,
            'client' => $reservation->user,
            'contract_number' => 'RENT-' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT),
            'generated_at' => now(),
        ];

        $pdf = Pdf::loadView('contracts', $contractData)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        return $pdf->stream('Contrat_Reservation_' . $reservation->id . '.pdf');
    }
}