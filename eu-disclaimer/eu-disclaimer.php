<?php
/**
* Plugin Name: eu-disclaimer
* Plugin URI: http://
* Description: Plugin sur la législation des produits à base de nicotine.
* Version: 1.5
* Author: Ryad AFPA
* Author URI: http://www.afpa.fr
* License:
*/

require_once ('Model/repository/DisclaimerTable.php');

// Création de la function ajouter au menu, pour afficher un raccourci vers notre plugin
function addToMenu()
{
    $page_title = 'eu-disclaimer';
    $menu_title = 'eu-disclaimer';
    $capability = 'edit_pages'; // capability (capacité) c'est ensemble de tâches qui peuvent être effectuées par des rôles prédéfinis WordPress, ici la capacité est de modifier la page
    $menu_slug = 'eu-disclaimer';
    $function = 'disclaimerFunction';
    $icon_url = '';
    $position = 80; // 80 – Settings / position dans l'ordre du menu où cet élément doit apparaître

    if (is_admin()){
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, 
            $function, $icon_url, $position);
    }

}

// hook pour réaliser l'action 'admin_menu' <- emplacement /
// addToMenu <- fonction à appeler / <- priorité 10
add_action('admin_menu', 'addToMenu', 10);

// fonction à appeler lorsque l'on clic sur le menu
function disclaimerFunction(){
    require_once ('views/disclaimer-menu.php');
}

// On gère la table 'DisclaimerTable'
if (class_exists("DisclaimerTable")) {
// On crée un objet pour gèrer la table
    $manage_table = new DisclaimerTable();
}
if (isset($manage_table)) {
// On utilise deux hooks, un pour l'installation de la table puis un autre pour la désinstallation de la table
    register_activation_hook(__FILE__, array($manage_table, 'createTable'));
    register_deactivation_hook(__FILE__, array($manage_table, 'dropTable'));
}

// On ajout du JS à l'activation du plugin
// init - WP fonction qui s'exécute après la fin du chargement de WP mais avant l'envoi des headers
add_action('init', 'addJsToFooter');

// On utilise la fonction WP wp_register_script - qui enregistre un script à mettre en file d'attente ultérieurement à l'aide de la fonction wp_enqueue_script()
// function wp_register_script($handle - jQuery, $src - on prend le script fourni sur le site jquery, $deps - dépendances, $ver - version, $in_footer - si on veut le script dans le footer)
function addJsToFooter() {
    if (!is_admin()):
        wp_register_script('jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js', 
            null, null, true);
        wp_enqueue_script('jQuery');
        wp_register_script('jQuery_modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', 
            null, null, true);
        wp_enqueue_script('jQuery_modal');
        wp_register_script('jQuery_eu', plugins_url ('assets/js/eu-disclaimer.js', 
            __FILE__), array ('jquery'), '1.1', true);  // La fonction plugins_url() de WP permet de charger des fichiers directement dans le dossier
        wp_enqueue_script('jQuery_eu');
    endif;
}

// On ajout du CSS à l'activation du plugin
// wp_head hook - exécute des scripts (ici addCssToHead()) dans la section <head> sur le front-end, elle utilise également ici la priorité 1
add_action('wp_head', 'addCssToHead', 1);

// On utilise la fonction WP wp_register_style - qui enregistre une feuille de style CSS à mettre en file d'attente ultérieurement à l'aide de la fonction wp_enqueue_style()
// function wp_register_style($handle - nom de la feuille de style, $src - source, $deps - dépendances, $ver - version, $media - le média pour lequel cette feuille de style a été définie, par défaut 'all' : boolean)
function addCssToHead() {
    if (!is_admin()):
        wp_register_style('eu_disclaimer-css', plugins_url ('assets/css/eu-disclaimer-css.css', 
            __FILE__), null, null, false);
        wp_enqueue_style('eu_disclaimer-css');
        wp_register_style('modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', 
        null, null, false);
        wp_enqueue_style('modal');
    endif;
}


// On affiche notre discaimer sur la page d'accueil du site
/**
 * Active le modal sans utilisation du shortcode.
 * Utilisation : add_action('nomdu hook', 'nom de la fonction');
 * hook wp_body_open() permet d'afficher le modal automatiquement dans le thème sous la balise <body>
 * et va appeler la méthode displayModalInTheBody() pour afficher le model avec notre disclaimer)
 */
add_action('wp_body_open', 'displayModalInTheBody');
function displayModalInTheBody() {
    echo DisclaimerTable::displayDisclaimerModal();
}

?>