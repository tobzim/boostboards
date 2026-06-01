<?php snippet('header') ?>

<?php
  $heroImg   = $page->hero_image()->toFile();
  $heroVideo = $page->hero_video()->toFile();
?>

<section class="page-hero<?= ($heroImg || $heroVideo) ? ' page-hero--media' : '' ?>">
  <?php if ($heroVideo): ?>
    <div class="page-hero__media">
      <video autoplay muted loop playsinline><source src="<?= $heroVideo->url() ?>" type="video/mp4" /></video>
      <div class="hero__gradient"></div>
    </div>
  <?php elseif ($heroImg): ?>
    <div class="page-hero__media">
      <img src="<?= $heroImg->url() ?>" alt="<?= $heroImg->alt() ?>" />
      <div class="hero__gradient"></div>
    </div>
  <?php endif ?>

  <div class="container page-hero__copy">
    <?php if ($page->eyebrow()->isNotEmpty()): ?>
      <p class="eyebrow" data-reveal><?= $page->eyebrow() ?></p>
    <?php endif ?>
    <h1 class="page-hero__title" data-reveal><?= nl2br($page->headline()->or($page->title())->escape()) ?></h1>
    <?php if ($page->lede()->isNotEmpty()): ?>
      <p class="page-hero__lede" data-reveal><?= $page->lede() ?></p>
    <?php endif ?>
  </div>
</section>

<section class="prose-section">
  <div class="container prose">
    <?= $page->text()->kt() ?>
  </div>
</section>

<?php snippet('footer') ?>
