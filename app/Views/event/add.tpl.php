  <a href="<?= $absoluteUrl ?>evenements">Retour</a>

  <h3>Ajout d'une événement</h3>

  <form action="<?= $absoluteUrl ?>evenements/ajouter" method="post">
    <div class="add-event-group">
      <div class="add-event-item">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" required="required" placeholder="Exemple : Liste de naissance">
      </div>
      <div class="add-event-item">
        <label for="description">Votre message</label>
        <textarea type="text" name="description" id="description" required="required" placeholder="Tapez votre description..."></textarea>
      </div>
      <div class="add-event-item">
        <label for="invit-friend">Inviter un ami</label>
        <select name="invit-friend[]" id="invit-friend" required="required" multiple>
          <?php foreach($friends as $friend) : ?>
            <option value="<?= $friend->getId() ?>"><?= $friend->getName() ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="add-event-item">
        <label for="target_user">Pour</label>
        <select name="target_user" id="target_user">
          <?php foreach($friends as $friend) : ?>
            <option value="<?= $friend->getId() ?>"><?= $friend->getName() ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="add-event-item">
        <label for="end_at">Date de fin</label>
        <input type="date" name="end_at" id="end_at" required="required">
      </div>
    </div>

    <div class="add-description-button">
      <button type="submit" name="submit">Ajouter</button>
    </div>
  </form>