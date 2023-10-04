<?php

require_once "./Config/globals.php";
require_once("./Config/db.php");
require_once("./Dao/userDAO.php");
require_once("./Models/user.php");
require_once("./Models/message.php");

$userDAO = new UserDAO($conn, $BASE_URL);

$message = new Message($BASE_URL);

$userData = $userDAO->verifyToken();

$infoMessage = [];

if(!empty($_SESSION["msg"])) {

    $infoMessage = $message->getMessage();
}

$message->clearMessage();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>
    <link rel="shortcut icon" href="./Public/img/mini_logo.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/main.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/auth.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/home.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/create_note.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/note_view.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/edit_note.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Public/css/responsivity.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1 class="logo"><a href="<?= $BASE_URL ?>/index.php"> <img src="<?= $BASE_URL ?>/Public/img/logo.png" alt="" class="logo-img"> My Notes</a></h1>
        </div>
        <nav class="navbar">

            <?php if ($userData) : ?>
                <ul>
                    <a href="<?= $BASE_URL ?>/logout.php">
                        <li>Sair</li>
                    </a>
                </ul>
            <?php else : ?>
                <ul>
                    <a href="<?= $BASE_URL ?>/login.php">
                        <li>Entrar</li>
                    </a>
                </ul>
            <?php endif; ?>

        </nav>
    </header>

    <?php if(!empty($infoMessage)): ?>

    <div class="info-message-container">
        <p class="info-message <?= $infoMessage["type"] ?>"><i class="fa-solid fa-circle-exclamation <?= $infoMessage["type"] ?>"></i> <span><?= $infoMessage["msg"] ?></span></p>
    </div>

    <?php endif; ?>
    
    