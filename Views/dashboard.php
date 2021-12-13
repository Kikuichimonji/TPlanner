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
    <?php 
      foreach($user->getListBoards() as $board)
      {
          echo "<span>{$board->getLabel()}</span>
          <div>";
          foreach($board->getListLists() as $list)
          {
            echo "<span>{$list->getLabel()}</span>";
            echo "<ul>";
              foreach($list->getListCards() as $card)
              {
                echo "<li><a>{$card->getTitle()}</a><p>{$card->getDescription()}</p></li>";
              }
            echo "</ul>";
          }
          echo"</div>";
      }
    ?>
    <?php //var_dump($user ?? []); ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
</body>
</html>
