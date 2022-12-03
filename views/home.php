
<div class="form-center" id="xd">
    <?php if (!empty($notification)) { ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                <?php echo $notification ?>
            </div>
        </div>
    <?php } ?>
     <form method="post" action="index.php?action=home">
         <div class="form-floating mb-3">
             <input type="tel" class="form-control" id="num-input-id" name="number-home">
             <label for="num-input-id">Numéro de téléphone</label>

             <input type="submit" class="btn btn-primary p-4 m-3" value="Confirmer">
         </div>
     </form>
    <a href="index.php?action=settings"><input type="image" id="setting-image" style="width: 50px; height: 50px; margin-top: 70px;" src="views/Images/gear-wide-connected.svg" /></a>
</div>