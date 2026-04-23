# Art Shop 🎨

Une Platforme en ligne dédiée à la vente d'œuvres d'art, construite avec Laravel. Les artistes peuvent publier et gérer leurs créations, tandis que les clients peuvent les découvrir, les commander et suivre leurs achats.

## Fonctionnalités

- **Gestion des utilisateurs** — Système d'authentification complet (inscription, connexion, vérification d'email) avec trois rôles distincts :
    - **Admin** : gestion globale de la plateforme
    - **Artiste** : publication et gestion d'œuvres, gestion du profil (bio, avatar)
    - **Client** : découverte et achat d'œuvres
- **Catalogue d'œuvres** — Affichage des œuvres par catégorie, avec fiche détaillée (titre, description, prix, stock, image)
- **Catégories** — Organisation des œuvres par catégories personnalisables
- **Galerie d'images** — Possibilité d'associer plusieurs images à une même œuvre
- **Panier & Commandes** — Système de commande avec suivi du statut (_en attente, en cours, terminée, annulée_)
- **Gestion des stocks** — Suivi automatique des disponibilités (_disponible, vendu, archivé_)
- **Dashboard** — Tableau de bord utilisateur après connexion

## Stack technique

| Technologie     | Version                     |
| --------------- | --------------------------- |
| PHP             | ^8.3                        |
| Laravel         | ^13.0                       |
| Laravel Breeze  | ^2.4                        |
| JavaScript      |   /                      |
| Vite            | ^8.0                        |
| Base de données | SQLite / MySQL |

## Architecture des données

```
User (admin, artiste, client)
├── hasMany → Oeuvre
├── hasMany → Commande
│
Categorie
├── hasMany → Oeuvre
│
Oeuvre
├── belongsTo → User (artiste)
├── belongsTo → Categorie
├── hasMany → CommandeItem
├── hasMany → OeuvresImage
│
Commande
├── belongsTo → User (client)
├── hasMany → CommandeItem
│
CommandeItem
├── belongsTo → Commande
├── belongsTo → Oeuvre
```

## Prérequis

- [PHP](https://www.php.net/) >= 8.3
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) & npm
- Extension PDO pour la base de données de votre choix

## Installation

1. **Cloner le dépôt**

    ```bash
    git clone https://github.com/<votre-utilisateur>/art-shop.git
    cd art-shop
    ```

2. **Installer les dépendances PHP**

    ```bash
    composer install
    ```

3. **Installer les dépendances JavaScript**

    ```bash
    npm install
    ```

4. **Configurer l'environnement**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Modifiez le fichier `.env` pour configurer votre base de données.

5. **Exécuter les migrations**

    ```bash
    php artisan migrate
    ```

6. **Créer le lien symbolique pour le stockage des fichiers**

    ```bash
    php artisan storage:link
    ```

7. **Compiler les assets front-end**

    ```bash
    npm run build
    ```

8. **Lancer le serveur de développement**

    ```bash
    php artisan serve
    ```

    L'application est accessible à l'adresse [http://localhost:8000](http://localhost:8000).

## Commandes utiles

| Commande                           | Description                                 |
| ---------------------------------- | ------------------------------------------- |
| `php artisan serve`                | Lance le serveur de développement           |
| `npm run dev`                      | Compile les assets en mode watch (Vite)     |
| `npm run build`                    | Compile les assets pour la production       |
| `php artisan migrate`              | Exécute les migrations                      |
| `php artisan migrate:fresh --seed` | Réinitialise la base et exécute les seeders |
| `php artisan test`                 | Lance les tests PHPUnit                     |


