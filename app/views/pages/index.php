<? require APPROOT . '/views/inc/header.php'; ?>
<div class="wrapper">
  <div class="body__background"></div>
  <div class="bigcard">
    <h1 class="display-3 mb-4"><?php echo $data['title']; ?></h1>
    <p class="lead"><?php echo $data['description']; ?></p>
    <div class="lorem">
      <?php echo $data['lorem']; ?>
    </div>
    <div class="lorem">
      <?php echo $data['lorem']; ?>
    </div>
  </div>
</div>


<? require APPROOT . '/views/inc/footer.php'; ?>