<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="regcard frosted">

    <?php flash('register_success'); ?>
    <h2 class="form-head">Anmelden</h2>
    <div class="spacer"></div>
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
        <div class="form-row">

            <input type="submit" value="Anmelden" class="button button__send">


            <a href="<?php echo URLROOT; ?>/users/register" class="button button__success">Registrieren</a>

        </div>
        <div class="form-row">
            <a class="button button__secondary" href="<?php echo URLROOT; ?>/users/pwdrequest">Passwort vergessen?</a>
        </div>
    </form>
</div>