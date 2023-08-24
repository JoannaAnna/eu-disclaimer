// On place une condition, si le cookie n'a pas la bonne valeur, alors on affiche le modal
jQuery(document).ready(function($) {
    if(readCookie('eu-disclaimer-vapobar') != "ejD86j7ZXF3x") {
        // Code du site Web jQuery pour l'exemple modal 5 : la fenêtre non fermable 
        // Cela montre comment désactiver les méthodes par défaut de fermeture du modal
        $("#myModal").modal({
            escapeClose: false,
            clickClose: false,
            showClose: false
        });
    }
});
    
// On ne souhaite pas afficher le modal à chaque actualisation/rafraîchissement de page, on utilisera donc des cookies afin de déterminer s'il visite le site pour la première fois sur une période donnée

// function pour créer le cookie, avec 3 paramètres du cookie: nom, valeur et durée
function createCookie(name, value, duration) {
    // Si le nombre de jours est spécifié
    if(duration) {
        var date = new Date();
        // on convertit les jours spécifiés en milisecondes
        date.setTime(date.getTime()+(duration*24*60*60*1000));
        var expire = "; expire="+date.toGMTString();
    } else var expire = "";   // Si aucune valeur de jour n'est spécifiée le cookie expire à la fin de la session 
    console.log("test :", date); // Onvérifie la date
    document.cookie = name + "=" + value + expire + "; path=/";   // Création du cookie
}

// fonction pour lire le cookie, avec un nom de paramètre du cookie
function readCookie(name) {
    var nameFormat = name + "="; // on ajoute '=' au nom pour la rechercher dans le tableau avec des cookies
    var tCookies = document.cookie.split(';'); // tableau avec des cookies, divisé par ';'
    // on recherche dans le tableau pour trouver notre cookie
    for(var i=0; i<tCookies.length; i++) {
        var foundCookie = tCookies[i];
        // si le cookie a un espace, on le soustrait (l'espace)
        while(foundCookie.charAt(0) == ' ') {
            foundCookie = foundCookie.substring(1, foundCookie.length)
        }
        // si notre cookie est trouvé, on retourne sa valeur
        if(foundCookie.indexOf(nameFormat) == 0) {
            return foundCookie.substring(nameFormat.length, foundCookie.length);
        }
    }
    return null;    // si aucun cookie n'est trouvé on returne null
}

// on appele la fonction acceptDisclaimer en cliquant sur un bouton "Oui" sur notre modal
document.getElementById("yes").addEventListener("click", acceptDisclaimer);

// fonction "accepter le disclaimer" qui appele la fonction createCookie()
function acceptDisclaimer() {
    createCookie('eu-disclaimer-vapobar', "ejD86j7ZXF3x", 1);
    var cookie = readCookie('eu-disclaimer-vapobar');
    alert(cookie);
}

