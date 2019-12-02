<?php

function clean($string)
{
    return trim(strip_tags($string));
}

function debug($error)
{
    echo "<pre>";
    print_r($error);
    echo "</pre>";
}

function textValid($value, $err, $minl, $maxl, $key, $empty = true)
{
    if (!empty($value)) {
        if (mb_strlen($value) < $minl) {
            $err[$key] = 'Minimum ' . $minl . ' caracteres';
        } elseif (mb_strlen($value) > $maxl) {
            $err[$key] = 'Minimum ' . $maxl . ' caracteres';
        }
    } else {
        if ($empty) {
            $err[$key] = 'Veuillez renseigner le champ';
        }
    }
    return $err;
}

function cleanMail($err, $mail, $key)
{
    if (!empty($mail)) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $err[$key] = 'Email non valide';
        }
    } else {
        $err[$key] = 'Veuillez renseigner ce champ';
    }
    return $err;
}

function validateINT($err, $int, $key)
{
    if (!empty($int)) {
        if (!filter_var($int, FILTER_VALIDATE_INT)) {
            $err[$key] = 'Veuillez entrer une population valide';
        } elseif ($int <= 0) {
            $err['population'] = 'Ce champ doit être un entier positif';
        }
    } else {
        $err[$key] = 'Veuillez renseigner ce champ';
    }
    return $err;
}

function validateCountry($err, $string, $key)
{
    if (!empty($string)) {
        if (mb_strlen($string) != 3) {
            $err[$key] = 'Code pays incorrecte';
        }
    } else {
        $err[$key] = 'Veuillez renseigner ce champ';
    }
    return $err;
}

function spanErr($err, $key)
{
    if (!empty($err[$key])) {
        echo "<span class=\"error\">";
        echo $err[$key];
        echo "</span>";
    };
}

function random($arr)
{
    $rand = array_rand($arr, 1);
    echo $arr[$rand];
}

function pagination($nbPage)
{
    for ($i = 1; $i <= $nbPage; $i++) {
        echo " <a href=\"index.php?p=$i\">$i</a> /";
    }
}

function passwordValid($password, $err, $minl, $key)
{
    if (!empty($password)) {
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$lowercase || !$number) {
            $err[$key] = 'Votre mot de passe doit contenir au moins une lettre et un chiffre';
        } elseif (mb_strlen($password) < $minl) {
            $err[$key] = 'Votre mot de passe doit faire un minimum de ' . $minl . ' caractères';
        }
    } else {
        $err[$key] = 'Veuillez remplir ce champ';
    }
    return $err;
}

;
function generateToken()
{
    $token = '';
    $chaine = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ1234567890";
    for ($i = 0; $i < 255; $i++) {
        $token .= $chaine[rand(0, mb_strlen($chaine) - 1)];
    }
    return $token;
}

function formselect($err, $select, $key)
{
    if (empty($select)) {
        $err[$key] = 'Veuillez sélectionner une option';
    }
    return $err;
}

function inputDate($err, $date, $key)
{
    if (empty($date)) {
        $err[$key] = 'Veuillez entrer une date';
    }
    return $err;
}
