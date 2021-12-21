<nav>
  <a href="index.php"><img src="<?= IMG_PATH?>TPlanner_logo.svg" alt=""></a>
  <?php 
    if(isset($_SESSION)){
      if(isset($_SESSION['user'])){
        echo  "<div id='headerContainer'>
                <span class='icon'>
                  <span style='background-color:".$_SESSION['user']->getColor()."'>".strtoupper(substr($_SESSION['user']->getUsername(),0,2))."</span>
                </span>
                <div id='popUpProfile'>
                  <ul>
                    <li><a href='user.php'>Voir Profil</a></li>
                    <li><a href='dashboard.php'>DashBoard</a></li>
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