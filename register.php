<?php


require_once("./Templates/header.php");


?>

<div class="container-fluid main-container">

    <div class="auth-container">
        <div class="login-container">
            <h3>Cadastrar</h3>
            <form action="<?= $BASE_URL ?>/auth_process.php" method="POST">
                <input type="hidden" name="type" value="register">
                <div class="form-group">
                    <div class="input-container">
                        <div class="input-icon-container"><i class="fa-solid fa-user"></i></div>
                        <input type="text" name="user_name" id="user_name" placeholder="Nome de usuário" autocomplete="off">
                    </div>

                </div>
                <div class="form-group">
                    <div class="input-container">
                        <div class="input-icon-container"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" name="password" id="password" placeholder="Senha">
                        <div class="input-icon-container"><i class="fa-solid fa-eye-slash" id="eye-icon"></i></div>
                    </div>
                </div>

                <input type="submit" class="form-btn" value="Cadastrar">
            </form>
            <p>Já possui uma conta? <a href="<?= $BASE_URL ?>/login.php">Entrar.</a></p>
        </div>
        <div class="sign-in-ilustration">
            <img src="<?= $BASE_URL ?>/Public/img/sign_in.png" alt="">
        </div>
    </div>

</div>

<?php

require_once("./Templates/footer.php");

?>