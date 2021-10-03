<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<div class="post__head">
  <div class="post__head--title">
    <h1>Posts</h1>
  </div>
  <div class="post__head--button">
    <a class="button button__primary" href="<?php echo URLROOT; ?>/posts/add" class="button button-primary pull-right">
      <svg class="icon" id="pencil" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z" />
      </svg> Add Post
    </a>
  </div>
</div>
<?php foreach ($data['posts'] as $post) : ?>
  <div class="regcard">
    <h4 class="regcard__title"><?php echo $post->title; ?></h4>
    <img class="regcard__img" src="<?php echo $post->image; ?>" alt="<?php echo $post->title; ?>">
    <div class="regcard__info">
      Post von <?php echo $post->name; ?> on <?php echo $post->postCreated; ?>
    </div>
    <p class="regcard__text"><?php echo $post->body; ?></p>
    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="button button__secondary">Mehr...</a>
  </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>