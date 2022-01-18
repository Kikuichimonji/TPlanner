<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/css/style.css">
  <link rel="icon" type="image/svg" href="./Assets/img/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
  <title>TPLanner</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main>

  <!-- HEADER SECTION -->
  
    <section class="mainheader_container">
      <div class="mainheader">
        </br>
        <h1>Tasks, Team, Testing and Time Planner : TPlanner</h1>
        <h2>La façon la plus simple de gérer vos projets !</h2>
        <div>
          <div>
            <h3>Bienvenue sur TPlanner cher visiteur ! </h3>
            <p>Découvrez notre site : il est gratuit et facile d'utilisation. </p>
            <a href='./register.php'>Inscrivez-vous gratuitement</a> </br>
            <a href='./login.php'>Ou connectez-vous !</a>
          </div>
          <?php //isset($data) ? var_dump($data) : null; ?>
          </div>
        </div>
      <img id="relax" src="./Assets/img/tplanner_image_relax.svg" alt="image zen de la page d'accueil" />
      <img id="separation" src="./Assets/img/tplanner_background_separation-vague.svg" alt="separation" />
    </section>

    <section class="article_container">
      <div class="article">
        <img src="./Assets/img/tplanner_image_screenshot1.svg" alt="separation" />
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
        <img src="./Assets/img/tplanner_image_screenshot2.svg" alt="separation" />
      </div>
    </section>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="./Assets/scripts/global.js"></script>

</body>

</html>
