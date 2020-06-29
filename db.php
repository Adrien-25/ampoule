<?php
define('DATABASE', 'adriens_');
//define('USER', 'root');
define('USER', 'adriens');
//define('PWD', '');
define('PWD', 'sHXd4ZJ2qCL8rA==');
//define('HOST','localhost');
define('HOST','https://promo-39.codeur.online/adminer/?server=promo-39.codeur.online');
//

try {
    $dbh = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

?>