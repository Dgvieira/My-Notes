<?php

require_once("./Templates/header.php");
require_once("./Models/user.php");
require_once("./Models/note.php");
require_once("./Models/message.php");
require_once("./Dao/noteDAO.php");

$message = new Message($BASE_URL);

$noteDAO = new NoteDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken();

// pegar o tipo do input

$type = filter_input(INPUT_POST, "type");

// criar nota

if ($type === "create") {

    $title = filter_input(INPUT_POST, "title");
    $note_text = filter_input(INPUT_POST, "note_text");

    $note = new Note();

    // verifica se o campo da nota não está vazio 

    if (!empty($note_text)) {

        // verifica se o título da nota está vazio 

        if (empty($title)) {

            // cria a nota com título de "Sem título" caso o usuário não tenha colocado nenhum título

            $note->title = "Sem título";
            $note->note_text = $note_text;
            $note->user_id = $userData->id;

            $noteDAO->create($note);

            $message->setMessage("Nota criada com sucesso!", "success", "home.php");
        } else {

            // cria a nota normalmente com os dados inseridos pelo usuário

            $note->title = $title;
            $note->note_text = $note_text;
            $note->user_id = $userData->id;

            $noteDAO->create($note);

            $message->setMessage("Nota criada com sucesso!", "success", "home.php");
        }
    } else {

        $message->setMessage("A nota não pode estar vazia!", "error", "back");
    }

    // editar nota
} else if ($type === "update") {

    $id = filter_input(INPUT_POST, "id");
    $title = filter_input(INPUT_POST, "title");
    $note_text = filter_input(INPUT_POST, "note_text");

    // resgata a nota do banco de dados a partir do id

    $note = $noteDAO->findById($id);

    // verifica se a nota pertence ao usuário que está logado

    if ($note->user_id === $userData->id) {

        // verifica se o campo da nota não está vazio

        if (!empty($note_text)) {

            // verifica se o campo do título da nota está vazio 

            if (empty($title)) {

                // atualiza a nota com título de "Sem título" caso o usuário não tenha colocado nenhum título

                $note->title = "Sem título";
                $note->note_text = $note_text;

                $noteDAO->update($note);

                $message->setMessage("Nota editada com sucesso!", "success", "home.php");

            } else {

                // atualiza a nota normalmente com os dados inseridos pelo usuário

                $note->title = $title;
                $note->note_text = $note_text;

                $noteDAO->update($note);

                $message->setMessage("Nota editada com sucesso!", "success", "home.php");
            }
        } else {

            $message->setMessage("A nota não pode estar vazia!", "error", "back");
        }
    
    } else {

        // redireciona para a home e exibe mensagem de erro

        $message->setMessage("Operação inválida!", "error", "home.php");

    }




    // deletar nota
} else if ($type === "delete") {

    // pega o id da nota

    $id = filter_input(INPUT_POST, "id");

    // pega a nota do banco de dados

    $note = $noteDAO->findById($id);

    // verifica se a nota pertence ao usuário que está logado

    if ($note->user_id === $userData->id) {

        $noteDAO->deleteNote($id);

        $message->setMessage("Nota excluída com sucesso!", "success", "home.php");

    } else {

        // redireciona para a home e exibe mensagem de erro

        $message->setMessage("Operação inválida!", "error", "home.php");
    }
}
