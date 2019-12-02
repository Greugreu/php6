<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php6</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
<header>
    <nav class="nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if(!is_logged()) { ?>
                <li><a href="signup.php">Inscription</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } else { ?>
                <li><a href="signoff.php">Deconnexion</a></li>
                <li><?php echo 'Bonjour ' . $_SESSION['login']['pseudo']; ?></li>
            <?php } ?>
        </ul>
    </nav>
</header>
