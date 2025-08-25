<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Http\Request;

class TestSmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Formulaire de test SMS
     */
    public function showTestForm()
    {
        return view('test-sms');
    }

    /**
     * Envoie un SMS de test
     */
    public function sendTestSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160'
        ]);

        $success = $this->smsService->sendSms(
            $request->phone,
            $request->message
        );

        if ($success) {
            return back()->with('success', 'SMS envoyé avec succès !');
        } else {
            return back()->with('error', 'Erreur lors de l\'envoi du SMS. Vérifiez les logs.');
        }
    }
}