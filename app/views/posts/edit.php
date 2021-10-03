<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/backbtn.php'; ?>

<div class="card card-body bg-light mt-5">
    <h2>Post editieren</h2>
    <p>Hier kannst Du Deinen Post korrigieren</p>

    <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" id="myForm" method="post">
        <div class="form-group">
            <label for="title">Titel: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="body">Post: <sup>*</sup></label>
            <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>
        <input type="submit" class="btn btn-success" value="Senden">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>