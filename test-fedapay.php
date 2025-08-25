<?php

// Créez ce fichier test-fedapay.php à la racine de votre projet Laravel

require_once 'vendor/autoload.php';

use FedaPay\FedaPay;
use FedaPay\Currency;

// Configuration
FedaPay::setApiVersion('v1');
FedaPay::setEnvironment('sandbox'); // ou 'live'
FedaPay::setApiKey('sk_sandbox_FaBqZLq4j24XG7gIXeXE7Kmo'); // Remplacez par votre vraie clé

try {
    echo "Test de connexion FedaPay...\n";
    
    // Test simple : récupérer les devises
    $currencies = Currency::all();
    
    echo "✅ Connexion réussie!\n";
    echo "Devises disponibles : " . count($currencies->data) . "\n";
    
    foreach ($currencies->data as $currency) {
        echo "- " . $currency->name . " (" . $currency->iso . ")\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
    echo "Type : " . get_class($e) . "\n";
}