<?php

require_once("./Models/note.php");
require_once("./Models/message.php");


class NoteDAO {

    private $conn, $url, $message;

    public function __construct($conn, $url) {
        
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    // método que cria um objeto da classe Note com os dados recebidos por parâmetro

    public function buildNote($data) {

        $note = new Note();

        $note->id = $data["id"];
        $note->title = $data["title"];
        $note->note_text = $data["note_text"];
        $note->user_id = $data["user_id"];

        return $note;

    }

    // método que insere a nota no banco de dados
    public function create(Note $note) {

        $sql = "INSERT INTO notes (title, note_text, user_id) VALUES (:title, :note_text, :user_id)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":title", $note->title);
        $stmt->bindParam(":note_text", $note->note_text);
        $stmt->bindParam(":user_id", $note->user_id);

        $stmt->execute();

    }

    // método que seleciona todas as notas do usuário
    public function findAllUserNotes($user_id){

        $notes = [];

        $sql = "SELECT * FROM notes WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            $arrayData = $stmt->fetchAll();

            foreach($arrayData as $note) {

                $notes[] = $this->buildNote($note);
            }

        }

        return $notes;

    }

    // método que seleciona uma nota pelo id
    public function findById($id) {

        $sql = "SELECT * FROM notes WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            $data = $stmt->fetch();

            $note = $this->buildNote($data);
        } 

        return $note;

    }

    // método que atualiza a nota no banco de dados
    public function update(Note $note) {

        $sql = "UPDATE notes SET title = :title, note_text = :note_text WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":title", $note->title);
        $stmt->bindParam(":note_text", $note->note_text);
        $stmt->bindParam(":id", $note->id);

        $stmt->execute();
    }

    // método que exclui a nota do banco de dados
    public function deleteNote($id) {

        $sql = "DELETE FROM notes WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

}