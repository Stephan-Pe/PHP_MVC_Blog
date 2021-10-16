<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if ($_GET['email'] && $_GET['token']) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} ?>
<div class="regcard frosted">
    <h2 class="form-head">Bestätigen Sie Ihre Email Adresse</h2>
    <div class="spacer"></div>
    <form action="<?php echo URLROOT; ?>/users/verify" method="post">
        <div class="form-group">
            <div class="col-md-6">
                <input type="hidden" class="form-control form-control-lg" name="status" value="active">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <input type="hidden" class="form-control form-control-lg <?php echo (!empty($data['token_err'])) ? 'is-invalid' : ''; ?>" name="token" value="<?php echo $token; ?>">
                <span class="invalid-feedback"><?php echo $data['token_err']; ?></span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <input type="hidden" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
        </div>
        <div class="form-row">

            <input type="submit" value="Email Bestätigen" class="button button__send">


            <a href="<?php echo URLROOT; ?>/users/login" class="button button__success">Anmelden</a>


        </div>


    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>