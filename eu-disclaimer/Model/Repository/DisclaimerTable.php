<?php

define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
include(MY_PLUGIN_PATH . '../Entity/DisclaimerOptions.php');

class DisclaimerTable {

    public function createTable() {
        
        // On crée un objet message qui est une instance de la classe DisclaimerOption
        $message = new DisclaimerOptions();
        // On définit un message par défaut
        $message->setMessageDisclaimer('Au regard de la loi européenne, vous 
            devez nous confirmer que vous avez plus de 18 ans pour visiter 
            ce site.');
        // On définit un url de redirection en cas de réponse négative par le visiteur
        $message->setRedirectionKo('https://www.google.com/');

        // On utilise la variable globale : $wpdb (objet global fourni par WordPress, qui est une instanciation de la classe wpdb)
        global $wpdb;

    // On crée la table
        $table_disclaimer =$wpdb->prefix.'disclaimer_options';
        // si la table n'existe pas alors on crée une nouvelle table
        if ($wpdb->get_var("SHOW TABLES LIKE $table_disclaimer") != $table_disclaimer) {
            $sql = "CREATE TABLE $table_disclaimer 
                (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                message_disclaimer TEXT NOT NULL,
                redirection_ko TEXT NOT NULL)
                ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            
            // Message d'eurreur
            if (!$wpdb->query($sql)) {
                die("Une erreur est survenue, contactez le développeur du plugin.");
            }
        
            // On insère du message par défaut
            $wpdb->insert($wpdb->prefix.'disclaimer_options', 
                array(
                'message_disclaimer' => $message->getMessageDisclaimer(),
                'redirection_ko' => $message->getRedirectionKo(),
                ),
                array('%s', '%s'));
            $wpdb->query($sql);
        }

    }

    public function dropTable() {
        global $wpdb; // On utilise encore la variable globale : $wpdb 
        $table_disclaimer =$wpdb->prefix.'disclaimer_options'; // On accède à la table
        $sql = "DROP TABLE $table_disclaimer"; 
        $wpdb->query($sql); // On exécute une requête sql pour supprimer la table
    }

    // On crée la requête pour mettre à jour les données saisies dans notre formulaire
    static function insertIntoTable($content, $url) {
        // On utilise la variable globale : $wpdb
        global $wpdb;
        $table_disclaimer = $wpdb->prefix.'disclaimer_options';
        $sql = $wpdb->prepare(
            "UPDATE $table_disclaimer SET message_disclaimer = '%s', 
                redirection_ko = '%s' WHERE id_disclaimer = %s", 
                $content, $url, 1);
        $wpdb->query($sql);
    }

    // On crée une fonction pour afficher le modal est son contenu
    static function displayDisclaimerModal () {
        global $wpdb;
        $table_disclaimer = $wpdb->prefix.'disclaimer_options';
        // une requête sql qui récupère les données de notre table
        $query = "SELECT * FROM $table_disclaimer";
        $row =$wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        $redirection_ko = $row->redirection_ko;
        // puis on affiche ces données dans le modal
        return '
        <div id="myModal" class="modal">
        <p>'. $message_disclaimer .'</p>
        <a href="'. $redirection_ko .'" type="button" class="btn-red">Non</a>
        <a href="#" type="button" rel="modal:close" class="btn-green">Oui</a>
        </div>
        ';
    }

}