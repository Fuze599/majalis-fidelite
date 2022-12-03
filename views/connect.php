<div class="form-center">
    <?php if (!empty($notification)) { ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                <?php echo $notification ?>
            </div>
        </div>
    <?php } ?>
    <form method="post" action="index.php?action=connect">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email-connect-id" name="email-connect">
            <label for="email-connect-id">Adresse email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password-connect" id="password-connect-id">
            <label for="password-connect-id">Mot de passe</label>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>