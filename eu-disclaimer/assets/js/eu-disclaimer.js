//* Code du site Web jQuery pour l'exemple modal 5 : la fenêtre non fermable 
//* Cela montre comment désactiver les méthodes par défaut de fermeture du modal

$("#myModal").modal({
    escapeClose: false,
    clickClose: false,
    showClose: false
});