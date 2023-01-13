  <a href="<?= $absoluteUrl ?>evenements/ajouter">Ajouter un événement</a>

  <div class="lists">
    <h2>Mes événements</h2>


    <?php foreach ($events as $event) : ?>

      <?php
      $eventId = $event->getId();
      ?>

      <p>NEW EVENT</p>

      <h3><?= ucfirst($event->getName()) ?></h3>
      <h3><?= $event->getDescription() ?></h3>

      <a href="<?= $absoluteUrl ?>evenements/<?= $eventId ?>">Voir l'événement</a>
      <a href="<?= $absoluteUrl ?>evenements/modifier/<?= $eventId ?>">Modifier l'événement</a>
      <a href="<?= $absoluteUrl ?>evenements/supprimer/<?= $eventId ?>">Supprimer l'événement</a>

    <?php endforeach; ?>

    <h2>Mes événements partagées</h2>

    <?php foreach ($friend_lists as $friend_list) : ?>

      <?php
      $eventId = $event->getId();
      ?>

      <p>NEW LIST</p>

      <h3><?= ucfirst($event->getName()) ?></h3>
      <h3><?= $event->getDescription() ?></h3>

      <a href="<?= $absoluteUrl ?>liste/<?= $id ?>">Voir l'événement</a>
      <a href="<?= $absoluteUrl ?>liste/modifier/<?= $eventId ?>">Modifier l'événement</a>
      <a href="<?= $absoluteUrl ?>liste/supprimer/<?= $eventId ?>">Supprimer l'événement</a>

    <?php endforeach; ?>

  </div>