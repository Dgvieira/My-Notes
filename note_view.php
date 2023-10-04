<?php

require_once "./Templates/header.php";
require_once("./Dao/userDAO.php");
require_once("./Dao/noteDAO.php");
require_once("./Models/message.php");

$noteDAO = new NoteDAO($conn, $BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);

$message = new Message($BASE_URL);

$userData = $userDAO->verifyToken(true);

// pega o id da nota no GET

$id = filter_input(INPUT_GET, "id");

// resgata a nota do banco de dados

$note = $noteDAO->findById($id);

?>


<!-- verifica se a nota pertence ao usuário logado -->

<?php if ($note->user_id === $userData->id) : ?>


    <div class="container-fluid-2">

        <!-- exbibe o bloco de código abaixo caso a nota pertença ao usuário logado -->

        <?php

        require_once("./Templates/back_btn.php");

        ?>

        <div class="actions">
            <a href="<?= $BASE_URL ?>/edit_note.php?id=<?= $note->id ?>" title="Editar nota"><i class="fa-solid fa-file-pen"></i></a>
            <form action="<?= $BASE_URL ?>/note_process.php" method="POST">
                <input type="hidden" name="type" value="delete">
                <input type="hidden" name="id" value="<?= $note->id ?>">
                <button type="submit" title="Excluir nota"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>

        <div class="note-box-container">
            <div class="note-title-container">
                <span><?= $note->title ?></span>
            </div>
            <div class="note-container">
                <span><?= $note->note_text ?></span>
            </div>
        </div>

    </div>



<?php else :

    // redireciona o usuário para a home e exibe mensagem de erro

    $message->setMessage("Operação inválida", "error", "home.php");

?>

<?php endif; ?>



<?php

require_once "./Templates/footer.php";

?>