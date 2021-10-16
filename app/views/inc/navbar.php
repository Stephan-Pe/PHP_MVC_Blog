  <nav class="topnav" aria-label="top navigation">
    <div class="topnav__brand">
      <a class="brandname" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>

    </div>
    <div class="topnav__menu">
      <ul class="topnav__nav">
        <li class="topnav__item">
          <a class="topnav__link" aria-current="page" href="<?php echo URLROOT; ?>">Home</a>
        </li>
        <li class="topnav__item">
          <a class="topnav__link" href="<?php echo URLROOT; ?>/pages/about">Über uns</a>
        </li>
      </ul>
      <ul class="topnav__user">
        <?php if (isset($_SESSION['user_id'])) : ?>
          <!-- <li class="topnav__item">
            <a class="topnav__link" aria-current="page" href="#">Welcome <?php echo $_SESSION['user_name']; ?></a>
          </li> -->
          <li class="topnav__item">
            <a class="topnav__link" aria-current="page" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
          </li>

        <?php else : ?>
          <li class="topnav__item">
            <a class="topnav__link" aria-current="page" href="<?php echo URLROOT; ?>/users/register">Registrieren</a>
          </li>
          <li class="topnav__item">
            <a class="topnav__link" href="<?php echo URLROOT; ?>/users/login">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>

    <span class="topnav__toggle" aria-label="Toggle navigation">
      <span class="topnav__toggle--icon1"></span>
      <span class="topnav__toggle--icon2"></span>
      <span class="topnav__toggle--icon3"></span>
    </span>

  </nav>
  <main class="main cf">
    <div class="user__info">
      <?php if (isset($_SESSION['user_id'])) : ?>

        <span>
          <?php require_once(APPROOT . '/helpers/datetime.php');
          createDay(); ?></span>
        <span>
          Willkommen <?php echo $_SESSION['user_name']; ?>
        </span>
      <?php else : ?>
        <span>

          <?php require_once(APPROOT . '/helpers/datetime.php');
          createDay(); ?>
        </span>

      <?php endif; ?>
    </div>