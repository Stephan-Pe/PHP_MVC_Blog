<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="spacer"></div>
<?php require APPROOT . '/views/inc/backbtn.php'; ?>
<div class="regcard milki">
  <div class="regcard__title">
    <h2>Neuer Post</h2>
  </div>

  <p class="regcard__smalltext">Schreibe einen neuen Beitrag</p>
  <p class="regcard__smalltext">Fotos sollten kleiner sein als <b>500KB</b></p>
  <form action="<?php echo URLROOT; ?>/posts/add" id="myForm" method="post" enctype="multipart/form-data">
    <div class="drop__zone">
      <span class="drop__zone--prompt">

      </span>
      <label for="image"></label>
      <input type="file" name="image" id="drop-zone--input" class="drop__zone--input">

    </div>
    <p class="image-feedback"></p>
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
    <input type="submit" class="button button__send" value="Veröffentlichen">
  </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>