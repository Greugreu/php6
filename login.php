<?php
session_start();

require 'functions/functions.php';
require 'inc/pdo.php';

$title = 'Connexion';
$errors = array();
$success = false;

if (!empty($_POST['submitted'])) {
    //XSS
    $login = clean($_POST['login']);
    $password = clean($_POST['password']);

    if (empty($login) || empty($password)) {
        $errors['login'] = 'Veuillez renseigner ces champs';
    } else {
        $sql = "SELECT * FROM user WHERE pseudo = :login OR email = :login";
        $query = $pdo->prepare($sql);
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = array(
                    'id' => $user['id'],
                    'pseudo' => $user['pseudo'],
                    'role' => $user['role'],
                    'ip' => $_SERVER['REMOTE_ADDR']
                );
                debug($_SESSION);
            } else {
                $errors = 'Login ou mot de passe incorrect';
            }
        } else {
            $errors = 'Pseudo ou email incorrect';
        }

    }
}

include 'inc/header.php'; ?>

<h1>Connexion</h1>

    <form action="login.php" method="post">
        <label for="login">Pseudo ou email</label>
        <input type="text" name="login" id="login" value="<?php if (!empty($_POST['login'])) {echo $_POST['login'];}
        ?>">
        <?php spanErr($errors, 'login'); ?>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <?php spanErr($errors, 'password'); ?>

        <input type="submit" name="submitted" value="Login">
    </form>
    <a href="forget_password.php">Mot de passe oublié</a>

<?php include 'inc/footer.php';
