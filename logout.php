<?php

require_once "./Config/globals.php";
require_once("./Config/db.php");
require_once("./Dao/userDAO.php");

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken();

if($userData) {

    $userDAO->destroyToken();
}