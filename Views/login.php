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

  <main>
    <h4>LOGIN</h4>
    <?php isset($data) ? var_dump($data) : null;
      if(isset($_GET['err'])){
        if($_GET['err']== 1){
          echo '<p> Vous devez être connecté pour voir cette page<p/>';
        }
      }
    ?>
    <form action="login.php?act=submit" method="post">
      <label for="pseudo">Pseudo</label>
      <input type="text" name="pseudo" id="pseudo">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      <button type="submit">Connection</button>
      <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
    </form>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
