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
    <link rel="stylesheet" type="text/css" href="style.css" ></link>
    <link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div class="login-page">
  
  <?php
  $username = 'Macron';
  $password = 'chocolat';
  $msg = '';

  if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if ($_POST['username'] == $username && $_POST['password'] == $password) {
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username; 
      header('Location: index.php');
    }else {
      $msg = 'Wrong username or password';
    }
  }
  ?>

  <div class = "login-layout">
    <form class = "login-form" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <h1>Login</h1> 
      <input type = "text" class = "form-control" 
          name = "username" placeholder = "Username = <?=$username; ?>"
          required autofocus>
      <input type = "password" class = "form-control"
          name = "password" placeholder = "Password = <?=$password; ?>" required>
      <button class = "btn link-btn" type = "submit" name = "login">Login</button>
    </form>

    
    
  </div> 
</div>
</body>
</html>