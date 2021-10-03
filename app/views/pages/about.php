<? require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
  <div class="body__background"></div>
  <div class="bigcard">
    <h1 class="display-3"><? echo $data['title']; ?></h1>
    <p><? echo $data['description']; ?></p>
    <p>Version: <strong><? echo APPVERSION; ?></strong></p>
  </div>

</div>
<? require APPROOT . '/views/inc/footer.php'; ?>