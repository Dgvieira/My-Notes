<?php

class User {

    public $id, $user_name, $password, $token;

    // método que gera um token
    public function generateToken() {
        return bin2hex(random_bytes(50));
    }

    // método que gera um hash da senha
    public function generatePassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
        
    
}