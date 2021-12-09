<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
</head>
<body>
  <header>
    <?php require_once 'layout/menu.php'; ?>
  </header>

  <main>
    <h4>LOGIN</h4>
    <?php isset($data) ? var_dump($data) : null; ?>
    <form action="login.php?act=submit" method="post">
      <label for="pseudo">Pseudo</label>
      <input type="text" name="pseudo" id="pseudo">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      <button type="submit">Connection</button>
    </form>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
