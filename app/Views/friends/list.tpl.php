<a href="<?= $absoluteUrl ?>amis/invitation">Invitez des amis à ma liste</a>

<h2>Les utilisateurs de ma liste</h2>

<div class="friends-group">

  <?php foreach ($friends as $key => $value) : ?>

    <div class="friends">
      <div class="friends-item">
        <p>
          <?= "Nom : " . $value->getName() ."<br>Email : " . $value->getEmail() ?>
        </p>
        <a href="<?= $absoluteUrl ?>/amis/supprimer/<?= $value->getId() ?>">Supprimer l'utilisateur de ma liste</a>
      </div>
      <br>

    </div>
  <?php endforeach; ?>

</div>
