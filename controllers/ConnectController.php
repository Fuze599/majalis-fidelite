<?php
class ConnectController {

    public function __construct() {

    }

    public function run() {
        # Si la session est remplie, on redirige vers HOME
        if (!empty($_SESSION)) {
            header('Location: index.php?action=home');
            die();
        }

        # Sinon, si l'adresse mail et le mot de passe sont correcte, on démarre une session
        else if (!empty($_POST)) {
            if (!empty($_POST['email-connect']) and !empty($_POST['password-connect'])) {
                if ($_POST['email-connect'] == 'babacarsprl@gmail.com') {
                    if (password_verify($_POST['password-connect'],'$2y$10$ikW2g2NFGBbSN3mCipGenOlcTejNW..XyVn3SiNGMwHX/GCfmAvAy')) {
                        $_SESSION['isconnected'] = false;
                        header('Location: index.php?action=home');
                        die();
                    } else {
                        $notification = 'Veuillez entrer une adresse mail et un mot de passe valide.';
                    }
                } else {
                    $notification = 'Veuillez entrer une adresse mail et un mot de passe valide.';
                }
            } else {
                $notification = 'Veuillez entrer une adresse mail et un mot de passe.';
            }
        }
        require_once (VIEWS . 'connect.php');
    }
}