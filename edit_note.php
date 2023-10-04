<?php

require_once "./Templates/header.php";
require_once("./Dao/noteDAO.php");
require_once("./Dao/userDAO.php");
require_once("./Models/message.php");

$noteDAO = new NoteDAO($conn, $BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

$id = filter_input(INPUT_GET, "id");

$note = $noteDAO->findById($id);

?>

<!-- verifica se a nota pertence ao usuário logado -->

<?php if ($note->user_id === $userData->id) : ?>

    <!-- exbibe o bloco de código abaixo caso a nota pertença ao usuário logado -->

    <div class="container-fluid-2">

        <?php

        require_once("./Templates/back_btn.php");

        ?>

        <div class="actions">
            <form action="<?= $BASE_URL ?>/note_process.php" method="POST">
                <input type="hidden" name="type" value="delete">
                <input type="hidden" name="id" value="<?= $note->id ?>">
                <button type="submit" title="Excluir nota"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>

        <div class="edit-note-container">
            <form action="<?= $BASE_URL ?>/note_process.php" method="POST">
                <input type="hidden" name="type" value="update">
                <input type="hidden" name="id" value="<?= $note->id ?>">
                <div class="title-container">
                    <input type="text" name="title" placeholder="Título da nota" value="<?= $note->title ?>">
                </div>
                <div class="note-container">
                    <textarea name="note_text" placeholder="Conteúdo da nota"><?= $note->note_text ?></textarea>
                </div>
                <button type="submit">Salvar</button>
            </form>

        </div>


    </div>

<?php else :

    // redireciona para a home e exibe mensagem de erro

    $message->setMessage("Operação inválida!", "error", "home.php");

?>

<?php endif; ?>

<?php

require_once "./Templates/footer.php";

?>