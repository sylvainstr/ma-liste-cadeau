<?php $id = $list_read->getId(); ?>

<a href="<?= $absoluteUrl ?>liste">Retour</a>

<a href="<?= $absoluteUrl ?>liste/<?= $id ?>/inviter/amis">Invitez des amis à ma liste</a>
<a href="<?= $absoluteUrl ?>liste/<?= $id ?>/amis">Voir ma liste d'amis</a>

<h2><?= ucfirst($list_read->getEvent()) ?></h2>
<h3><?= $list_read->getTitle() ?></h3>
<h3><?= $list_read->getSubtitle() ?></h3>
<h3><?= $list_read->getMessage() ?></h3>

<a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/ajouter">Ajouter un cadeau</a>

<h2>Mes cadeaux</h2>

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