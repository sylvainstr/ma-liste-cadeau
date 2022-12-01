<a href="<?= $absoluteUrl ?>liste/<?= $list_id ?>">Retour</a>

<h3>Modification d'un cadeau</h3>
  <form action="" method="post">
  
  <div class="edit-gift-group">
  
    <div class="edit-gift-item-url_product">
      <label for="url_product">Lien du cadeau</label>
      <input type="url" name="url_product" id="url_product" required="required" placeholder="https://www.mon-site-de-jouet.com" value="<?= $gift_edit->getUrlProduct() ?>">
    </div>
    <div class="edit-gift-item-name">
      <label for="name">Nom du cadeau</label>
      <input type="text" name="name" id="name" placeholder="Exemple : Voiture Pat patrouille" value="<?= $gift_edit->getName() ?>">
    </div>
    <div class="edit-gift-item-shop">
      <label for="shop">Nom magasin du cadeau</label>
      <input type="text" name="shop" id="shop" placeholder="Exemple : King Jouet" value="<?= $gift_edit->getShop() ?>"></input>
    </div>
    <div class="edit-gift-item-price">
      <label for="price">Prix du cadeau</label>
      <input type="number" name="price" id="price" placeholder="Exemple : 39,00" value="<?= $gift_edit->getPrice() ?>">
    </div>
    <div class="edit-gift-item-url_image_product">
      <label for="url_image_product">Lien de l'image du cadeau</label>
      <input type="url" name="url_image_product" id="url_image_product" placeholder="https://www.mon-site-de-jouet.com/image/0026" value="<?= $gift_edit->getUrlImageProduct() ?>">
    </div>
    <div class="edit-gift-item-preference">
      <label for="preference">Préférence du cadeau</label>
      <input type="number" name="preference" id="preference" value="<?= $gift_edit->getPreference() ?>">
    </div>


  </div>

  <div class="edit-gift-button">
    <button type="submit" name="submit">Modifier</button>
    <a href="<?= $absoluteUrl ?>liste/<?= $list_id ?>/cadeau/supprimer/<?= $gift_edit->getId(); ?>">Supprimer la liste</a>
  </div>
  </form>