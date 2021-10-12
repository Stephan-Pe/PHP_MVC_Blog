<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if ($_GET['email'] && $_GET['token']) {
    $email = $_GET['email'];
    $token = $_GET['token'];
} ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="mb-4">Bestätigen Sie Ihre Email Adresse</h2>

            <form action="<?php echo URLROOT; ?>/users/verify" method="post">
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="hidden" class="form-control form-control-lg" name="status" value="active">
                    </div>
                </div>
                <div class="form-group row">
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
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Email Bestätigen" class="btn btn-primary btn-block">
                    </div>


                </div>

        </div>
        </form>

    </div>

</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>