<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
  <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de N.pi"/>
  <title>Pannel Admin</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main>

    <div class="mainheader_container">
      <div class="mainheader">
        </br>
        <h1>Pannel Admin</h1>
        <h2>Liste des utilisateurs (<?= count($data['user']) ?>)</h2>
        <?php
            foreach($data['user'] as $user)
            {
                echo "<br>".$user->getUsername()." <span class='delete'><img src='".IMG_PATH."/skull.png'></span>";
            }
        ?>
      </div>
    </div>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?=JS_PATH ?>/global.js"></script>

</body>

</html>
