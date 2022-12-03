
<h3 class="title-connect m-5">Settings</h3>

<div class="form-center">
<a class="btn btn-secondary mb-4" role="button" href="index.php?action=home">Retour</a>
<a class="btn btn-secondary mb-4" role="button" href="index.php?action=disconnect">Se déconnecter</a>

<?php if (!empty($notification)) { ?>
    <div class="alert alert-primary d-flex align-items-center mt-5" role="alert" id="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
        <div>
            <?php echo $notification ?>
        </div>
    </div>
<?php } ?>

<?php if (!$_SESSION['isconnected']) { ?>
    <form method="post" action="index.php?action=settings">
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password-settings" id="password-settings-id">
            <label for="password-settings-id">Mot de passe</label>
        </div>
        <button name="connect-setting" type="submit" class="btn btn-primary">Se connecter</button>
    </form>
<?php } else { ?>
    <h5 class="title-connect">Rechercher un client</h5>
    <form method="post" action="index.php?action=settings">
        <div class="form-floating mb-2 mt-2">
            <input type="text" class="form-control" id="num-settings-id" name="num-settings">
            <label for="num-settings-id">Numéro de téléphone</label>
        </div>
        <button type="submit" class="btn btn-primary" name="find-client">Chercher</button>
    </form>
    <?php if (!empty($client)) { ?>
        <h5 class="title-connect mt-5">Client n°<?php echo $client->getIdCarte() ?></h5>
        <ul class="list-group">
            <li class="list-group-item">Nom : <?php echo $client->getNom() ?></li>
            <li class="list-group-item">Prénom : <?php echo $client->getPrenom() ?></li>
            <?php if (!is_null($client->getDerniereRemise())) { ?><li class="list-group-item">Dernière remise : <?php echo $client->getDerniereRemise() ?>€</li><?php } ?>
            <?php if ($this->_db->countOperations($client->getIdCarte()) == 0) { ?>
                <form method="post" action="index.php?action=settings">
                    <input type="hidden" name="id-client" value="<?php echo $client->getIdCarte() ?>">
                    <li class="list-group-item"><button type="submit" class="btn btn-danger" name="delete-client">Supprimer le client</button></li>
                </form>
            <?php } ?>
        </ul>
        <?php if (!empty($operations)) { ?>
            <h5 class="title-connect mt-5">Opérations du client n°<?php echo $client->getIdCarte() ?></h5>
            <table class="table  table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Montant</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($operations as $k => $v) {?>
                    <tr>
                        <th scope="row"><?php echo $k + 1 ?></th>
                        <td><?php echo $v->getDate() ?></td>
                        <td><?php echo $v->getMontant() ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    <?php } ?>

    <h5 class="title-connect mt-5">Liste des clients</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Numéro de téléphone</th>
            <th scope="col">Dernière remise</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listClient as $k => $v) { ?>
            <tr>
                <th scope="row"><?php echo $k + 1 ?></th>
                <td><?php echo $v->getNom() ?></td>
                <td><?php echo $v->getPrenom() ?></td>
                <td><?php echo $v->getNumTelephone() ?></td>
                <td><?php echo $v->getDerniereRemise() ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>
</div>