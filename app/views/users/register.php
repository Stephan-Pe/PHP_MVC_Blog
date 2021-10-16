<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="regcard frosted">
    <h2 class="form-head">Registrieren</h2>
    <p class="form-subhead">Es geht einfach und schnell.</p>
    <form action="<?php echo URLROOT; ?>/users/register" method="post">
        <div class="form-group">
            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" autocomplete="on">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
        </div>
        <div class="form-group">
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
        <div class="form-group">
            <label for="confirm_password">Passwort Bestätigung: <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>" autocomplete="off">
            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
        </div>

        <div class="form-row">

            <input type="submit" value="Registrieren" class="button button__send">


            <a href="<?php echo URLROOT; ?>/users/login" class="button button__success">Anmelden</a>

        </div>

    </form>

</div>