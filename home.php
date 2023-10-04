<?php

require_once("./Templates/header.php");
require_once("./Dao/userDAO.php");
require_once("./Dao/noteDAO.php");

$userDAO = new UserDAO($conn, $BASE_URL);

$noteDAO = new NoteDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

$notes = $noteDAO->findAllUserNotes($userData->id);

$rowIndex = 0;

?>

<div class="container-fluid">

    <?php if (empty($notes)) : ?>

        <div class="no-data">
            <div class="text-container">
                <p>Você ainda não possui notas. Comece a criar suas notas agora mesmo!</p>
                <a class="link-button" href="<?= $BASE_URL ?>/create_note.php">Criar</a>
            </div>
            <div class="img-container"><img src="<?= $BASE_URL ?>/Public/img/no_data.png" alt=""></div>
        </div>

    <?php else : ?>

        <div class="notes-table-container">
            <a class="add-note-btn" href="<?= $BASE_URL ?>/create_note.php" title="Criar nota"><i class="fa-solid fa-file-circle-plus"></i> </a>
            <table class="notes-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="note-title-th">Título</th>
                        <th class="action-icons-th">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($notes as $note) : ?>
                        <tr>
                            <td>
                                <?php 

                                    echo $rowIndex + 1;

                                    $rowIndex++;

                                ?>
                            </td>
                            <td class="note-title"><a href="<?= $BASE_URL ?>/note_view.php?id=<?= $note->id ?>"><?= $note->title ?></a></td>
                            <td class="action-icons">
                                
                                <form action="<?= $BASE_URL ?>/note_process.php" method="POST">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name="id" value="<?= $note->id ?>">
                                    <button type="submit"><i class="fa-solid fa-trash" title="Excluir nota"></i></button> 
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    <?php endif; ?>



</div>

<?php

require_once("./Templates/footer.php");

?>