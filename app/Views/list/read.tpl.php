<a href="<?= $absoluteUrl ?>liste">Retour</a>

<?php $id = $list_read->getId(); ?>

<h2><?= ucfirst($list_read->getEvent()) ?></h2>
<h3><?= $list_read->getTitle() ?></h3>
<h3><?= $list_read->getSubtitle() ?></h3>
<h3><?= $list_read->getMessage() ?></h3>

<a href="<?= $absoluteUrl ?>liste/modifier/<?= $id ?>">Modifier une liste</a>
<a href="<?= $absoluteUrl ?>liste/supprimer/<?= $id ?>">Supprimer la liste</a>
<a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/ajouter">Ajouter un cadeau</a>

<h2>Mes cadeaux</h2>
<?php foreach ($gifts as $gift) : ?>
  <h3><?= $gift->getUrlProduct() ?></h3>
  <h3><?= $gift->getName() ?></h3>
  <h3><?= $gift->getPrice() ?></h3>
  <h3><?= $gift->getDescription() ?></h3>
  <h3><?= $gift->getUrlImageProduct() ?></h3>
  <h3><?= $gift->getPreference() ?></h3>
  <a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/modifier/<?= $gift->getId() ?>">Modifier le cadeau</a>
  <a href="<?= $absoluteUrl ?>liste/<?= $id ?>/cadeau/supprimer/<?= $gift->getId() ?>">Supprimer le cadeau</a>
<?php endforeach; ?>