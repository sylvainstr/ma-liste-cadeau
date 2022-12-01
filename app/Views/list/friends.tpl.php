<a href="<?= $absoluteUrl ?>liste/<?= $list_id ?>">Retour</a>


<h2>Les utilisateurs de ma liste</h2>

<div class="friends-group">
  <?php foreach ($friends as $key => $value) : ?>

    <div class="friends">
      <div class="friends-item">
        <p>
          <?= $value ?>
        </p>
        <a href="<?= $absoluteUrl ?>liste/<?= $list_id ?>/amis/<?= $value->getUser_id() ?>/supprimer">Supprimer l'utilisateur de ma liste</a>
      </div>
      <br>

    </div>
  <?php endforeach; ?>

  <a href="<?= $absoluteUrl ?>liste/<?= $list_id ?>/amis/supprimer">Supprimer tous les utilisateurs de ma liste</a>

</div>
