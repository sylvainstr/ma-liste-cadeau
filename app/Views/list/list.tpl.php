  <div class="lists">   

    <a href="<?= $absoluteUrl ?>liste/cadeau/ajouter">Ajouter un cadeau</a>

    <?php if (!empty($friends)) : ?>
      <a href="<?= $absoluteUrl ?>liste/amis">Voir ma liste d'amis</a>
    <?php endif; ?>

    <h2>Ma liste de cadeaux</h2>

    <div class="gift-group">

      <?php foreach ($gifts as $gift) : ?>

        <div class="gift">
          <div class="gift-item">
            <a href="<?= $gift->getUrlProduct() ?>" target="_blank">
              <img src="<?= $gift->getUrlImageProduct() ?>" alt="image du cadeau">
            </a>
          </div>
          <div class="gift-item">
            <h3><?= $gift->getName() ?></h3>
          </div>
          <div class="gift-item">
            <h3><a href="<?= $gift->getUrlProduct() ?>" target="_blank">Chez <?= $gift->getShop() ?></a></h3>
          </div>
          <div class="gift-item">
            <h3><?= $gift->getPrice() ?></h3>
          </div>

          <div class="gift-item">
            <h3><?= $gift->getRank() ?></h3>
          </div>

          <a href="#">J'offre ce cadeau</a>

          <a href="<?= $absoluteUrl ?>liste/cadeau/modifier/<?= $gift->getId() ?>">Modifier le cadeau</a>
          <a href="<?= $absoluteUrl ?>liste/cadeau/supprimer/<?= $gift->getId() ?>">Supprimer le cadeau</a>

        </div>
      <?php endforeach; ?>
    </div>



  </div>