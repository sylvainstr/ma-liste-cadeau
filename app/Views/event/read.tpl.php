<?php $id = $event_read->getId(); ?>

<a href="<?= $absoluteUrl ?>evenements">Retour</a>

<h2><?= ucfirst($event_read->getName()) ?></h2>
<h3><?= $event_read->getDescription() ?></h3>
<h3><?= $target_user->getName() ?></h3>
<h3><?= $event_read->getEndAt() ?></h3>


<h2>Liste des cadeaux</h2>

<div class="gift-group">
  <?php foreach ($gifts as $gift) : ?>

    <div class="gift">
      <div class="gift-item">
        <a href="<?= $gift->getUrlProduct() ?>" target="_blank">
          <img src="<?= $gift->getUrlImageProduct() ?>" alt="image du cadeau">
        </a>
      </div>
      <div class="gift-item">
        <h3><?= $gift->getName() ?></h3>
      </div>
      <div class="gift-item">
        <h3><a href="<?= $gift->getUrlProduct() ?>" target="_blank">Chez <?= $gift->getShop() ?></a></h3>
      </div>
      <div class="gift-item">
        <h3><?= $gift->getPrice() ?></h3>
      </div>

      <div class="gift-item">
        <h3><?= $gift->getRank() ?></h3>
      </div>

      <a href="#">J'offre ce cadeau</a>

      <a href="<?= $absoluteUrl ?>cadeaux/modifier/<?= $gift->getId() ?>">Modifier le cadeau</a>
      <a href="<?= $absoluteUrl ?>cadeaux/supprimer/<?= $gift->getId() ?>">Supprimer le cadeau</a>

    </div>
  <?php endforeach; ?>
</div>

<div class="add-friend-event">

  <h2>Invitez des amis</h2>
  <div class="add-group">
    <input type="text" id="friend-event" name="friend-event" placeholder="Saisir un nom ou un email">

    <a class="add-friend" href="<?= $absoluteUrl ?>evenements/<?= $event_read->getId() ?>/amis/ajouter">Ajouter un ami</a>
  </div>
  <h3>Liste des amis</h3>

  <div class="list-friend-event">
    <ul>
      <?php foreach ($users_event as $user) : ?>
        <li>
          <p><?= $user->getName() ?></p>
          <a class="delete-friend" href="<?= $absoluteUrl ?>evenements/<?= $event_read->getId() ?>/amis/supprimer/<?= $user->getId() ?>">
            <img src="<?= $absoluteUrl ?>/assets/images/cross.png" alt="image d'une croix">
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>