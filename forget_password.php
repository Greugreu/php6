<?php
session_start();
require 'inc/pdo.php';
require 'functions/functions.php';
$title = 'Mote de passe oublié';
$errors = array();
$success = false;

if (!empty($_POST['submitted'])) {
    $email = clean($_POST['email']);
    $sql = "SELECT email, token FROM user WHERE email = :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    if (!empty($user)) {
        $token = $user['token'];
        $email = urlencode($user['email']);
        $html = '<a href="modif_password.php?token='.$token.'&mail='.$email.'">C\'est ici</a>';
        echo $html;

    } else {
        $errors['email'] = 'Email inconnu';
    }
}

include 'inc/header.php'; ?>

<h1>Mot de passe oublié</h1>

<form action="" method="post">
    <label for="email">Votre email</label>
    <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])) { echo $_POST['email'];} ?>">
    <p class="error"><?php if (!empty($errors['email'])) {echo $erors['email'];} ?></p>

    <input type="submit" name="submitted" value="Modifier mote de passe">
</form>

<?php include 'inc/footer.php';
