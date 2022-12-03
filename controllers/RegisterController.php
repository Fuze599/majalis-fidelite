<?php
class RegisterController {
    private $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function run() {
        # Si la session est vide, on redirige vers CONNECT
        if (empty($_SESSION)) {
            header('Location: index.php?action=connect');
            die();
        }
        # Sinon si le numero de session n'est pas fourni, on redirige vers HOME
        else if (empty($_SESSION['numero'])) {
            header('Location: index.php?action=home');
            die();
        }
        # Sinon si une carte liée au numéro fournis existe, on redirige vers l'envoi operation
        else if ($this->_db->existCarteFidelite($_SESSION['numero'])) {
            header('Location: index.php?action=operation');
            die();
        }
        # Sinon si un le formulaire lié à cette page est rempli, on insert la nouvelle carte et on redirige vers l'envoi d'operations
        else if (!empty($_POST)) {
            if (!empty($_POST['prenom-register']) and !empty($_POST['nom-register'])) {
                $this->_db->insertCarte($_SESSION['numero'], $_POST['nom-register'], $_POST['prenom-register']);
                header('Location: index.php?action=operation');
                die();
            } else {
                $notification = 'Tous les champs sont obligatoires.';
            }
        }
        require_once (VIEWS . 'register.php');
    }
}