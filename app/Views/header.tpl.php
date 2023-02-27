<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $absoluteUrl ?>/assets/css/style.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- JS -->
  

  <title>Ma liste de cadeaux</title>
</head>

<body>

  <header>
    <a href="<?= $absoluteUrl ?>">Home</a>

    <?php if (!isset($_SESSION["user"])) : ?>
      <a href="<?= $absoluteUrl ?>connexion">Se connecter</a>
      <a href="<?= $absoluteUrl ?>inscription">S'inscrire</a>
    <?php else : ?>
      <a href="<?= $absoluteUrl ?>evenements">Mes événements</a>
      <a href="<?= $absoluteUrl ?>cadeaux">Mes cadeaux</a>
      <a href="<?= $absoluteUrl ?>amis">Mes amis</a>
      <a href="<?= $absoluteUrl ?>deconnexion">Se Déconnecter</a>
    <?php endif; ?>

  </header>

  <p>
    <?php
    App\Utils\FlashMessage::display_all_flash_messages(); ?>
  </p>

  <div class="wrapper">