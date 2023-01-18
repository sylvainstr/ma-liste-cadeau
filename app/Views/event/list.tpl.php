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

    <?php foreach ($friend_events as $friend_event) : ?>

      <?php
      $eventId = $friend_event->getId();
      ?>

      <h3><?= ucfirst($friend_event->getName()) ?></h3>
      <h3><?= $friend_event->getDescription() ?></h3>

      <a href="<?= $absoluteUrl ?>evenements/<?= $eventId ?>">Voir l'événement</a>
      <a href="<?= $absoluteUrl ?>evenements/modifier/<?= $eventId ?>">Modifier l'événement</a>
      <a href="<?= $absoluteUrl ?>evenements/supprimer/<?= $eventId ?>">Supprimer l'événement</a>

    <?php endforeach; ?>

  </div>