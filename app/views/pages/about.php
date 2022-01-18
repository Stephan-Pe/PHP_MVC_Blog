<? require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
  <div class="hero spacing">

    <h1 class="about__lead"><?php echo $data['title']; ?></h1>
    <p class="about__text"><?php echo $data['info']; ?></p>
    <p class="about__text"><?php echo $data['description']; ?></p>
    <div class="hero__img">
      <img src="<?php echo $data['image']; ?>" alt="hosted by unsplash">
    </div>

    <p class="version-info">Version: <strong><? echo APPVERSION; ?></strong></p>

  </div>
  <div class="spacer"></div>
  <div class="spacer"></div>
  <div class="spacer"></div>

</div>
<? require APPROOT . '/views/inc/footer.php'; ?>