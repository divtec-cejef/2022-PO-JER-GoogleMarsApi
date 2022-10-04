# API DIVTEC MARS

## Liens
- [Lien du wiki](https://github.com/divtec-cejef/2022-PO-JER-GoogleMars/wiki/Base-de-donn%C3%A9es---API "Wiki")
- [Lien de l'api](https://api-mars.divtec.ch/ "Lien de l'api")
- [Lien du gitbook](https://divtec.gitbook.io/api-laravel-lumen/ "Lien du gitbook")

## Instructions

- Ouvrir le projet dans un IDE
- Télécharger les packages
- Générer les clés du [fichier .env](https://github.com/divtec-cejef/2022-PO-JER-GoogleMarsApi/blob/Master/.env)
- Lancer XAMPP (Apache & MySQL)
- Démarrer le serveur php
- Initialiser la base de donnée
- Installer et configurer Postman pour les requêtes


## Commandes utiles

| Commandes | Description                    |
| ------------- | ------------------------------ |
| `composer install`      | Télécharger les packages   |
| `php -S localhost:8000 -t public`      | Démarrer le serveur php       |
| `php artisan migrate:fresh`   |  Réinitialiser la base de donnée    |
| `php artisan key:generate` | `APP_KEY` dans le [fichier .env](https://github.com/divtec-cejef/2022-PO-JER-GoogleMarsApi/blob/Master/.env) |
| `php artisan jwt:secret` | `JWT_SECRET` dans le [fichier .env](https://github.com/divtec-cejef/2022-PO-JER-GoogleMarsApi/blob/Master/.env) |
