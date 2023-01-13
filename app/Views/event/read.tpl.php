<?php $id = $event_read->getId(); ?>

<a href="<?= $absoluteUrl ?>evenements">Retour</a>

<h2><?= ucfirst($event_read->getName()) ?></h2>
<h3><?= $event_read->getTargetUser() ?></h3>
<h3><?= $event_read->getCreatedBy() ?></h3>
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
        <h3><?= $gift->getPreference() ?></h3>
      </div>

      <a href="#">J'offre ce cadeau</a>

      <a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/modifier/<?= $gift->getId() ?>">Modifier le cadeau</a>
      <a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/supprimer/<?= $gift->getId() ?>">Supprimer le cadeau</a>

    </div>
  <?php endforeach; ?>
</div>