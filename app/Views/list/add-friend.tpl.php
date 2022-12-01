<?php if (isset($_SESSION["user"])) : ?>

  <a href="<?= $absoluteUrl ?>liste/<?= $list_id->getId() ?>">Retour</a>


  <h3>Ajout d'un ami</h3>

  <form action="" method="post">
    <div class="add-list-friend">

      <div class="friend-item">
        <label for="email">Email de l'invité</label>
        <input type="email" name="email" id="email" required="required" placeholder="Son addresse email">
      </div>

    </div>

    <div class="add-list-button">
      <button type="submit" name="submit">Ajouter</button>
    </div>
  </form>

<?php else : ?>

  <?php header("Location: $absoluteUrl"); ?>

<?php endif; ?>