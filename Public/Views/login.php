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
    <h4>LOGIN</h4>
    <p class="error">
    <?php
      if(isset($data)){
        if(isset($data["error"])){
          echo $data["error"];
        }
      }
    ?>
    </p>
    <form action="login.php?act=submit" method="post">
      <label for="mail">Email</label>
      <input type="text" name="mail" id="mail">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      <button type="submit">Connection</button>
      <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
    </form>
    <p>Mot de passe oublié? </p><a href="">Réinitialisez le</a>
  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
