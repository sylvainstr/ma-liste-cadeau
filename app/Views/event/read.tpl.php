<a href="<?= $absoluteUrl ?>evenements">Retour</a>

<h2><?= ucfirst($event_read->getName()) ?></h2>
<h3><?= $event_read->getDescription() ?></h3>
<h3><?= $target_user->getName() ?></h3>
<h3><?= $event_read->getEndAt() ?></h3>

<div class="event-group">


  <div class="gift-event-group">
    <h2>Liste des cadeaux</h2>

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

        <div class="gift-item-rank">
          <h3><?= $gift->getRank() ?></h3>
        </div>

        <div class="stars">

          <?php
          for ($i = 1; $i <= 5; $i++) : ?>

            <?php if ($i <= $gift->getRank()) : ?>
              <i class="fas fa-star"></i>
            <?php else : ?>
              <i class="far fa-star"></i>
            <?php endif; ?>

          <?php endfor; ?>

        </div>

        <a href="#">J'offre ce cadeau</a>

      </div>
    <?php endforeach; ?>
  </div>

  <div class="add-friend-event">

    <h2>Invitez des amis</h2>
    <div class="add-group">
      <input type="text" id="friend-event" data-event="<?= $event_read->getId() ?>" name="friend-event" href="<?= $absoluteUrl ?>rechercher/amis/" placeholder="Saisir un nom ou un email">
      <div class="friend-list"></div>
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
</div>