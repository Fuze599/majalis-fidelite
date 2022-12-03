<?php
class SettingController {
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
        else if (!empty($_POST) and isset($_POST['connect-setting'])) {
            if (!empty($_POST['password-settings'])) {
                if (password_verify($_POST['password-settings'],'$2y$10$ikW2g2NFGBbSN3mCipGenOlcTejNW..XyVn3SiNGMwHX/GCfmAvAy')) {
                    $_SESSION['isconnected'] = true;
                } else {
                    $notification = 'Veuillez entrer un mot de passe valide.';
                }
            } else {
                $notification = 'Veuillez entrer un mot de passe.';
            }
        }
        else if (!empty($_POST) and isset($_POST['delete-client']) and !empty($_POST['id-client'])) {
            $this->_db->deleteCarteFidelite($_POST['id-client']);
            $notification = 'Le client n°' . $_POST['id-client'] . ' a été supprimé.';
        }

        if ($_SESSION['isconnected']) {
            $listClient = $this->_db->getClients();
            if (!empty($_POST) and isset($_POST['find-client']) and !empty($_POST['num-settings'])) {
                if ($this->_db->existCarteFidelite($_POST['num-settings'])) {
                    $client = $this->_db->getClientByNumero($_POST['num-settings']);
                    $operations = $this->_db->getOperationsWithId($client->getIdCarte());
                } else {
                    $notification = 'Ce numéro n\'existe pas';
                }
            }
        }

        require_once(VIEWS . 'settings.php');
    }
}