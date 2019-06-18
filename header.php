<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <?php get_template_part("canonical_url"); ?>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php get_template_part("favicon"); ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no, email=no, address=no">
  <?php
    wp_head();
    if (is_singular()) wp_enqueue_script("comment-reply");
  ?>
</head>
<body <?php body_class(); ?>>
  <div class="container">
    <header>
        <h1><?php bloginfo('name'); ?></h1>
    </header>
    <?php if (is_front_page() ): ?>

    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
          $headers = get_uploaded_header_images();
          foreach ($headers as $header => $value): ?>
        <div class="swiper-slide" style="
          background-image: url('<?php echo $value['url'] ?>');
          background-repeat: no-repeat;
          width: 100%;
          height: 60vh;
          background-size: cover;
          background-position: center center;"></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-scrollbar"></div>
    </div>

    <?php endif; ?>
    <nav class="top-nav navbar navbar-expand-md navbar-light">
      <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <?php wp_nav_menu( array( 'container_id' => 'navbarNav', 'container_class' => 'collapse navbar-collapse', 'menu_class' => 'navbar-nav m-auto' ) ); ?>
    </nav>

    <div class="row">
      <main class="col-md-8">