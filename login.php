<?php
  require_once('db.php');
  session_start();
  if(!empty($_SESSION['username'])){
    header('Location: index.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Gardien</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div class="login-page">
  
  <?php
  $username = "";
  $pass = "";
  $msg = "";

  if(!isset($_SESSION['username'])){   
    //Préparation de la requête
    $sql= 'SELECT id, username, pass FROM utilisateur';
    $sth = $dbh->prepare($sql);
    
    //Exécution de la requête
    $sth->execute();
    
    //On recupère le résultat de la requête
    $result = $sth->fetch(PDO::FETCH_ASSOC); 

    $username = $result['username'];
    $password = $result['pass'];

    if(isset($_POST['username'])){
      if ($_POST['username'] == $username && $_POST['pass'] == $password) {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $username; 
        header('Location: index.php');
      }else {
        $msg = 'Mauvais indentifiant ou mot de passe';
      }
    }
  }
  ?>
  <div class = "login-layout">
    <form class = "login-form" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <h1>Authentification</h1> 
      <input type = "text" class = "form-control" 
          name = "username" placeholder = "Identifiant"
          required autofocus>
      <input type = "password" class = "form-control"
          name = "pass" placeholder = "Mot de passe" required>
      <p class="login-msg"><?=$msg ?></p>
      <button class = "btn link-btn" type = "submit" name = "login">Connexion</button>
    </form>
  </div> 
</div>
</body>
</html>