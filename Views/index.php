<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello</title>
</head>
<body>
  <header>
    <?php require_once 'layout/menu.php'; ?>
  </header>

  <main>
    <h4>Accueil</h4>
    <?php isset($data) ? var_dump($data) : null; ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
