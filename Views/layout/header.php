<nav>
  <a href="index.php">LOGO</a>
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
      }else{
        echo  "<div>
                <a href='' id=''>S'inscrire</a>
                <a href='login.php' id=''>Se connecter</a>
              </div>";
      }
    }
  ?>
</nav>