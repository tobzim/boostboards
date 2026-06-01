<?php snippet('header') ?>

<section class="legal-hero">
  <div class="container">
    <p class="eyebrow" data-reveal>Rechtliches</p>
    <h1 class="page-hero__title" data-reveal><?= $page->headline()->or($page->title()) ?></h1>
  </div>
</section>

<section class="prose-section">
  <div class="container prose prose--legal">
    <?= $page->text()->kt() ?>
  </div>
</section>

<?php snippet('footer') ?>
