<?php
    require_once('db.php');

    //Tester l'existence de la variable d'url
    if(isset($_GET['id'])){
        //Requête sql de suppression avec marqueur de paramètre
        $sql = "delete from ampoule where id = :id";

        //Prépare la requête
        $sth = $dbh->prepare($sql);

        //Lien entre marqueur nommé et une variable en précisant le type de données de la colonne sql
        $sth->bindParam(':id',$_GET['id'],PDO::PARAM_INT);

        //Executer la requête
        $sth->execute();

    }
    //Redirection après suppression
    header('Location: index.php' );
?>