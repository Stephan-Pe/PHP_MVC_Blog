<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="regcard frosted">

    <?php flash('register_success'); ?>
    <div class="card card-body bg-light mt-5">
        <h2 class="form-head">Geben Sie bitte Ihre Emailadresse ein.</h2>
        <div class="spacer"></div>

        <form action="<?php echo URLROOT; ?>/users/pwdrequest" method="post">
            <div class="form-group">
                <input type="hidden" class="form-control form-control-lg <?php echo (!empty($data['token_err'])) ? 'is-invalid' : ''; ?>" name="token" value="<?php echo $token; ?>">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" autocomplete="on">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-row">

                <input type="submit" value="Email Bestätigen" class="button button__send">

            </div>

    </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>