<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/css/style.css">
  <title>LOGIN</title>
</head>
<body>
  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main id="login">
    <h4>LOGIN</h4>
    <p>
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
  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="./Assets/scripts/global.js"></script>
</body>
</html>
