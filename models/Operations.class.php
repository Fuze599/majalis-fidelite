<?php

class Operations {
    private $_idOperation;
    private $_date;
    private $_montant;
    private $_idCarte;

    public function __construct($idOperation, $date, $montant, $idCarte){
        $this->_idOperation = $idOperation;
        $this->_date = $date;
        $this->_montant = $montant;
        $this->_idCarte = $idCarte;
    }

    public function getIdOperation() {
        return $this->_idOperation;
    }

    public function getDate() {
        return $this->_date;
    }

    public function getMontant() {
        return htmlspecialchars($this->_montant);
    }

    public function getIdCarte() {
        return $this->_idCarte;
    }
}