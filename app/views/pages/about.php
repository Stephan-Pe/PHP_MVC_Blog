<? require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
  <div class="about__background"></div>
  <div class="bigcard">
    <h1 class="display-3 mb-4"><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <div class="hero__img">
      <img src="<?php echo $data['image']; ?>" alt="hosted by unsplash">
    </div>
    <div class="lorem">
      <?php echo $data['lorem']; ?>
    </div>
    <p>Version: <strong><? echo APPVERSION; ?></strong></p>
    <div class="lorem">
      <?php echo $data['lorem']; ?>
    </div>
  </div>

</div>
<? require APPROOT . '/views/inc/footer.php'; ?>