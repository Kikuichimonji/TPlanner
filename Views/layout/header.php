<nav>
  <a href="index.php"><img src="<?= IMG_PATH?>TPlanner_logo.svg" alt=""></a>
  <?php 
    if(isset($_SESSION)){
      if(isset($_SESSION['user'])){
        echo  "<div id='headerContainer'>
                <span class='icon'>
                  <span style='background-color:".$_SESSION['user']->getColor()."'>".strtoupper(substr($_SESSION['user']->getUsername(),0,2))."</span>
                </span>
                <div id='popUpProfile' class='modalMenu'>
                  <p>Compte</p>
                  <ul>
                    <li><a href='dashboard.php'>DashBoard</a></li>
                    <li><a href='user.php'>Profil</a></li>
                    <li><a href=''>Paramètres</a></li>
                    <li><a href='login.php?act=logout'>Se Déconnecter</a></li>
                  </ul>
                </div>
              </div>";
      }else{
        echo  "<div id='headerConnection'>
                <a href='register.php' class='whiteBorder'>S'inscrire</a>
                <a href='login.php' class='purpleBorder'>Se connecter</a>
              </div>";
      }
    }else{
      echo  "<div id='headerConnection'>
              <a href='register.php' class='whiteBorder'>S'inscrire</a>
              <a href='login.php' class='purpleBorder'>Se connecter</a>
            </div>";
    }
  ?>
</nav>