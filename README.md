# Onjarandria Portfolio - Backend EasyAdmin

Portfolio professionnel avec administration complète via EasyAdmin, intégration Mailjet et Turbo UX.

## ✨ Fonctionnalités

### 🎨 Administration EasyAdmin
- **Dashboard personnalisé** avec statistiques et accès rapide
- **Gestion complète du contenu** :
  - Hero section (photo, nom, métiers animés)
  - À propos (informations personnelles, biographie)
  - Compétences (barres de progression)
  - Statistiques (chiffres clés)
  - CV / Resume (éducation, expériences)
  - Portfolio (projets avec catégories)
  - Services (prestations proposées)
  - Témoignages clients
  - Contact (infos et messages)
- **Upload d'images** avec redimensionnement automatique
- **Réorganisation par glisser-déposer** (position)
- **Activation/Désactivation** rapide des éléments

### 📧 Intégration Mailjet
- Formulaire de contact fonctionnel
- Notification par email à l'admin
- Email de confirmation à l'expéditeur
- Stockage des messages en base de données
- Gestion des statuts (nouveau, lu, répondu, archivé)

### ⚡ Turbo UX + Mercure
- Navigation fluide sans rechargement complet
- Mises à jour en temps réel via Mercure
- Interface réactive et moderne
- Animations et transitions fluides

## 🚀 Installation

### Prérequis
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & npm (optionnel pour les assets)

### Étapes

1. **Cloner le projet**
```bash
cd onjarandria-porfolios
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**
```bash
# Modifier le fichier .env.local avec vos informations
database_url="mysql://user:password@localhost:3306/onjarandria-porfolios?serverVersion=8.0"

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate
```

4. **Configurer Mailjet**
```bash
# Dans .env.local
MAILER_DSN=mailjet+api://CLE_PUBLIQUE:CLE_PRIVEE@api.mailjet.com
ADMIN_EMAIL=votre-email@gmail.com
```

5. **Charger les données initiales (optionnel)**
```bash
# Créer un utilisateur admin
php bin/console security:hash-password
php bin/console dbal:run-sql "INSERT INTO user (email, roles, password) VALUES ('admin@example.com', '[\"ROLE_ADMIN\"]', 'HASH')"

# Ou charger les fixtures de démo
php bin/console doctrine:fixtures:load
```

6. **Lancer le serveur**
```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

## 📁 Structure du projet

```
onjarandria-porfolios/
├── config/                 # Configuration Symfony
├── migrations/             # Migrations Doctrine
├── public/                 # Assets publics
│   ├── admin/             # CSS/JS personnalisés admin
│   ├── uploads/           # Fichiers uploadés
│   └── assets/            # Assets du site
├── src/
│   ├── Controller/
│   │   ├── Admin/         # Contrôleurs EasyAdmin
│   │   └── ...            # Contrôleurs front
│   ├── Entity/            # Entités Doctrine
│   ├── Form/              # Formulaires Symfony
│   ├── Repository/        # Repositories
│   ├── Service/           # Services métier
│   └── DataFixtures/      # Données de test
├── templates/             # Templates Twig
│   ├── admin/             # Templates admin personnalisés
│   ├── contact/
│   ├── hero/
│   ├── about/
│   └── ...
└── var/                   # Cache et logs
```

## 🔧 Configuration

### Variables d'environnement (.env.local)

```bash
# Application
APP_ENV=prod
APP_SECRET=votre-secret

# Database
DATABASE_URL="mysql://user:pass@localhost:3306/dbname?serverVersion=8.0"

# Mailjet
MAILER_DSN=mailjet+api://PUB_KEY:PRIV_KEY@api.mailjet.com
ADMIN_EMAIL=admin@example.com
SITE_NAME="Mon Portfolio"

# Mercure (optionnel)
MERCURE_URL=http://localhost:3000/.well-known/mercure
MERCURE_JWT_SECRET="votre-cle-jwt"
```

## 📝 Utilisation

### Accès Admin
- URL : `http://localhost:8000/admin`
- Identifiants : email + mot de passe créés lors de l'installation

### Gestion du contenu
1. Connectez-vous à l'admin
2. Naviguez dans les sections via le menu latéral
3. Cliquez sur "+ Add" pour créer un nouvel élément
4. Utilisez les icônes ✏️ et 🗑️ pour modifier/supprimer
5. Activez/Désactivez avec le toggle "Actif"

### Formulaire de contact
Le formulaire est automatiquement fonctionnel. Les messages :
- Sont stockés en base de données
- Déclenchent une notification email (si Mailjet configuré)
- Apparaissent dans la section "Messages" de l'admin

## 🎨 Personnalisation

### Modifier l'apparence admin
Éditez `public/admin/custom-admin.css`

### Modifier les comportements JS
Éditez `public/admin/hero-toggle.js`

### Ajouter de nouvelles sections
1. Créer l'entité : `php bin/console make:entity`
2. Créer le CRUD controller : `php bin/console make:admin:crud`
3. Ajouter au menu dans `DashboardController.php`
4. Générer la migration : `php bin/console make:migration`

## 🔒 Sécurité

- Changez régulièrement les mots de passe
- Utilisez HTTPS en production
- Protégez le dossier `var/` et `.env.local`
- Limitez les tentatives de connexion (rate limiting)

## 🆘 Support

En cas de problème :
1. Vérifiez les logs : `var/log/`
2. Videz le cache : `php bin/console cache:clear`
3. Vérifiez la config : `php bin/console debug:config`

## 📄 Licence

Projet privé - Tous droits réservés.
