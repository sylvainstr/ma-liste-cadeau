<a href="<?= $absoluteUrl ?>liste">Retour</a>

<h3>Modification de la liste</h3>

<form action="" method="post">
  <div class="add-list-group">

    <label for="event">Nom de l'événement:</label>
    <select name="event" id="event">
      <?php foreach (App\Models\Lists::$eventsType as $slug => $label) : ?>

        <option value="<?php echo $slug ?>" <?php if($slug == $list_edit->getEvent()): ?>selected<?php endif; ?>><?php echo $label ?></option>

      <?php endforeach; ?>
    </select>

    <div class="add-list-item-title">
      <label for="title">Titre</label>
      <input type="text" name="title" id="title" required="required" placeholder="Exemple : Liste de naissance" value="<?= $list_edit->getTitle() ?>">
    </div>
    <div class="add-list-item-subtitle">
      <label for="subtitle">Sous titre</label>
      <input type="text" name="subtitle" id="subtitle" placeholder="Exemple : Arrivée prévue pour Juin 2023" value="<?= $list_edit->getSubtitle() ?>">
    </div>
    <div class="add-list-item-message">
      <label for="message">Votre message</label>
      <textarea name="message" id="message" required="required" placeholder="Tapez votre message...">
      <?= $list_edit->getMessage() ?>
      </textarea>
    </div>
  </div>

  <div class="add-list-button">

    <button type="submit" name="submit">Modifier</button>
    <a href="<?= $absoluteUrl ?>liste/supprimer/<?= $list_edit->getId(); ?>">Supprimer la liste</a>

  </div>

</form>