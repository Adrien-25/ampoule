<?php
    session_start();
    require_once('db.php');
    
    if(empty($_SESSION['username'])){
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une ampoule</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
     <!--Début couverture de page-->
     <div class="page-wrapper">
        <!--Début du contenu page-->
        <div class="page-content">
            <!--Début du Header-->
            <header class="header">
                <div class="header-brand">
                    <a href ="index.php" class="logo">
                        <img src="img/logo.jpg" alt="Ampoule">
                        Gestion ampoules
                    </a>
                </div>
                <div class="text-center">
                    <a href=index.php class="link-btn">
                        <i class="material-icons icon icon-home">home</i>
                    </a>
                </div>
                <nav class="header-nav">
                    <div class="user-layout">
                        <div class="user-content">
                            <a href="">
                                <span><?=$_SESSION['username']?></span>
                                <img src="img/zidane.jpg" alt="Zinédine zidane">
                            </a>
                            
                        </div>
                        <a href="logout.php">
                            <i class="material-icons icon icon-exit">exit_to_app</i>
                        </a>
                </div>
                </nav>
                    
            <!--Fin du Header-->
            </header>
            
            <!--Début contenu principal-->
            <div class="main-container">
                <?php
                    if(isset($_GET['id']) && isset($_GET['edit'])){
                        $type = "Modifier";
                    } else{
                        $type ="Ajouter";
                    }
                ?>
                <div class="heading-layout">
                    <h1><?=$type?> une ampoule</h1>
                </div>
                
                  
                <?php
                //On va vérifier si on réçoit le formulaire
                $date = '';
                $etage = '';
                $position = '';
                $puissance = '';
                $marque = '';
                $id='';
                $error = false;
                $error_form = array(0,0,0,0,0);
                //Vérifier si on demande on passe un mode edit et non en mode Ajout
                if(isset($_GET['id']) && isset($_GET['edit'])){
                    $sql = 'SELECT id, date_changement, etage, position, puissance, marque FROM ampoule WHERE id=:id';

                    $sth = $dbh->prepare( $sql );

                    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

                    $sth->execute();

                    $data = $sth->fetch(PDO::FETCH_ASSOC); 
                    //Si pas de résultat de la requête data est booleen
                    if(gettype($data) === "boolean"){
                        //On redirige la personne sur la page index
                        header('Location: index.php');

                        //On arrête le script
                        exit;
                    }
                    
                    $date = $data['date_changement']; 
                    $etage = $data['etage'];
                    $position = $data['position'];
                    $puissance = $data['puissance'];
                    $marque = $data['marque'];
                    $id = $data['id'];
                    $id = htmlentities($_GET['id']);
                } 
                //Si on n'a soumis le formulaire    
                if(count($_POST) > 0){
                    if(strlen(trim($_POST['date_changement']))!==0){
                        $date = trim($_POST['date_changement']);
                    }else{
                        $error = true;
                        $error_form[0] = "La date";
                    }
                    if(strlen(trim($_POST['etage']))!==0){
                        $etage = trim($_POST['etage']);
                    }else{
                        $error = true;
                        $error_form[1] = "L'étage";
                    }
                    if(strlen(trim($_POST['position']))!==0){
                        $position = trim($_POST['position']);
                    }else{
                        $error = true;
                        $error_form[2] = "La position";
                    }
                    if(strlen(trim($_POST['puissance']))!==0){
                        $puissance = trim($_POST['puissance']);
                    }else{
                        $error = true;
                        $error_form[3] = "La puissance";
                    }
                    if(strlen(trim($_POST['marque']))!==0){
                        $marque = trim($_POST['marque']);
                    }else{
                        $error = true;
                        $error_form[4] = "La marque";
                    }
                    if(isset($_POST['edit']) && isset($_POST['id'])){
                        $id = htmlentities($_POST['id']);
                    }
                    

                    //Si pas d'erreur alors on insere dans la base de donnée
                    if($error === false){
                        //Gestion des formats des dates en français

                        if(isset($_POST['edit']) && isset($_POST['id'])){
                            //On met à jour le affiche
                            $sql = 'update ampoule set date_changement=:date_changement, etage=:etage, position=:position, puissance=:puissance, marque=:marque where id=:id';

                        }else{
                            //On va insérer
                            $sql = "insert into ampoule(date_changement,etage,position,puissance,marque) VALUES(:date_changement,:etage,:position,:puissance,:marque)";
                        }
                        
                        $sth = $dbh->prepare($sql);
                        //bindParam important pour se protéger contre l'injection sql et HTML
                        $sth->bindValue(':date_changement', strftime("%Y-%m-%d",strtotime($date)), PDO::PARAM_STR);
                        $sth->bindParam(':etage', $etage, PDO::PARAM_STR);
                        $sth->bindParam(':position', $position, PDO::PARAM_STR);
                        $sth->bindParam(':puissance', $puissance, PDO::PARAM_STR);
                        $sth->bindParam(':marque', $marque, PDO::PARAM_STR);
                        
                        if(isset($_POST['edit']) && isset($_POST['id'])){
                            $sth->bindParam(':id', $id, PDO::PARAM_INT);
                        }
                        $sth->execute();

                        //Redirection après insertion
                        header('Location: index.php');
                    }
                }
                
                ?>
                <div class="form-layout">
                    <form action="" method="post" class="form-edit">
                        <div class="form-group">
                            <div class="label-layout">
                                <label for="date_changement">Date de changement</label>
                            </div>
                            <input type="date" name="date_changement" id="date_changement" placeholder="Date de changement" value="<?=$date; ?>">
                        </div>
                        <div class="form-group">
                            <div class="label-layout" >
                                <label for="etage">Étage</label>
                            </div>
                            <select name="etage" id="etage">
                                <option value=''>--Choisissez l'étage--</option>
                                <?php 
                                    for($i = 1; $i < 12; $i++){
                                        $selected = "";
                                        if ($etage == $i){
                                            $selected = "selected";
                                        }
                                        echo "<option value=\"$i\" $selected>$i</option>";
                                    }
                                ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <div class="label-layout">
                                <label for="position">Position</label>
                            </div>
                            <select name="position" id="position">
                                <?php 
                                    if(!isset($_GET['edit'])){
                                        echo "<option value=''>--Choisissez la position--</option>";
                                    }
                                    $Tab_Position = array('Côté gauche','Côté droit','Fond');
                                    foreach($Tab_Position as $item){
                                        $selected = "";
                                        if($item == $position){
                                            $selected = "selected";
                                        }
                                        echo  "<option value='$item' $selected>$item</option>";
                                        
                                    }
                                ?>
                                </select>
                                    
                        </div>
                        <div class="form-group">
                            <div class="label-layout">
                                <label for="puissance">Puissance (en W)</label>
                            </div>
                            <input type="text" name="puissance" id="puissance" placeholder="Puissance" value="<?=$puissance; ?>">
                        </div>
                        <div class="form-group">
                            <div class="label-layout">
                                <label for="marque">Marque</label>
                                </div>
                            <input type="text" name="marque" id="marque" placeholder="Marque" value="<?=$marque; ?>">
                        </div>
                        
                        <div class="form-btn">
                            <?php
                                if(isset($_GET['id']) && isset($_GET['edit'])){
                                    $textButton = "Modifier";
                                } else{
                                    $textButton = "Ajouter";
                                }
                            ?>
                            <button type="submit" class="btn"><?=$textButton ?></button>
                        </div>
                        <?php 
                            if(isset($_GET['id']) && isset($_GET['edit'])){
                        ?>
                                <input type="hidden" name="edit" value="1"/>
                                <input type="hidden" name="id" value="<?=$id ?>"/>
                        <?php
                            }
                        ?>
                    </form>
                    <?php 
                        echo'<div class="check-layout">';
                        $mauvaise_saisie = False;
                        foreach($error_form as $item){
                            if (!is_int($item)){
                                $mauvaise_saisie = True;
                            }
                        }
                        if ($mauvaise_saisie == True) {
                            echo'Veuillez saisir : <br>';
                        }
                        
                        foreach($error_form as $test){
                            
                            if (!is_int($test)){
                                echo '• '.$test.'<br>';
                            }
                        }
                        echo'</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
