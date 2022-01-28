<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
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
        <h1>MENTIONS LÉGALES</h1>
        <h2>Editeur</h2>
          <p>Le site TPlanner est édité par CCI Campus, ayant son siège social en France : CCI Strasbourg.</br>
              Directeur de la publication : ROESS Thomas - NGAU Epiphanie, développeurs web.</br>
              Création du site : ROESS Thomas - NGAU Epiphanie – CCI – 67000 Strasbourg – France.</br>
              Hébergement : O2Switch – 222 Bd Gustave Flaubert – 63000 Clermont-Ferrand.</p>
        <h2>Droits d’auteurs et copyright</h2>

          <h3>Copyright</h3>
            <p>L’ensemble de ce site relève de la législation française et internationale sur le droit d’auteur et la
                propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris les documents
                téléchargeables et les représentations iconographiques. Vous vous interdirez de reproduire, pour un
                usage autre que privé, vendre, distribuer, émettre, diffuser, adapter, modifier, publier, communiquer
                intégralement ou partiellement, sous quelque forme que ce soit, les données, la présentation ou
                l’organisation du site sans autorisation préalable écrite de la gestionnaire du site.</p>
            <p>Les marques citées sur ce site sont déposées pas les sociétés qui en sont propriétaires. Les documents
                diffusés en version électronique sur ce site peuvent avoir fait l’objet d’une mise à jour entre le
                moment où vous les avez téléchargés et celui ou vous en prenez connaissance. En conséquence, nous vous
                recommandons d’en vérifier la validité.</p>

          <h3>Protection des données personnelles</h3>
            <p>Au cours de votre navigation sur ce site, vous pourrez être amené à communiquer des informations revêtant
                un caractère directement ou indirectement nominatif. Ces informations sont réservées à un usage
                strictement interne. L’usage de votre adresse e-mail et/ou de vos coordonnées récoltées dans le cadre
                des formulaires de contact sera uniquement destiné au traitement de votre demande. La durée de
                conservation de ces informations est de 1 an. En aucun cas la cession ou la mise à disposition à des
                tiers, à des fins commerciales de votre adresse ou de vos coordonnées ne pourra être opérée sans que
                vous ne soyez préalablement mis en mesure de vous y opposer. A cet effet vous pouvez contacter le
                webmaster par mail.</p>
            <p>Dans l’éventualité où vous auriez communiqué sur ce site votre adresse e-mail et/ou vos coordonnées, vous
                pourrez à tout moment vous faire radier de tout fichier et de tout traitement auxquels ces informations
                ont donné lieu. A cet effet vous pouvez contacter le webmaster par mail. (LOI N° 78-17 du 6 janvier 1978
                relative à l’informatique, aux fichiers et aux libertés.)</p>

          <h3>Utilisation des « Cookies »</h3>
            <p>Lors de la consultation du site https://tplanner.thomas-roess.fr/.com, des informations relatives à la navigation de 
                votre terminal (ordinateur, tablette, smartphone, etc.) sur le site, sont susceptibles d’être enregistrées 
                dans des fichiers « Cookies » installés sur votre terminal, sous réserve des choix que vous auriez exprimés 
                concernant les Cookies et que vous pouvez modifier à tout moment grâce aux paramètres de votre logiciel de navigation.
                Les Cookies que nous émettons sont utilisés aux fins décrites ci-dessous, sous réserve de vos choix, qui résultent des 
                paramètres de votre logiciel de navigation utilisé lors de votre visite de du site : <br>
                – d’adapter la présentation de notre site aux préférences d’affichage de votre terminal (langue utilisée, résolution 
                d’affichage, système d’exploitation utilisé, etc.) lors de vos visites sur notre site, selon les matériels et les 
                logiciels de visualisation ou de lecture que votre terminal comporte;</br>
                – d’obtenir des mesures d’audience et de traffic;</p>
            <p>L’enregistrement d’un cookie dans un terminal est essentiellement subordonné à la volonté de l’utilisateur du Terminal, 
                que celui-ci peut exprimer et modifier à tout moment et gratuitement à travers les choix qui lui sont offerts par son 
                logiciel de navigation. Si vous avez accepté dans votre logiciel de navigation l’enregistrement de cookies dans votre Terminal, 
                les cookies intégrés dans les pages et contenus que vous avez consultés pourront être stockés temporairement dans un espace 
                dédié de votre Terminal. Ils y seront lisibles uniquement par leur émetteur.</p>
            <p>Si vous refusez l’enregistrement de cookies dans votre terminal, ou si vous supprimez ceux qui y sont enregistrés, vous 
                ne pourrez plus bénéficier d’un certain nombre de fonctionnalités qui sont néanmoins nécessaires pour naviguer dans certains 
                espaces de notre site. Tel serait le cas si vous tentiez d’accéder à nos contenus ou services qui nécessitent de vous identifier, 
                et notamment à l’espace Boutique web et votre compte. Le cas échéant, nous déclinons toute responsabilité pour les conséquences 
                liées au fonctionnement dégradé de nos services résultant de l’impossibilité pour nous d’enregistrer ou de consulter les cookies 
                nécessaires à leur fonctionnement et que vous auriez refusés ou supprimés.</p>
      </div>
    </section>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/globalScript.js"></script>

</body>

</html>
