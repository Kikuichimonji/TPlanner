<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
  <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
  <title>TPLanner</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main>
  
    <section class="mainheader_container">
      <div class="mainheader">
        </br>
        <h1>Tasks, Team, Testing and Time Planner : TPlanner</h1>
        <h2>La façon la plus simple de gérer vos projets !</h2>
        <div>
          <h3>Bienvenue sur TPlanner cher visiteur ! </h3>
          <p>Découvrez notre site : il est gratuit et facile d'utilisation. </p>
          </br>
          <a class="button" href='./register.php'>Inscrivez-vous gratuitement</a> </br>
          </br></br>
          <a class="link" href='./login.php'>Ou connectez-vous !</a>
        </div>
        <?php //isset($data) ? var_dump($data) : null; ?>
      </div>
      <img id="main_left" src="<?= IMG_PATH ?>/tplanner_image_relax-gauche.svg" alt="image zen de la page d'accueil" />
      <img id="main_right" src="<?= IMG_PATH ?>/tplanner_image_relax-droite.svg" alt="image zen de la page d'accueil" />
      <img id="separation" src="<?= IMG_PATH ?>/tplanner_background_separation-vague.svg" alt="separation" />
    </section>

    <section class="article_container">
      <div class="article">
        <img class="screenshot" src="<?= IMG_PATH ?>/tplanner_image_screenshot1.svg" alt="separation" />
        <div>
          <h3>Ici, pas de fonctionnalités compliquées. </h3>
          <p>L'application est tournée vers les tâches, l'équipe et vous aide à gérer les tests et votre temps. </br>
            Manager : garder la main sur les fonctionnalités importantes. </br>
            Equipes : modifier à volonté, éviter les risques.
          </p>
        </div>
      </div>
    </section>

    <section class="article_container">
      <div class="article">
        <div>
          <h3>Inscrivez-vous et gérer vos tableaux à l'infini </h3>
          <p>Vous pouvez participer à des tableaux qui vous sont partagés. </br>
            Seul le créateur du tableau pourra supprimer les éléments et assigner les tâches. </br>
            Le tout gratuitement et simplement ! 
          </p>
        </div>
        <img class="screenshot" src="<?= IMG_PATH ?>/tplanner_image_screenshot2.svg" alt="separation" />
      </div>
    </section>

    <section class="prefooter_container">
      <div class="prefooter">
        <ul>
          <li><h3>TPlanner</h3></li>
          <li><a class="link" href='./aboutProject.php'>A Propos du projet</a></li>
          <!--<a class="link" href='./contact.php'li>Contact</a></li>-->
          <li><a class="link" href='./legal.php'>Mentions légales</a></li>
          <li><a class="link" href='./privacy.php'>Politique de confidentialité</a></li>
        </ul>

        <a href="https://fr-fr.facebook.com/" target="_blank"><img class="network" src="<?= IMG_PATH ?>/tplanner_network_facebook.svg" alt="logo facebook" /></a>
        <a href="https://www.instagram.com/?hl=fr" target="_blank"><img class="network" src="<?= IMG_PATH ?>/tplanner_network_instagram.svg" alt="logo instagram" /></a>
        <a href="https://twitter.com/?lang=fr" target="_blank"><img class="network" src="<?= IMG_PATH ?>/tplanner_network_twitter.svg" alt="logo twitter" /></a>
        <a href="https://fr.linkedin.com/" target="_blank"><img class="network" src="<?= IMG_PATH ?>/tplanner_network_linkedin.svg" alt="logo linkedin" /></a>
        <a href="https://www.youtube.com/" target="_blank"><img class="network" src="<?= IMG_PATH ?>/tplanner_network_youtube.svg" alt="logo youtube" /></a>
      </div>

      <img id="prefooter_logo" src="<?= IMG_PATH ?>/TPlanner_logo-white.svg" alt="logo tplanner prefooter" />
      <img id="prefooter_left" src="<?= IMG_PATH ?>/tplanner_prefooter-gauche.svg" alt="image prefooter" />
      <img id="prefooter_right" src="<?= IMG_PATH ?>/tplanner_prefooter-droite.svg" alt="image prefooter" />
    </section>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/globalScript.js"></script>

</body>

</html>
