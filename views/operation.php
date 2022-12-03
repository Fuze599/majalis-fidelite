<div class="form-center">
    <?php if (!empty($notification)) { ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                <?php echo $notification ?>
            </div>
        </div>
    <?php } ?>
    <form method="post" action="index.php?action=operation">
        <div class="form-floating mb-3">
            <div class="form-floating mb-3">
                <input type="number" step=".01" class="form-control" id="montant-input-id" name="montant-operation">
                <label for="montant-input-id">Montant</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password-input-id" name="password-operation">
                <label for="password-input-id">Mot de passe</label>
            </div>

            <input type="submit" class="btn btn-primary p-4 m-3" value="Ajouter le montant">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
        </div>
    </form>
    <p><a href="index.php?action=home">Retour</a></p>
</div>