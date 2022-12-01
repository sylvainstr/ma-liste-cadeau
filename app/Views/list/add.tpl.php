<?php if (isset($_SESSION["user"])) : ?>

  <a href="<?= $absoluteUrl ?>liste">Retour</a>

  <h3>Ajout d'une liste</h3>

  <form action="<?= $absoluteUrl ?>liste/ajouter" method="post">
    <div class="add-list-group">

      <label for="event">Nom de l'événement:</label>
      <select name="event" id="event">
        <option value="">Choisir un événement</option>

        <?php foreach (App\Models\Lists::$eventsType as $slug => $label) : ?>

          <option value="<?php echo $slug ?>"><?php echo $label ?></option>

        <?php endforeach; ?>
      </select>

      <div class="add-list-item-title">
        <label for="title">Titre</label>
        <input type="text" name="title" id="title" required="required" placeholder="Exemple : Liste de naissance">
      </div>
      <div class="add-list-item-subtitle">
        <label for="subtitle">Sous titre</label>
        <input type="text" name="subtitle" id="subtitle" placeholder="Exemple : Arrivée prévue pour Juin 2023">
      </div>
      <div class="add-list-item-message">
        <label for="message">Votre message</label>
        <textarea type="text" name="message" id="message" required="required" placeholder="Tapez votre message..."></textarea>
      </div>
    </div>

    <div class="add-list-button">
      <button type="submit" name="submit">Ajouter</button>
    </div>
  </form>


<?php else : ?>

  <?php header("Location: $absoluteUrl"); ?>

<?php endif; ?>