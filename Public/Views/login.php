<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
  <title>LOGIN</title>
</head>
<body>
  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main id="login">
    <h1>Connectez-vous sur TPlanner</h1>
    
    <?php
      if(isset($data)){
        if(isset($data["error"])){
          echo '<p class="error">'.$data["error"].'</p>';
        }if(isset($data["success"])){
          echo '<p class="success">'.$data["success"].'</p>';
        }
      }
    ?>

    <section class="forms_container">
    <div class="forms">
    <form action="login.php?act=submit" method="post">
    <fieldset class="fieldset_container">
      <label for="mail">Email</label>
      <input type="text" name="mail" id="mail">
      </br>
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      </br></br>
      <button type="submit">Se connecter</button>
      <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
      </br>
      <a href="login.php?act=reset">Mot de passe oublié ? Réinitialisez le</a>
    </fieldset>
    </form>
  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
