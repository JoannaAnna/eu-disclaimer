<?php
// Pour s'assurer qu'un utilisateur n'envoie pas un formulaire vide et effacer les données insérés par défaut dans la table
    if (!empty($_POST['message_disclaimer']) && !empty($_POST['redirection_ko'])) {
        $text = new DisclaimerOptions();
        $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));    // fonction PHP htmlspecialchars() permet de protéger votre formulaire contre la faille XSS
        $text->setRedirectionKo(htmlspecialchars($_POST['redirection_ko']));
        $message = DisclaimerTable::insertIntoTable($text);
}
?>

<!-- Création du formulaire du plugin -->

<h1>EU DISCLAIMER</h1>
<br>
<h2>Configuration</h2>
<p><?php if(isset($message)) echo $message; ?></p>
<form action="" method="post" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="blogname">Message du disclaimer</label>
            </th>
            <td>
                <input type="text" name="message_disclaimer" id="message_disclaimer" 
                    class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="blogname">Url de redirection</label>
            </th>
            <td>
                <input type="text" name="redirection_ko" id="redirection_ko" 
                    class="regular-text" />
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" value="Enregistrer les modifications" name="submit" 
            id="submit" class="button button-primary">
    </p>
</form>
<br>
<p>
    Exemple : La législation nous impose de vous informer sur la nocivité des produits à 
        base de nicotine, vous devez avoir plus de 18 ans pour consulter ce site !
</p>
<br>
<h3>Centre AFPA / session DWWM</h3>
<img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/img/logo.png'; ?>" 
    width="10%">