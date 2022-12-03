<?php
class OperationSending {
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
        # Sinon si la variable de session contenant le numéro existe ou que la carte de fidelité n'existe pas, on renvoie vers HOME
        else if (empty($_SESSION['numero']) or !$this->_db->existCarteFidelite($_SESSION['numero'])) {
            unset($_SESSION['numero']);
            header('Location: index.php?action=home');
            die();
        }
        # Sinon si le formulaire lié à cette page a été rempli, que le montant est > à 0 et que le mot de passe est correcte,
        # on insert l'opération, on unset la variable de session contenant le numéro.
        # Si le nombre de commande est divisible par 12, on unset cette variable est on calcul la somme des 123 dernières opérations.
        # Enfin, on redirige vers HOME
        else if (!empty($_POST) and isset($_SESSION['token']) and isset($_POST['token'])) {
            if ($_POST['token'] != $_SESSION['token']) {
                $notification = 'ERREUR : Entrez de nouveau les informations.';
            }
            else if (!empty($_POST['montant-operation']) and !empty($_POST['password-operation'])) {
                if ($_POST['montant-operation'] > 0) {
                    if (password_verify($_POST['password-operation'],'$2y$10$ikW2g2NFGBbSN3mCipGenOlcTejNW..XyVn3SiNGMwHX/GCfmAvAy')) {
                        $idCard = $this->_db->getIdCarte($_SESSION['numero']);
                        unset($_SESSION['numero']);

                        $ops = $this->_db->getOperationsWithId($idCard);
                        if (!empty($ops)) {
                            $dateDifference = abs(strtotime(NOW) - strtotime(end($ops)->getDate()));
                            $dateDifference = $dateDifference / (365 * 60 * 60 * 24);
                        } else {
                            $dateDifference = 1;
                        }
                        if ($dateDifference > 5) {
                            foreach ($ops as $k => $v) {
                                $this->_db->deleteOperation($v->getIdOperation());
                                $_SESSION['carteExpiree'] = true;
                                $this->_db->insertOperation($_POST['montant-operation'], $idCard);
                            }
                        } else {
                            $this->_db->insertOperation($_POST['montant-operation'], $idCard);
                            $_SESSION['commandePassees'] = $this->_db->countOperations($idCard);

                            if ($_SESSION['commandePassees'] % 12 == 0) {
                                $_SESSION['sumDerniereCommandes'] = $this->_db->sumMontantOperations($idCard);
                                $_SESSION['idRemise'] = $idCard;
                                unset($_SESSION['commandePassees']);
                            }
                        }
                        header('Location: index.php?action=home');
                        die();
                    } else {
                        $notification = 'Veuillez entrer le bon mot de passe.';
                    }
                } else {
                    $notification = 'Veuillez entrer un montant valide.';
                }
            }
        }
        $_SESSION['token'] = md5(uniqid() . time());
        require_once (VIEWS . 'operation.php');
    }
}