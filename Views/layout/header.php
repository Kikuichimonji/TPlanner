<nav>
  <ul>
    <li>
      <a href="index.php">Accueil</a>
    </li>
    <li>
      <a href="login.php">Login</a>
    </li>
  </ul>
  <?php 
    if(isset($_SESSION)){
      if(isset($_SESSION['user'])){
        echo "<a href='' id='userMenu'>{$_SESSION['user']->getUsername()}</a>";
      }
    }
  ?>
</nav>
