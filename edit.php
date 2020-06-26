<?php
    require_once('db.php');
?>
<?php
    require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une ampoule</title>
    <link rel="stylesheet" type="text/css" href="style.css" ></link>
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
                        Gestion Ampoules
                    </a>
                </div>
                <a class="link-btn" id="nav-btn" href="#">
                    <i class="material-icons icon icon-menu">menu</i>
                </a>
                <nav class="header-nav">
                    <ul>
                        <li><a href="index.php">Acceuil</a></li>
                        <li><a href="edit.php">Ajouter </a></li>
                        <li><a href="#">Modifier</a></li>
                        <li><a href="#">Supprimer</a></li>
                    </ul>
                    <div class="header-search">
                        <input type="text" class="search-query" placeholder="Chercher une ampoule...">
                        <a href="#">
                            <i class="material-icons icon">search</i>
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
                    <a href=index.php class="link-btn">
                        <i class="material-icons icon icon-home">home</i>
                    </a>
                  
                <?php
                //On va vérifier si on réçoit le formulaire
                $date = '';
                $etage = '';
                $position = '';
                $puissance = '';
                $marque = '';
                $id='';
                $error = false;
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
                    }
                    if(strlen(trim($_POST['etage']))!==0){
                        $etage = trim($_POST['etage']);
                    }else{
                        $error = true;
                    }
                    if(strlen(trim($_POST['position']))!==0){
                        $position = trim($_POST['position']);
                    }else{
                        $error = true;
                    }
                    if(strlen(trim($_POST['puissance']))!==0){
                        $puissance = trim($_POST['puissance']);
                    }else{
                        $error = true;
                    }
                    if(strlen(trim($_POST['marque']))!==0){
                        $marque = trim($_POST['marque']);
                    }else{
                        $error = true;
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
                            <label for="date_changement">Date de changement</label>
                            <input type="date" name="date_changement" id="date_changement" placeholder="Date de changement" value="<?=$date; ?>">
                        </div>
                        <div class="form-group">
                            <label for="etage">Étage</label>
                            <select name="etage" id="etage">
                                <?php 
                                    if(!isset($_GET['edit'])){
                                        echo"<option value=''>--Choisissez la position--</option>";
                                    }
                                    for($i = 1; $i < 12; $i++){
                                        $selected = "";
                                        if ($etage == "Étage $i"){
                                            $selected = "selected";
                                        }
                                        echo "<option value=\"Etage $i\" $selected>Etage $i</option>";
                                    }
                                ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
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
                            <label for="puissance">Puissance</label>
                            <input type="text" name="puissance" id="puissance" placeholder="Puissance" value="<?=$puissance; ?>">
                        </div>
                        <div class="form-group">
                            <label for="marque">Marque</label>
                            <input type="text" name="marque" id="marque" placeholder="Marque" value="<?=$marque; ?>">
                        </div>
                        
                        <div>
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
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
