<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if ($_GET['email'] && $_GET['token']) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="mb-4">Setzen Sie Ihr Passwort zurück</h2>

            <form action="<?php echo URLROOT; ?>/users/pwdreset" method="post">
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="hidden" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo $email; ?>">
                        <input type="hidden" class="form-control form-control-lg <?php echo (!empty($data['token_err'])) ? 'is-invalid' : ''; ?>" name="token" value="<?php echo $token; ?>">
                        <span class="invalid-feedback"><?php echo $data['token_err']; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Neues Passwort: <sup>*</sup></label>
                    <input type="password" name="password" class="password form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" autocomplete="off">
                    <span><?php require APPROOT . '/views/inc/eye.php';; ?></span>
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Passwort Bestätigung: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>" autocomplete="off">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Passwort ändern" class="btn btn-primary btn-block">
                    </div>


                </div>

        </div>
        </form>

    </div>

</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>