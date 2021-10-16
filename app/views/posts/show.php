<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="regcard milki">
    <?php require APPROOT . '/views/inc/backbtn.php'; ?>
    <br>
    <h4 class="regcard__title"><?php echo $data['post']->title; ?></h4>
    <img class="img-fluid" src="<?php echo URLROOT; ?>/<?php echo $data['post']->image; ?>" alt="<?php echo $data['post']->title; ?>">
    <div class="regcard__info">
        Post von <?php echo $data['user']->name; ?> vom <?php echo $data['post']->created_at; ?>
    </div>
    <p class="regcard__text"><?php echo $data['post']->body; ?></p>
    <p class="regcard__text">Dies ist ein Typoblindtext. An ihm kann man sehen, ob alle Buchstaben da sind und wie sie aussehen. Manchmal benutzt man Worte wie Hamburgefonts, Rafgenduks oder Handgloves, um Schriften zu testen.</p>

    <?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>
        <hr>
        <div class="row justify-content-between px-4">
            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="button button__primary ">Editieren</a>

            <form class="form-inline pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
                <input type="submit" value="Löschen" class="button button__success">
            </form>
        </div>

    <?php endif; ?>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>