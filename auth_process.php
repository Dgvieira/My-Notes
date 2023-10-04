<?php

require_once("./Config/globals.php");
require_once("./Config/db.php");
require_once("./Models/user.php");
require_once("./Dao/userDAO.php");
require_once("./Models/message.php");

$user = new User();
$userDAO = new UserDAO($conn, $BASE_URL);
$message = new Message($BASE_URL);


$type = filter_input(INPUT_POST, "type");


if ($type === "register") {

    $user_name = filter_input(INPUT_POST, "user_name");
    $password = filter_input(INPUT_POST, "password");

    // verifica se os campos estão preenchidos

    if ($user_name != "" && $password != "") {

        // verifica se o usuário existe no banco de dados

        if ($userDAO->findByUserName($user_name)) {

            $message->setMessage("O nome de usuário já está sendo usado.", "error", "back");

        } else {

            $user = new User();

            $token = $user->generateToken();

            $hash_password = $user->generatePassword($password);

            $user->user_name = $user_name;
            $user->password = $hash_password;
            $user->token = $token;

            $userDAO->setTokenToSession($user->token);

            $userDAO->create($user);

            $message->setMessage("Seja bem-vindo, $user->user_name!", "success", "home.php");
        }
    } else {

        $message->setMessage("Preencha todos os campos!", "error", "back");
    }
}


if($type === "login") {

    $user_name = filter_input(INPUT_POST, "user_name");
    $password = filter_input(INPUT_POST, "password");

    // verifica se os campos estão preenchidos

    if($user_name != "" && $password != "") {

        // tenta autenticar usuário

        if($user = $userDAO->authenticateUser($user_name, $password)) {

            $message->setMessage("Seja bem-vindo, $user->user_name!", "success", "home.php");

        } else {

            $message->setMessage("Nome de usuário e/ou senha incorretos!", "error", "back");
        }
        


    } else {

        $message->setMessage("Preencha todos os campos!", "error", "back");
    }

}






















