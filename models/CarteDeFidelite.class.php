<?php
class CarteDeFidelite {
    private $_idCarte;
    private $_nom;
    private $_prenom;
    private $_numTelephone;
    private $_derniereRemise;

    public function __construct($idCarte, $nom, $prenom, $numTelephone, $derniereRemise) {
        $this->_idCarte = $idCarte;
        $this->_nom = $nom;
        $this->_prenom = $prenom;
        $this->_numTelephone = $numTelephone;
        $this->_derniereRemise = $derniereRemise;
    }

    public function getIdCarte() {
        return $this->_idCarte;
    }

    public function getNom() {
        return htmlspecialchars($this->_nom);
    }

    public function getPrenom() {
        return htmlspecialchars($this->_prenom);
    }

    public function getNumTelephone() {
        return htmlspecialchars($this->_numTelephone);
    }

    public function getDerniereRemise() {
        return $this->_derniereRemise;
    }
}