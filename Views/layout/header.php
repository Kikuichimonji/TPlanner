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
        echo  "<div id='headerContainer'>
                <a href='' id='userMenu'>{$_SESSION['user']->getUsername()}</a>
                <div id='popUpProfile'>
                  <ul>
                    <li><a href=''>Voir Profil</a></li>
                    <li><a href=''>Autre Option</a></li>
                    <li><a href='login.php?act=logout'>Se deconnecter</a></li>
                  </ul>
                </div>
              </div>";
      }
    }
  ?>
</nav>