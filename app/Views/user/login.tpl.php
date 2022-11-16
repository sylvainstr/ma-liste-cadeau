<form action="<?= $absoluteUrl ?>connexion" method="POST">
  <label for="email">Adresse e-mail</label>
  <input type="email" id="email" name="email" required="required" placeholder="Votre adresse email" />
  <br />
  <label for="password">Mot de passe</label>
  <input type="password" id="password" name="password" required="required" placeholder="Votre mot de passe" />
  <br />
  <button type="submit">Se connecter</button>
</form>