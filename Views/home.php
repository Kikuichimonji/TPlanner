<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOME</title>
</head>
<body>
  <header>
    <?php require_once 'layout/menu.php'; ?>
  </header>

  <main>
    <h4>HOME</h4>
    <?php var_dump($data['notes'] ?? []); ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
