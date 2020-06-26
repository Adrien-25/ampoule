<?php
    require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gardien</title>
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
                        Gestion ampoules
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
                <div class="heading-layout">
                    <h1>Liste des Ampoules</h1>
                </div>
                <a href="edit.php" class="link-btn">
                    <i class="material-icons icon icon-add">add</i>
                </a>
                <!--Début Table-->
                <div class="table-container">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date de changement</th>
                                <th>Étage</th>
                                <th>Position</th>
                                <th>Puissance de l'ampoule</th>
                                <th>Marque de l'ampoule</th>
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
                                echo '<td><a href="delete.php?id='.$row['id'].'"><i class="material-icons icon">delete_outline</i><a/></td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
                <!--Fin Table-->
                <?php
                //Si le tableau n'a aucun élément il affice raucun stagiaire
                    if(count($result) === 0){
                        echo '<p class="text-center font-size-2">Aucune ampoule</p>';
                    }
                ?>
            <!--Fin contenu principal-->
            </div>
        </div>
            <!--Fin du contenu de la page-->
    </div>
    <!--Fin de couverture de page-->
</body>
</html>
