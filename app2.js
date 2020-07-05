function loadDoc() {
    /*Récupération contenu date*/
    var dateInput = document.getElementById('date_changement')
    var date = dateInput.value;
    const errorDate = document.getElementById('help_date');
    console.log(date);
    /*Récupération contenu etage*/
    var etageSelect = document.getElementById('etage');
    var etage = etageSelect.value;
    const errorEtage = document.getElementById('help_etage');
    /*Récupération contenu position*/
    var positionSelect = document.getElementById('position');
    var position = positionSelect.value;
    const errorPosition = document.getElementById('help_position');
    /*Récupération contenu puissance*/
    var puissanceInput = document.getElementById('puissance');
    var puissance = puissanceInput.value;
    const errorPuissance = document.getElementById('help_puissance');
    /*Récupération contenu marque*/
    var marqueInput = document.getElementById('marque');
    var marque = marqueInput.value;
    const errorMarque = document.getElementById('help_marque');

    //On modifie le style 
    //Si la date n'est pas saisi 
    var submitTest = 0;
    if(date == ""){
        errorDate.style.color = "red";
        errorDate.style.fontWeight = "bold";
        dateInput.style.border = "2px solid red";
        console.log(1);
    } else{
        errorDate.style.color = "rgba(0,0,0,.6)";
        errorDate.style.fontWeight = "normal";
        dateInput.style.border = "1px solid #dddddd";
        console.log(1.1);
        submitTest ++;
    }
    //Si l'étage n'est pas saisi 
    if(etage == ""){
        errorEtage.style.color = "red";
        errorEtage.style.fontWeight = "bold";
        etageSelect.style.border = "2px solid red";
        console.log(2);
    }else{
        errorEtage.style.color = "rgba(0,0,0,.6)";
        errorEtage.style.fontWeight = "normal";
        etageSelect.style.border = "1px solid #dddddd";
        console.log(2.2);
        submitTest ++;
    }
    //Si la position n'est pas saisi 
    if(position == ""){
        errorPosition.style.color = "red";
        errorPosition.style.fontWeight = "bold";
        positionSelect.style.border = "2px solid red";
        console.log(3);
    }else{
        errorPosition.style.color = "rgba(0,0,0,.6)";
        errorPosition.style.fontWeight = "normal";
        positionSelect.style.border = "1px solid #dddddd";
        console.log(3.3);
        submitTest ++;
    }
    //Si la puissance n'est pas saisi 
    if(puissance == ""){
        errorPuissance.style.color = "red";
        errorPuissance.style.fontWeight = "bold";
        puissanceInput.style.border = "2px solid red";
        console.log(4);
    }else{
        errorPuissance.style.color = "rgba(0,0,0,.6)";
        errorPuissance.style.fontWeight = "normal";
        puissanceInput.style.border = "1px solid #dddddd";
        console.log(4.4);
        submitTest ++;
    }
    //Si la marque n'est pas saisi 
    if(marque == ""){
        errorMarque.style.color = "red";
        errorMarque.style.fontWeight = "bold";
        marqueInput.style.border = "2px solid red";
        console.log(5);
    }else{
        errorMarque.style.color = "rgba(0,0,0,.6)";
        errorMarque.style.fontWeight = "normal";
        marqueInput.style.border = "1px solid #dddddd";
        console.log(5.5);
        submitTest ++;
    }
    if(submitTest == 5){
        document.getElementById('form-edit').submit();
    }
}

