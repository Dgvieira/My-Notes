<?php

class Message {

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }
    
    // método que cria uma messagem na sessão
    public function setMessage($msg, $type, $redirect) {
        
        $_SESSION["msg"] = $msg;
        $_SESSION["type"] = $type;

        switch($redirect) {

            case "index.php":
                header("Location: $this->url/index.php");
                break;

            case "home.php":
                header("Location: $this->url/home.php");
                break;

            case "back":
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                break;
        }

    }

    // método que resgata a messagem da sessão
    public function getMessage() {

        if(!empty($_SESSION["msg"])) {

            return ["msg" => $_SESSION["msg"], "type" => $_SESSION["type"]];

        } else {
            return false;
        }

    }

    // método que limpa a mensagem da sessão
    public function clearMessage() {

        $_SESSION["msg"] = "";
        $_SESSION["type"] = "";

    }

}