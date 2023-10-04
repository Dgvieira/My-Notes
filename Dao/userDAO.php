<?php

require_once("./Models/message.php");
require_once("./Models/user.php");

class UserDAO {

    private $conn, $url, $message;

    public function __construct($conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    // método que cria um objeto da classe User com os dados recebidos por parâmetro
    public function buildUser($data) {

        $user = new User();

        $user->id = $data["id"];
        $user->user_name = $data["user_name"];
        $user->password = $data["password"];
        $user->token = $data["token"];

        return $user;

    }

    // método que insere o usuário no banco de dados
    public function create(User $user) {

        $sql = "INSERT INTO users (user_name, password, token) VALUES (:user_name, :password, :token)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_name", $user->user_name);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

    }

    // método que atualiza os dados do usuário no banco de dados
    public function update(User $user) {

        $sql = "UPDATE users SET token = :token WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

    }

    // método que seleciona o usuário pelo nome de usuário
    public function findByUserName($user_name) {

        $sql = "SELECT * FROM users WHERE user_name = :user_name";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":user_name", $user_name);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            }

    }

    // método que seleciona o usuário pelo token
    public function findByToken($token) {

        $sql = "SELECT * FROM users WHERE token = :token";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            }
    }

    // método que coloca o token do usuário na sessão
    public function setTokenToSession($token) {

        $_SESSION["token"] = $token;

    }

    // método que remove o token do usuário da sessão
    public function destroyToken() {

        $_SESSION["token"] = "";

        $this->message->setMessage("Sessão finalizada!", "success", "index.php");
    
    }

    // método que verifica se o token do usuário existe no banco de dados
    public function verifyToken($protected = false) {

        if(!empty($_SESSION["token"])) {

            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if($user) {
                
                return $user;

            } else if($protected) {

                // redireciona o usuário caso não esteja logado

                $this->message->setMessage("Faça login para acessar esta página", "error", "index.php");

            }

        } else if($protected) {

            // redireciona o usuário caso não esteja logado

            $this->message->setMessage("Faça login para acessar esta página", "error", "index.php");

        }

    }

    // método que faz a autenticação do usuário no momento do login
    public function authenticateUser($user_name, $password) {

        // verifica se o usuário existe no banco de dados

        $user = $this->findByUserName($user_name);

        if($user) {

            // verifica se a senha do usuário está correta 

            if(password_verify($password, $user->password)) {

                // cria um novo token pro usuário

                $newToken = $user->generateToken();

                $this->setTokenToSession($newToken);

                // atualiza o token do usuário

                $user->token = $newToken;

                $this->update($user);

                return $user;

            } else {

                return false;
            }

        } else {
            
            return false;
        }

    }

}