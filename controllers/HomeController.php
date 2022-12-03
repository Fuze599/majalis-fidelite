<?php
class HomeController {
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

        # Par sécurité, on unset la variable de session 'numero'
        unset($_SESSION['numero']);
        $_SESSION['isconnected'] = false;

        if (!empty($_SESSION['carteExpiree'])) {
            $notification = 'Votre carte a expiré, une nouvelle a été créée.';
            unset($_SESSION['carteExpiree']);
        }
        # Si il y a eu opération sans achèvement de la carte, on affiche le nombre de commandes passées
        # depuis le début de la carte et on unset la variable de session
        else if (!empty($_SESSION['commandePassees'])) {
            $notification = 'Le client a passé ' . $_SESSION['commandePassees'] % 12 . ' commande(s) depuis la création de sa carte.';
            unset($_SESSION['commandePassees']);
        }
        # Sinon si il y a eu opération avec achèvement de la carte, on affiche la réduction offerte
        # et on unset la variable de session
        else if (!empty($_SESSION['sumDerniereCommandes'])) {
            $reduction = round($_SESSION['sumDerniereCommandes'] * 0.05, 2);
            $notification = 'Le client à droit à une réduction de ' . $reduction . "€.";
            $this->_db->updateDernierRemise($_SESSION['idRemise'], $reduction);
            unset($_SESSION['sumDerniereCommandes']);
            unset($_SESSION['idRemise']);
        }
        # Sinon si un numéro à été rentré via le formulaire associé à cette page, on vérifie sa composition,
        # on met ce numéro dans une variable de session et si le numéro existe, on renvoie à la page d'envoi des opération.
        # Sinon, on renvoie à la page d'enregistrement des clients
        //(((\+|00)32[ ]?(?:\(0\)[ ]?)?)|0){1}(4(60|[789]\d)\/?(\s?\d{2}\.?){2}(\s?\d{2})|(\d\/?\s?\d{3}|\d{2}\/?\s?\d{2})(\.?\s?\d{2}){2})
        else if (!empty($_POST)) {
            if (!empty($_POST['number-home'])) {
                if (preg_match('/^[0-9]{8,10}$/', $_POST['number-home'])) {
                    $_SESSION['numero'] = $_POST['number-home'];
                    if (!$this->_db->existCarteFidelite($_POST['number-home'])) {
                        header('Location: index.php?action=register');
                        die();
                    } else {
                        header('Location: index.php?action=operation');
                        die();
                    }
                } else {
                    $notification = 'Veuillez entrer un numéro valide.';
                }
            }

        }
        require_once (VIEWS . 'home.php');
    }
}