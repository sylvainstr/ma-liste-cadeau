<a href="<?= $absoluteUrl ?>cadeaux">Retour</a>

<h3>Ajout d'un cadeau</h3>

<form action="<?= $absoluteUrl ?>cadeaux/ajouter" method="post">

  <div class="add-gift-group">

    <div class="add-gift-item-url_product">
      <label for="url_product">Lien du cadeau</label>
      <input type="url" name="url_product" id="url_product" required="required" placeholder="https://www.mon-site-de-jouet.com">
    </div>
    <div class="add-gift-item-name">
      <label for="name">Nom du cadeau</label>
      <input type="text" name="name" id="name" placeholder="Exemple : Voiture Pat patrouille">
    </div>
    <div class="add-list-item-shop">
      <label for="shop">Nom magasin du cadeau</label>
      <input type="text" name="shop" id="shop" placeholder="Exemple : King Jouet"></input>
    </div>
    <div class="add-gift-item-price">
      <label for="price">Prix du cadeau</label>
      <input type="number" name="price" id="price" placeholder="Exemple : 39,00">
    </div>
    <div class="add-gift-item-url_image_product">
      <label for="url_image_product">Lien de l'image du cadeau</label>
      <input type="url" name="url_image_product" id="url_image_product" placeholder="https://www.mon-site-de-jouet.com/image/0026">
    </div>
    <div class="add-gift-item-rank invisible">
      <label for="rank">Préférence du cadeau</label>
      <input type="number" name="rank" id="rank">
    </div>
    <div class="select-stars">
      <i class="fas fa-star" data-star="1"></i>
      <i class="fas fa-star" data-star="2"></i>
      <i class="fas fa-star" data-star="3"></i>
      <i class="fas fa-star" data-star="4"></i>
      <i class="fas fa-star" data-star="5"></i>
    </div>


  </div>

  <div class="add-gift-button">
    <button type="submit" name="submit">Ajouter</button>
  </div>
</form>

<script src="<?= $absoluteUrl ?>assets/js/stars.js" defer='true'></script>