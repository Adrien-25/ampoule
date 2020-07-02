// Récupération de l'id du modal, de l'id des boutons du modal et du span du modal
var modal = document.getElementById("myModal");
var ModalBtnOui = document.getElementById('modal-yes');
var ModalBtnNon = document.getElementById('modal-no');
var modalSpan = document.getElementById('modal-span');

// Quand l'utilisateur clique sur le bouton non, ferme le modale
ModalBtnNon.onclick = function() {
  modal.style.display = "none";
}
// Quand l'utilisateur clique n'importe ou en dehors du modale, ferme le modale
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Paramètrage du clique sur la poubelle
function confirmation(id){ 
  //Récupération de l'id de l'ampoule à supprimer
  const confirm=document.getElementById("ModalBtnOui");
  //Affichage du modal lorsque l'utilisateur clique sur la poubelle
  modal.style.display = "block";
  //Affichage de l'id a supprimer dans le modal
  modalSpan.innerText = id;
  //Affectation de l'id 
  idDelete = id;
}

// Paramètrage du clique sur le bouton oui du modal
function trash() {
  location.replace("delete.php?id="+idDelete);
}