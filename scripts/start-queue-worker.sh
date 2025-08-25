#!/bin/bash

# Script pour démarrer le worker de queues SMS
# Fichier: scripts/start-queue-worker.sh

echo "🚀 Démarrage du worker de queues SMS..."

# Vérifier que Laravel est disponible
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé ou non disponible dans le PATH"
    exit 1
fi

# Aller dans le répertoire du projet
cd "$(dirname "$0")/.."

# Vérifier que nous sommes dans un projet Laravel
if [ ! -f "artisan" ]; then
    echo "❌ Le fichier artisan n'a pas été trouvé. Êtes-vous dans le bon répertoire ?"
    exit 1
fi

echo "📁 Répertoire de travail: $(pwd)"
echo "🔧 Configuration des queues..."

# Afficher la configuration actuelle
echo "Queue connection: $(php artisan tinker --execute='echo config("queue.default");')"

# Démarrer le worker avec retry automatique
echo "🏃 Lancement du worker pour la queue SMS..."
echo "💡 Appuyez sur Ctrl+C pour arrêter"

# Worker avec redémarrage automatique en cas d'échec
while true; do
    echo "$(date): Démarrage du worker..."
    php artisan queue:work --queue=sms --sleep=3 --tries=3 --max-time=3600 --timeout=60
    
    echo "$(date): Le worker s'est arrêté. Redémarrage dans 5 secondes..."
    sleep 5
done