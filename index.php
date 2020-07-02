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
    <title>Gardien</title>
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
                <nav class="header-nav">
                    <div class="user-layout">
                        <div class="user-content">
                            <a href="">
                                <span>Zidane</span>
                                <img src="img/zidane.jpg" alt="Zinédine Zidane">
                            </a>
                            
                        </div>
                        <a href="logout.php">
                            <i class="material-icons icon icon-exit">exit_to_app</i>
                        </a>
                    <div>
                </nav>
                    
            <!--Fin du Header-->
            </header>
            
            <!--Début contenu principal-->
            <div class="main-container">
                <div class="heading-layout">
                    <h1>Liste des Ampoules</h1>
                </div>
                <div class="nav-sort">
                    <a href="edit.php" class="link-btn">
                        <i class="material-icons icon icon-add">add</i>
                    </a>
                    <a href="index.php" class="link-btn">
                        <i class="material-icons icon icon-add">refresh</i>
                    </a>
                    
                    <div class="search-layout">
                        <form action="" method="post">
                            <input name="search" type="text" class="search-query" placeholder="Chercher une ampoule...">
                            <button type="submit" class=""><i class="material-icons icon">search</i></button>
                        </form>
                    </div>
                </div>
                <!--Début Table-->
                <div class="table-container">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Étage</th>
                                <th>Position</th>
                                <th>Puissance</th>
                                <th>Marque</th>
                                <th></th>
                                <th></th>
                            </tr>   
                        </thead> 
                        <?php
                            //Préparation de la requête
                            $sql= 'SELECT id,date_changement, etage, position, puissance, marque FROM ampoule';
                            $sth = $dbh->prepare($sql);
    
                            //Exécution de la requête
                            $sth->execute();
    
                            //On recupère le résultat de la requête
                            $result = $sth->fetchAll(PDO::FETCH_ASSOC);  
                            
                            //Gestion des formats des dates en français
                            $intlDateFormater = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT,IntlDateFormatter::NONE);
                            //On test si c'est une recherche
                            if(!isset($_POST['search'])){
                                //On parcours le résultat et imprime à l'écran les données
                                //pour parcourir toutes es lignes on fait une boucle
                                foreach($result as $row){
                                    echo '<tr>';
                                    echo '<td>'.$row['id'].'</td>';
                                    echo '<td>'.$intlDateFormater->format(strtotime($row['date_changement'])).'</td>';
                                    echo '<td>'.$row['etage'].'</td>';
                                    echo '<td>'.$row['position'].'</td>';
                                    echo '<td>'.$row['puissance'].' W</td>';
                                    echo '<td>'.$row['marque'].'</td>';
                                    echo '<td><a href="edit.php?edit=1&id='.$row['id'].'"><i class="material-icons icon">edit</i></a></td>';
                                    echo '<td><button name="delete.php?id='.$row['id'].'" id="myBtn" class="btnDelete" onclick="confirmation('.$row['id'].')"><i class="material-icons icon">delete_outline</i></button></td>';
                                    echo '</tr>';
                                }
                            }else{
                                foreach($result as $row){
                                    if(($row['id'] == $_POST['search']) || ($row['etage'] == $_POST['search']) || ($row['position'] == $_POST['search']) || ($row['puissance'] == $_POST['search']) ||
                                    ($row['marque'] == $_POST['search'])){
                                        echo '<tr>';
                                        echo '<td>'.$row['id'].'</td>';
                                        echo '<td>'.$intlDateFormater->format(strtotime($row['date_changement'])).'</td>';
                                        echo '<td>'.$row['etage'].'</td>';
                                        echo '<td>'.$row['position'].'</td>';
                                        echo '<td>'.$row['puissance'].' W</td>';
                                        echo '<td>'.$row['marque'].'</td>';
                                        echo '<td><a href="edit.php?edit=1&id='.$row['id'].'"><i class="material-icons icon">edit</i></a></td>';
                                        echo '<td><button name="delete.php?id='.$row['id'].'" id="myBtn" class="btnDelete" onclick="confirmation('.$row['id'].')"><i class="material-icons icon">delete_outline</i></button></td>';
                                        echo '</tr>';
                                        $test = 0;  
                                    }
                                }
                            }
                        ?>
                    </table>
                </div>
                <!--Fin Table-->
                <?php
                //Si le tableau n'a aucun élément il affice aucun stagiaire
                if(count($result) === 0){
                    echo '<p class="text-center font-size-2">Aucune ampoule</p>';
                }elseif(!isset($test) && isset($_POST['search'])){
                    //Si la variable test n'est pas déclaré et qu'il n'y a pas de recherche alors il n'y a aucune ampoule selectionné
                    echo '<p class="text-center font-size-2">Aucune ampoule ne correspond à votre recherche.</p>';
                }
                ?>
            <!--Fin contenu principal-->
            </div>
        </div>
            <!--Fin du contenu de la page-->
    </div>
    <!--Fin de couverture de page-->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <p>Supprimer l'ampoule n°<span id="modal-span"></span> ?</p>
            </div>
            <div class="modal-body">
                <i class="material-icons icon icon-close">close</i>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" id="modal-yes" onclick="trash()">OUI</a>
                <a href="#" class="btn" id="modal-no" >NON</a>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>