<a href="<?= $absoluteUrl ?>liste">Retour</a>

  <?php $id = $list_read->getId(); ?>

  <h3><?= ucfirst($list_read->getEvent()) ?></h3>
  <h3><?= $list_read->getTitle() ?></h3>
  <h3><?= $list_read->getSubtitle() ?></h3>
  <h3><?= $list_read->getMessage() ?></h3>

  <a href="<?= $absoluteUrl ?>liste/modifier/<?= $id ?>">Modifier une liste</a>
  <a href="<?= $absoluteUrl ?>liste/supprimer/<?= $id ?>">Supprimer la liste</a>