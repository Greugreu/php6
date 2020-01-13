<?php
session_start();
require 'inc/pdo.php';
require 'functions/functions.php';
$title = 'Mote de passe oublié';
$errors = array();
$success = false;

include 'inc/header.php';

if (!empty($_GET['token'] && !empty($_GET['mail']))) {

    $token_url = urldecode($_GET['token']);
    $email_url = $_GET['mail'];

    $sql = "SELECT email, token FROM user WHERE email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email_url, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if ($user['email'] === $email_url && $user['token'] === $token_url) { ?>
        <h1>Mot de passe oublié</h1>

        <form action="" method="post">
            <label for="password">Votre nouveau mdp</label>
            <input type="password" name="password" id="password">

            <label for="password2">Confirmez votre nouveau mdp</label>
            <input type="password" name="password2" id="password2">

            <input type="submit" name="submitted" value="Envoyer">
        </form> <?php


        if (!empty($_POST['submitted'])) {
            $password1 = clean($_POST['password']);
            $password2 = clean($_POST['password2']);

            if (empty($_POST['password'])) {
                $errors['password'] = 'Veuillez renseigner ce champ';
            } elseif (empty($_POST['password2'])) {
                $errors['password'] = 'Veuillez renseigner ce champ';
            } elseif ($password1 != $password2) {
                $errors['password'] = 'Les mots de passes ne sont pas identiques';
            } else {

                if (count($errors) === 0) {
                    $hash = password_hash($password1, PASSWORD_BCRYPT);
                    $token = generateRandomString(255);
                    $sql = "UPDATE user SET password = :pass, token = :token";
                    $query = $pdo->prepare($sql);
                    $query->bindValue(':pass', $hash, PDO::PARAM_STR);
                    $query->bindValue(':token', $token, PDO::PARAM_STR);
                    $query->execute();
                }

            }

        }

    }

} else {
    die('Prends moi pour un con');
}





include 'inc/footer.php';
