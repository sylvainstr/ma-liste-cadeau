<?php

namespace App\Controllers;

use App\Utils\Database;
use App\Models\User;
use App\Repository\UserRepository;
use App\Utils\Config;
use App\Utils\FlashMessage;

class UserController extends CoreController
{
  /**
   * Inscrire un utilisateur
   *
   * @return void
   */
  public function register()
  {
    if (isset($_SESSION["user"])) {
      // si l'utilisateur est connecté on redirige vers la page d'acceuil
      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }
    // On vérifie si le formulaire a été envoyé
    if (!empty($_POST)) {
      // Le formulaire a été envoyé
      // On vérifie que tous les champs requis sont remplis
      if (isset($_POST["name"], $_POST["email"], $_POST["password"]) && !empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        // Le formulaire est complet
        // On récupére les données en les protégeant
        $name = strip_tags($_POST["name"]);
        $email = $_POST['email'];
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          FlashMessage::create_flash_message('error', "L'adresse email est incompléte", 'FLASH_ERROR');
          $config = Config::getInstance();
          $absoluteUrl =  $config['ABSOLUTE_URL'];
          header("Location: $absoluteUrl" . "inscription");
        }

        // On va hasher le mot de passe
        $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);


        // Ajouter ici tous les contrôles souhaités

        try {
          $newUser = new User($name, $email, $password);
          $userRepo = new UserRepository();
          $userRepo->add($newUser);
        } catch (\Exception $exception) {
          var_dump($exception->getMessage());
        }

        // On récupére l'id du nouvel utilisateur
        $pdo = Database::getPDO();
        $id = $pdo->lastInsertId();

        // On connectera l'utilisateur
        // On stocke dans $_SESSION les informations de l'utilisateur
        $_SESSION["user"] = [
          "id" => $id,
          "name" => $name,
          "email" => $email,
          "role" => ["ROLE_USER"]
        ];

        // On redirige vers la page d'acceuil
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl");
        exit;
      } else {
        FlashMessage::create_flash_message('error', "Le formulaire est incomplet", 'FLASH_ERROR');
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl" . "inscription");
      }
    }

    $this->render('user/register');
  }

  /**
   * Connecter un utilisateur
   *
   * @return void
   */
  public function login()
  {
    if (isset($_SESSION["user"])) {
      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl");
      exit;
    }
    // On vérifie si le formailaire a été envoyé
    if (!empty($_POST)) {
      // Le formulaire a été envoyé
      // On vérifie que tous les champs requis sont remplis
      if (isset($_POST["email"], $_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST['email'];


        // On vérifie que c'est bien un email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          FlashMessage::create_flash_message('error', "Ce n'est pas un email", 'FLASH_ERROR');
          $config = Config::getInstance();
          $absoluteUrl =  $config['ABSOLUTE_URL'];
          header("Location: $absoluteUrl" . "connexion");
        }

        $email = $_POST['email'];

        try {
          $userRepo = new UserRepository();
          $user = $userRepo->findByEmail($email);
          if (!$user) {
            FlashMessage::create_flash_message('error', "L'utilisateur et/ou le mot de passe est incorrect", 'FLASH_ERROR');
            $config = Config::getInstance();
            $absoluteUrl =  $config['ABSOLUTE_URL'];
            header("Location: $absoluteUrl" . "connexion");
          }

          // Ici on a un user existant, on peut vérifier le mot de passe
          if (!password_verify($_POST["password"], $user->getPassword())) {
            FlashMessage::create_flash_message('error', "L'utilisateur et/ou le mot de passe est incorrect", 'FLASH_ERROR');
            $config = Config::getInstance();
            $absoluteUrl =  $config['ABSOLUTE_URL'];
            header("Location: $absoluteUrl" . "connexion");
          }
          // Ici l'utilisateur et le mot de passe son corrects
          // On va pouvoir "connecter" l'utilisateur       
          // On stocke dans $_SESSION les informations de l'utilisateur
          $_SESSION["user"] = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail()
          ];
        } catch (\Exception $exception) {
          var_dump($exception->getMessage());
        }



        // On redirige vers la page d'acceuil
        $config = Config::getInstance();
        $absoluteUrl =  $config['ABSOLUTE_URL'];
        header("Location: $absoluteUrl");
        exit;
      }
    }

    $this->render('user/login');
  }

  /**
   * Déconnecter un utilisateur
   *
   * @return void
   */
  public function logout()
  {
    session_start();
    if (!isset($_SESSION["user"])) {
      $config = Config::getInstance();
      $absoluteUrl =  $config['ABSOLUTE_URL'];
      header("Location: $absoluteUrl" . "connexion");
      exit;
    }

    // Supprime une variable
    unset($_SESSION["user"]);

    $config = Config::getInstance();
    $absoluteUrl =  $config['ABSOLUTE_URL'];
    header("Location: $absoluteUrl");
    exit;
  }
}
