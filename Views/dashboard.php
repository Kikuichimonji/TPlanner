<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
  <header>
    <?php 
      require_once 'layout/menu.php'; 
      $user = $data['user']
    ?>
  </header>

  <main>
    <h4>Dashboard</h4>
    <p>Bienvenue <?= $user->getUsername() ?></p>
    <?php var_dump($user ?? []); ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
