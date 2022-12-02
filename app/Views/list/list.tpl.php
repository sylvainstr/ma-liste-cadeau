  <a href="<?= $absoluteUrl ?>liste/ajouter">Ajouter une liste</a>

  <div class="lists">
    <h2>Mes listes</h2>

    <?php foreach ($lists as $list) : ?>

      <?php
      $id = $list->getId();
      ?>

      <p>NEW LIST</p>

      <h3><?= ucfirst($list->getEvent()) ?></h3>
      <h3><?= $list->getTitle() ?></h3>
      <h3><?= $list->getSubtitle() ?></h3>
      <h3><?= $list->getMessage() ?></h3>

      <a href="<?= $absoluteUrl ?>liste/<?= $id ?>">Voir la liste</a>
      <a href="<?= $absoluteUrl ?>liste/modifier/<?= $id ?>">Modifier la liste</a>
      <a href="<?= $absoluteUrl ?>liste/supprimer/<?= $id ?>">Supprimer la liste</a>

    <?php endforeach; ?>

    <h2>Mes listes paratagées</h2>

    <?php foreach ($friend_lists as $friend_list) : ?>

      <?php
      $id = $friend_list->getId();
      ?>

      <p>NEW LIST</p>

      <h3><?= ucfirst($friend_list->getEvent()) ?></h3>
      <h3><?= $friend_list->getTitle() ?></h3>
      <h3><?= $friend_list->getSubtitle() ?></h3>
      <h3><?= $friend_list->getMessage() ?></h3>

      <a href="<?= $absoluteUrl ?>liste/<?= $id ?>">Voir la liste</a>
      <a href="<?= $absoluteUrl ?>liste/modifier/<?= $id ?>">Modifier la liste</a>
      <a href="<?= $absoluteUrl ?>liste/supprimer/<?= $id ?>">Supprimer la liste</a>

    <?php endforeach; ?>

  </div>