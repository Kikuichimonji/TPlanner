<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/css/style.css">
  <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
  <title>TPLanner</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main>
  
    <section class="paragraph_container">
      <div class="paragraph">
        </br>
        <h1>A Propos du Projet</h1>
        <h2>Sujet du projet n°2 : TRELLO LIKE</h2>
          <p>Une récente startup veut créer une nouvelle plateforme de gestionnaire de versions type GIT adaptée à un public
            plus large. Ils souhaitent intégrer leur propre solution Kanban. Vous avez gagné l’appel d’offre et devrez donc
            réaliser une application de gestion collaborative de tableau Kanban.</p>
            <p>Il doit s’agir d’un site pour créer et gérer des tableaux contenant des listes contenant elle-même des cartes.
            Vous pouvez voir et essayer une application similaire : Trello, en vous créant un compte gratuitement sur le site
            trello.com.</p>
            <p>Ce Trello Like devra être pensé avec simplicité, être intuitif et optimisé pour un gain de temps.
            Vous devez trouver un nom de marque, un logo ainsi qu’une charte graphique pour votre Trello Like.</p>
            <p>Le site peut être en Français, mais vous devez utiliser uniquement l’anglais dans votre code (commentaire, nom
            de fichier, nom de classe, …).</p>
            <p>La stack technologique est imposé : HTML/CSS/JS + PHP</p>
            <p>Bien entendu vous pouvez mettre en place une fonction de partage des tableaux entre utilisateurs, ainsi qu’un
            espace Administrateur pouvant servir à gérer les comptes des utilisateurs (Liste des utilisateurs, voir les détails
            d’un utilisateur précis, supprimer un utilisateur).</p>
            <p>Pour ce projet vous travaillerez en groupe de 2 étudiants maximum, vous vous repartirez le travail librement
            mais il sera exigé un temps de parole équitable lors de votre présentation devant jury.</p>
            <p>L’objectif est de concevoir un site web qui répond aux attentes suivantes :</p>
            <div>ATTENTES TECHNIQUES :
              <ul>
                <li>L’application doit contenir :</li>
                  <ul>
                    <li>1 page d'accueil</li>
                    <li>1 ou + page/modal login, register et réinitialisation de mot de passe</li>
                    <li>1 page Dashboard contenant au moins l'aperçu des Tableaux en cours (Kanban)</li>
                    <li>1 ou + page de profil (voir et modifier)</li>
                    <li>1 page dynamique contenant les Tableaux (Kanban)</li>
                    <li>Mise en place du SSL sur l’ensemble de l’apps</li>
                  </ul>
                <li>La charte graphique de l’apps contenant l’ensemble des logos et maquettes prévus</li>
                <li>Mise en place d’un Git collaboratif avec votre équipe</li>
                <li>Création d’un Outils de suivi AGILE (obligatoire) adapté pour le projet</li>
                <li>Les mentions obligatoires de gestion de projet :</li>
                  <ul>
                    <li>Le Product Backlog</li>
                    <li>La liste des tâches par membre d’équipe</li>
                    <li>Le calendrier de production (ou Gantt)</li>
                    <li>La listes des tests unitaires prévus pour le projet</li>
                    <li>La listes des Test QA effectué pour le projet</li>
                    <li>La liste des mesures prises par l’équipe pour assurer un workflow regulier</li>
                  </ul>
              </ul>
            </div>
            <p>L’application devra être hébergée sur les serveurs mis à votre disposition (ou tout autre serveur personnel)</p>
          </br>
      </div>
    </section>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/globalScript.js"></script>

</body>

</html>
