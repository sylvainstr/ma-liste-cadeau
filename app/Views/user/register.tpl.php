<form action="<?= $absoluteUrl ?>inscription" method="POST">
  <label for="name">Nom d'utilisateur</label>
  <input type="name" id="name" name="name" required="required" placeholder="Votre nom ou pseudo" />
  <br />
  <label for="email">Adresse e-mail</label>
  <input type="email" id="email" name="email" required="required" placeholder="Votre addresse email" />
  <br />
  <label for="password">Mot de passe</label>
  <input type="password" id="password" name="password" required="required" placeholder="Votre mot de passe" />
  <br />
  <button type="submit">S'inscire</button>
</form>