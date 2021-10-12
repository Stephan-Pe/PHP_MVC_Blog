<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php flash('register_success'); ?>
            <h2 class="mb-4">Anmelden</h2>

            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <div class="form-group">
                    <input type="hidden" name="remote" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" autocomplete="on">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Passwort: <sup>*</sup></label>
                    <input type="password" name="password" class="password form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" autocomplete="off">
                    <span><?php require APPROOT . '/views/inc/eye.php';; ?></span>
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <input type="submit" value="Anmelden" class="btn btn-primary btn-block">
                    </div>
                    <div class="col mb-2">
                        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-success btn-block">Neues Konto Erstellen</a>
                    </div>
                </div>
                <div class="row">
                    <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/pwdrequest">Passwort vergessen?</a>
                </div>
            </form>
        </div>
    </div>
</div>