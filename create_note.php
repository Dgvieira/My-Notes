<?php

require_once "./Templates/header.php";

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

?>

<div class="container-fluid-2">

    <?php

    require_once("./Templates/back_btn.php");

    ?>

   

    <div class="add-note-container">
        <form action="<?= $BASE_URL ?>/note_process.php" method="POST">
            <input type="hidden" name="type" value="create">
            <div class="title-container">
                <input type="text" name="title" placeholder="Título da nota">
            </div>
            <div class="note-container">
                <textarea name="note_text" placeholder="Conteúdo da nota"></textarea>
            </div>
            <button type="submit">Criar</button>
        </form>

    </div>


</div>

<?php

require_once "./Templates/footer.php";

?>