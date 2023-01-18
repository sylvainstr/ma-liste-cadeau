<a href="<?= $absoluteUrl ?>evenements">Retour</a>

<h3>Modification d'une événement</h3>

<form action="" method="post">
  <div class="edit-event-group">
    <div class="edit-event-item">
      <label for="name">Nom</label>
      <input type="text" name="name" id="name" required="required" placeholder="Exemple : Liste de naissance" value="<?= $event_edit->getName() ?>">
    </div>
    <div class="edit-event-item">
      <label for="description">Votre message</label>
      <textarea type="text" name="description" id="description" required="required" placeholder="Tapez votre description...">
      <?= $event_edit->getDescription() ?>
      </textarea>
    </div>
    <div class="edit-event-item">
      <label for="invit-friend">Inviter un ami</label>
      <select name="invit-friend[]" id="invit-friend" required="required" multiple>
        <?php foreach ($friends as $friend) : ?>
          <option value="<?= $friend->getId() ?>"><?= $friend->getName() ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="edit-event-item">
      <label for="target_user">Pour</label>
      <select name="target_user" id="target_user">
        <option value="">Pour tout mes amis</option>
        <?php foreach ($friends as $friend) : ?>
          <option value="<?= $friend->getId() ?>"><?= $friend->getName() ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="edit-event-item">
      <label for="end_at">Date de fin</label>
      <input type="date" name="end_at" id="end_at" required="required" value="<?= $event_edit->getEndAt() ?>">
    </div>
  </div>

  <div class="edit-event-button">
    <button type="submit" name="submit">Modifier</button>
    <a href="<?= $absoluteUrl ?>evenements/supprimer/<?= $event_edit->getId(); ?>">Supprimer le cadeau</a>
  </div>
</form>