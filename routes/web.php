<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return view('index.html');
});

$router->group(['prefix' => 'api'], function () use ($router) {

    // Toutes les bases
    $router->get('bases', ['uses' => 'BaseController@index']);

    // Détail d'une base
    $router->get('bases/{id}', ['uses' => 'BaseController@show']);

    // Tous les joueurs
    $router->get('users', ['uses' => 'UserController@index']);

    // Détail d'un joueur
    $router->get('users/{id}', ['uses' => 'UserController@show']);

    // Tous les badges
    $router->get('badges', ['uses' => 'BadgeController@index']);

    // Détail d'un badge
    $router->get('badges/{id}', ['uses' => 'BadgeController@show']);

    // Toutes les sections
    $router->get('sections', ['uses' => 'SectionController@index']);

    // Détail d'une section
    $router->get('sections/{id}', ['uses' => 'SectionController@show']);

    // Inscription
    $router->post('/register', 'AuthController@register');

    // Connexion
    $router->post('/login', 'AuthController@login');

    //Envoi de l'email de reset
    $router->post('reset/send', ['uses' => 'ResetPasswordController@send']);

    //Modifie le mot de passe
    $router->post('reset/change-password', ['uses' => 'ResetPasswordController@passwordResetProcess']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        // Routes authentifiées

        // Ajout d'un site web
        $router->put('users/{id}/website', ['uses' => 'UserController@website']);

        // Ajout d'un badge CSS
        $router->post('css/badges/{badgeId}', ['uses' => 'BadgeCSSController@addBadgeCSS']);

        // Achat d'oxygene
        $router->post('bases/oxygen/buy', ['uses' => 'BaseController@oxygenReplenishment']);
    });

    $router->group(['middleware' => 'responsable'], function () use ($router) {
        // Routes responsables

        // Ajout d'un badge
        $router->post('users/{id}/badges/{badgeId}', ['uses' => 'BadgeController@store']);
    });

    $router->group(['middleware' => 'admin'], function () use ($router) {
        // Routes admin

        // Ajout badge aux responsables
        $router->post('users/{id}/responsables', ['uses' => 'ResponsableController@addResponsable']);

        // Création compte responsable
        $router->post('responsables/register', ['uses' => 'ResponsableController@createResponsable']);

        // Modification mot de passe utilisateur
        $router->post('users/{id}/reset', ['uses' => 'AdminController@ResetPasswordUser']);

        // Modification d'un badge
        $router->put('badges/{id}', ['uses' => 'BadgeController@update']);

        // Modification d'une base
        $router->put('bases/{id}', ['uses' => 'BaseController@update']);

        // Création d'un badge
        $router->post('badges', ['uses' => 'BadgeController@create']);

        // Suppression d'un badge
        $router->delete('badges/{id}', ['uses' => 'BadgeController@delete']);

        // Suppression d'un joueur
        $router->delete('users/{id}', ['uses' => 'UserController@delete']);

    });

    $router->group(['middleware' => 'WhiteListIpAddressess'], function () use ($router) {
        // Routes serveur Infomaniak

        // Vider oyxygene
        $router->get('bases/oxygen/depletion', ['uses' => 'BaseController@oxygenDepletion']);
    });
    
});
