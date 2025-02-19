1. Installation sur la machine
• PHP (≥ 8.1)
• Composer (gestionnaire de dépendances PHP)
• Symfony CLI (pour exécuter des commandes Symfony)
• Serveur Web (XAMPP)
• Git (pour le versionnement du code)
2. Installation du Projet
1. Cloner le dépôt
[git clone (https://github.com/Tilelli96/EcoRide.git)
cd votre-projet
2. Installer les dépendances
composer install
3. Configurer les variables d’environnement
DATABASE_URL="mysql://root@127.0.0.1:3306/EcoRide?serverVersion=10.4.32-
MariaDB&charset=utf8mb4"
4. Créer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
3. Démarrer le Serveur
symfony server :start
