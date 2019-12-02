<?php
session_start();
include 'inc/pdo.php';
include 'functions/functions.php';
$title = 'homepage';
$errors = array();
$success = false;
//traitement de formulaire

if (!empty($_POST['submitted'])) {
    //XSS
    $nickname = clean($_POST['nickname']);
    $email = clean($_POST['email']);
    $password1 = clean($_POST['password1']);
    $password2 = clean($_POST['password2']);

    //validation
    if (empty($nickname)) {
        $errors['nickname'] = "Veuillez renseigner ce champ";
    } elseif (mb_strlen($nickname) > 150) {
        $errors['nickname'] = "Max 120 caracteres";
    } elseif (mb_strlen($nickname) <= 2) {
        $errors['nickname'] = "Min 2 caracteres";
    } else {
        $sql = "SELECT id FROM user WHERE pseudo = :pseudo LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo', $nickname, PDO::PARAM_STR);
        $query->execute();
        $verif = $query->fetch();

        if (!empty($verif)) {
            $errors['nickname'] = 'Ce pseudo existe déjà';
        }
    }

    if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Veuillez entrer un email valide';
    } else {
        $sql = "SELECT id FROM user WHERE email = :email LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $verifmail = $query->fetch();
        if (!empty($verifmail)) {
            $errors['email'] = 'Cet email existe déjà';
        }
    }

    if (!empty($password1)) {
        if ($password1 != $password2) {
            $errors['password'] = 'Les deux mot de passe doivent être indentiques';
        } elseif (mb_strlen($password1) <= 5){
            $errors['password'] = 'Min 6 caractères';
        }
    } else {
        $errors['password'] = 'Veuillez entrer un mot de passe';
    }

    if(count($errors) == 0) {
        $hash = password_hash($password1, PASSWORD_BCRYPT);
        $token = generateRandomString(255);

        $sql = "INSERT INTO user VALUES (null, :pseudo, :email, :pass, :token, 'abonne', NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo', $nickname, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':pass', $hash, PDO::PARAM_STR);
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();
        $success = true;

        // redirection vers la connexion
        header('Location: login.php');
    }


}
//debug($_POST);
//debug($errors);

include 'inc/header.php'; ?>

    <h1>Inscription</h1>

    <form action="signup.php" method="post">
        <label for="nickname">Pseudo</label>
        <input type="text" name="nickname" id="nickname" value="<?php if (!empty($_POST['nickname'])) {echo $_POST['nickname'];}
        ?>">
        <?php spanErr($errors, 'nickname'); ?>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])) {echo $_POST['email'];}
        ?>">
        <?php spanErr($errors, 'email'); ?>

        <label for="password1">Mot de passe</label>
        <input type="password" name="password1" id="password1">
        <?php spanErr($errors, 'password'); ?>

        <label for="password2">Confirmez votre mot de passe</label>
        <input type="password" name="password2" id="password2">

        <input type="submit" name="submitted" value="Envoyer">
    </form>

<?php include 'inc/footer.php';
