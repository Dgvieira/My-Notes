<?php

require_once "./Templates/header.php";



if($userData) {

    header("Location: $BASE_URL/home.php");
}

?>

<div class="container-fluid">

    <h2 class="section-title">Crie e gerencie suas notas onde e quando quiser!</h2>

    <div class="apresentation-container">
        <div class="texts-container">
            <p>Bem-vindo ao My Notes, seu destino digital para criar, organizar e gerenciar suas notas de forma simples e eficaz.</p>
            <a class="link-button" href="<?= $BASE_URL ?>/login.php">Entrar</a>
        </div>
        <div class="ilustration-container">
            <img src="./Public/img/personal_notebook.png" alt="">
        </div>
    </div>
    

</div>

<?php

require_once "./Templates/footer.php";

?>