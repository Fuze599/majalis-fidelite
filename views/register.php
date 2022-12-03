<div class="form-center">
    <?php if (!empty($notification)) { ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                <?php echo $notification ?>
            </div>
        </div>
    <?php } ?>
    <form method="post" action="index.php?action=register">
        <div class="form-floating mb-3">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="prenom-input-id" name="prenom-register">
                <label for="prenom-input-id">Prénom</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="nom-input-id" name="nom-register">
                <label for="nom-input-id">Nom</label>
            </div>
            <input type="submit" class="btn btn-primary p-4 m-3" value="Confirmer">
        </div>
    </form>
    <p><a href="index.php?action=home">Retour</a></p>
</div>