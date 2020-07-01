// Get the modal
var modal = document.getElementById("myModal");
var ModalBtnOui = document.getElementById('modal-yes');
var ModalBtnNon = document.getElementById('modal-no');

var modalSpan = document.getElementById('modal-span');

const btnClass = document.getElementsByClassName('btnDelete');
console.log(btnClass);




cliquer = delete(this.id);
console.log(cliquer);

// When the user clicks on the button, open the modal
btnClass.onclick = function() {
  modal.style.display = "block";
}

//Quand l'utilisateur clique sur le bouton non, ferme le modale
ModalBtnNon.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

//Redirection du bouton oui sur le lien de la page delete
ModalBtnOui.onclick = function(){
  document.location.href = IdDelete;
}





