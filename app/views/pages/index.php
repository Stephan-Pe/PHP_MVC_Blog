<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">

  <div class="hero spacing">

    <div class="hero__banner">
      <h1 class="hero__banner--lead"><?php echo $data['title']; ?></h1>
      <div class="hero__banner--img"></div>
    </div>
    <div class="hero__text">
      <p class="hero__sublead"><?php echo $data['sub-title']; ?></p>
      <p class="hero__desc"><?php echo $data['description']; ?></p>
    </div>

  </div>


  <div class="gallery milky">
    <div class="imgsquare one"><span>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Placeat, ducimus.</span></div>
    <div class="imgsquare two"><span>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet, eum.</span></div>
    <div class="imgsquare three"><span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, eum!</span></div>
    <div class="imgsquare four"><span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci, soluta?</span></div>
    <div class="imgsquare five"><span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates, officia.</span></div>
    <div class="imgsquare six"><span>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos, ut.</span></div>
    <div class="imgsquare seven"><span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Incidunt, laboriosam?</span></div>
    <div class="imgsquare eight"><span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci, soluta?</span></div>
  </div>


</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>