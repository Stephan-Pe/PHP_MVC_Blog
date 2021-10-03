<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/backbtn.php'; ?>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<img class="img-fluid" src="<?php echo URLROOT; ?>/<?php echo $data['post']->image; ?>" alt="<?php echo $data['post']->title; ?>">
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?> on
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>
    <hr>
    <div class="row justify-content-between">
        <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Editieren</a>

        <form class="form-inline pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
            <input type="submit" value="Löschen" class="btn btn-danger">
        </form>
    </div>

<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>