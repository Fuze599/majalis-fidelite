<?php
class Db {
    private static $instance = null;
    private $_db;

    private function __construct() {
        try {
            $this->_db = new PDO('mysql:host=localhost:3307;dbname=fidelite_majalis', 'root', '');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
            die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

    # Pattern Singleton
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

/*
    ▒█▀▀█ █▀▀█ █▀▀█ █▀▀▄ █▀▀
    ▒█░░░ █▄▄█ █▄▄▀ █░░█ ▀▀█
    ▒█▄▄█ ▀░░▀ ▀░▀▀ ▀▀▀░ ▀▀▀
*/
    public function insertCarte($numero, $nom, $prenom) {
        $query = 'INSERT INTO cartes_fidelite (nom, prenom, num_telephone) values (:nom, :prenom, :numero)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':nom', $nom);
        $ps->bindValue(':prenom', $prenom);
        $ps->bindValue(':numero', $numero);
        $ps->execute();
    }
    public function updateDernierRemise($id, $montant) {
        $query = 'UPDATE cartes_fidelite SET derniere_remise = :montant WHERE id_carte = :id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':montant', $montant);
        $ps->bindValue(':id', $id);
        $ps->execute();
    }
    public function getIdCarte($numero) {
        $query = 'SELECT id_carte FROM cartes_fidelite WHERE num_telephone = :numero';
        $result = $this->_db->prepare($query);
        $result->bindValue(':numero', $numero);
        $result->execute();
        return $result->fetch()->id_carte;
    }
    public function existCarteFidelite($numero) {
        $query = 'SELECT id_carte FROM cartes_fidelite WHERE num_telephone = :numero';
        $result = $this->_db->prepare($query);
        $result->bindValue(':numero', $numero);
        $result->execute();
        return $result->rowcount() == 1;
    }

    public function getClients() {
        $query = 'SELECT nom, prenom, num_telephone, derniere_remise FROM cartes_fidelite ORDER BY nom';
        $result = $this->_db->prepare($query);
        $result->execute();
        $listCarteDeFidelite = array();
        while($row = $result->fetch()) {
            $listCarteDeFidelite[] = new CarteDeFidelite(NULL, $row->nom, $row->prenom, $row->num_telephone, $row->derniere_remise);
        }
        return $listCarteDeFidelite;
    }

    public function getClientByNumero($numero) {
        $query = 'SELECT id_carte, nom, prenom, num_telephone, derniere_remise FROM cartes_fidelite WHERE num_telephone = :num_telephone';
        $result = $this->_db->prepare($query);
        $result->bindValue(':num_telephone', $numero);
        $result->execute();
        $row = $result->fetch();
        return new CarteDeFidelite($row->id_carte, $row->nom, $row->prenom, $row->num_telephone, $row->derniere_remise);
    }

    public function deleteCarteFidelite($id) {
        $query = 'DELETE FROM cartes_fidelite WHERE id_carte = :id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id', $id);
        $ps->execute();
    }

/*
    ▒█▀▀▀█ █▀▀█ █▀▀ █▀▀█ █▀▀█ ▀▀█▀▀ ░▀░ █▀▀█ █▀▀▄ █▀▀
    ▒█░░▒█ █░░█ █▀▀ █▄▄▀ █▄▄█ ░░█░░ ▀█▀ █░░█ █░░█ ▀▀█
    ▒█▄▄▄█ █▀▀▀ ▀▀▀ ▀░▀▀ ▀░░▀ ░░▀░░ ▀▀▀ ▀▀▀▀ ▀░░▀ ▀▀▀
*/

    public function insertOperation($montant, $idCarte) {
        $query = 'INSERT INTO operations (date, montant, id_carte) values (:date, :montant, :id_carte)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':montant', $montant);
        $ps->bindValue(':date', NOW);
        $ps->bindValue(':id_carte', $idCarte);
        $ps->execute();
    }
    public function countOperations($idCard) {
        $query = 'SELECT COUNT(id_operation) as "count" FROM operations WHERE id_carte = :id_carte';
        $result = $this->_db->prepare($query);
        $result->bindValue(':id_carte', $idCard);
        $result->execute();
        return $result->fetch()->count;
    }
    public function sumMontantOperations($idCard) {
        $query = 'SELECT SUM(montant) as "sum" FROM operations WHERE id_carte = :id_carte LIMIT 12';
        $result = $this->_db->prepare($query);
        $result->bindValue(':id_carte', $idCard);
        $result->execute();
        return $result->fetch()->sum;
    }

    public function getOperationsWithId($id) {
        $query = 'SELECT id_operation, date, montant, id_carte FROM operations WHERE id_carte = :id_carte ORDER BY date DESC LIMIT :limit';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id_carte', $id);
        $limit = $this::getInstance()->countOperations($id) % 12;
        $ps->bindValue(':limit', $limit,PDO::PARAM_INT);
        $ps->execute();
        $listOperations = array();
        while($row = $ps->fetch()) {
            $listOperations[] = new Operations($row->id_operation, $row->date, $row->montant, $row->id_carte);
        }
        return $listOperations;
    }

    public function deleteOperation($id) {
        $query = 'DELETE FROM operations WHERE id_operation = :id';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':id', $id);
        $ps->execute();
    }
}