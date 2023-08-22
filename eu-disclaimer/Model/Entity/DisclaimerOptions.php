<?php

class DisclaimerOptions {

    private $id_disclaimer;     // identifiant du disclaimer
    private $message_disclaimer;    // contenu du message à afficher dans le disclaimer
    private $redirection_ko;    // l'url de redirection en cas de réponse négative par le visiteur

    function __construct()
    {
        $id_disclaimer = $this->id_disclaimer;
        $message_disclaimer = $this->message_disclaimer;
        $redirection_ko = $this->redirection_ko;
    }

    /**
     * Get the value of id_disclaimer
     */
    public function getIdDisclaimer()
    {
        return $this->id_disclaimer;
    }

    /**
     * Get the value of message_disclaimer
     */
    public function getMessageDisclaimer()
    {
        return $this->message_disclaimer;
    }

    /**
     * Set the value of message_disclaimer
     * 
     * @return self
     */
    public function setMessageDisclaimer($message_disclaimer)
    {
        $this->message_disclaimer = $message_disclaimer;
        return $this;
    }

    /**
     * Get the value of redirection_ko
     */ 
    public function getRedirectionKo()
    {
        return $this->redirection_ko;
    }

    /**
     * Set the value of redirection_ko
     *
     * @return  self
     */ 
    public function setRedirectionKo($redirection_ko)
    {
        $this->redirection_ko = $redirection_ko;
        return $this;
    }
}