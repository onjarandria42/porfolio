# Configuration Admin - Onjarandria Portfolio

Ce document explique comment configurer et utiliser l'administration EasyAdmin du portfolio.

## 🚀 Installation et Configuration

### 1. Base de données

Exécutez les migrations pour créer les nouvelles tables :

```bash
php bin/console doctrine:migrations:migrate
```

### 2. Configuration Mailjet

Pour activer l'envoi d'emails via Mailjet, modifiez le fichier `.env.local` :

```bash
# Configuration Mailjet
MAILER_DSN=mailjet+api://VOTRE_CLE_API_PUBLIQUE:VOTRE_CLE_API_PRIVEE@api.mailjet.com
```

Remplacez `VOTRE_CLE_API_PUBLIQUE` et `VOTRE_CLE_API_PRIVEE` par vos clés API Mailjet.

### 3. Configuration Mercure (optionnel)

Pour les mises à jour en temps réel, configurez Mercure dans `.env.local` :

```bash
MERCURE_URL=http://localhost:3000/.well-known/mercure
MERCURE_PUBLIC_URL=http://localhost:3000/.well-known/mercure
MERCURE_JWT_SECRET="votre-cle-secrete-jwt"
```

### 4. Créer un utilisateur admin

```bash
php bin/console security:hash-password
# Entrez le mot de passe souhaité

php bin/console dbal:run-sql "INSERT INTO user (email, roles, password) VALUES ('admin@votre-email.com', '[\"ROLE_ADMIN\"]', 'MOT_DE_PASSE_HASHE')"
```

## 📋 Sections Administrables

### Hero (Section d'accueil)
- **Hero** : Photo de profil, nom complet
- **Métiers Hero** : Titres animés (Développeur, Designer, etc.)

### À propos
- Informations personnelles (anniversaire, téléphone, email, etc.)
- Biographie courte et longue
- Photo de profil

### Compétences
- Nom de la compétence
- Pourcentage de maîtrise (0-100%)
- Icône Bootstrap Icons

### Statistiques
- Label (ex: Happy Clients)
- Valeur numérique
- Icône
- Sous-titre optionnel

### CV / Resume
- **Résumé** : Présentation courte
- **Éducation** : Parcours académique
- **Expérience** : Expériences professionnelles avec liste de détails

### Portfolio
- **Catégories** : App, Product, Branding, etc.
- **Projets** : Images, descriptions, liens

### Services
- Titre du service
- Description
- Icône
- Lien optionnel

### Témoignages
- Nom de l'auteur
- Rôle/Fonction
- Photo
- Contenu du témoignage

### Contact
- **Infos Contact** : Adresse, téléphone, email, réseaux sociaux
- **Messages** : Messages reçus via le formulaire

### Configuration
- **Paramètres Site** : Nom, titre, description, logo, favicon, CV
- **Utilisateurs** : Gestion des accès admin

## 🔧 Utilisation d'EasyAdmin

### Accès
- URL : `/admin`
- Identifiez-vous avec votre email et mot de passe

### Fonctionnalités
- **Créer** : Cliquez sur "+ Add" dans n'importe quelle section
- **Modifier** : Cliquez sur l'icône crayon ✏️
- **Supprimer** : Cliquez sur l'icône corbeille 🗑️
- **Activer/Désactiver** : Utilisez le toggle "Actif" pour masquer sans supprimer
- **Réorganiser** : Modifiez le champ "Position" pour changer l'ordre

### Upload d'images
- Les images sont automatiquement redimensionnées et stockées dans `public/uploads/`
- Formats acceptés : JPG, PNG, GIF, WebP

## 📧 Formulaire de Contact

Le formulaire de contact :
1. Enregistre le message en base de données
2. Envoie une notification à l'admin par email (via Mailjet)
3. Envoie une confirmation à l'expéditeur

Les messages apparaissent dans la section **Contact > Messages** avec un badge indiquant les nouveaux messages.

## 🎨 Personnalisation

### Modifier l'apparence de l'admin
Éditez le fichier `public/admin/custom-admin.css`

### Modifier les comportements JavaScript
Éditez le fichier `public/admin/hero-toggle.js`

## 🔒 Sécurité

- Changez régulièrement votre mot de passe
- Utilisez des mots de passe forts
- Limitez l'accès à l'admin par IP si possible
- Gardez vos clés API secrètes

## 🆘 Support

En cas de problème :
1. Vérifiez les logs dans `var/log/`
2. Videz le cache : `php bin/console cache:clear`
3. Vérifiez la connexion base de données
