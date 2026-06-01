<?php snippet('header') ?>

<section class="hero hero--video" id="top">
  <div class="hero__media">
    <video autoplay muted loop playsinline poster="<?= url('assets/img/Boost-Fishing-Pro-Limited-Edition-x-Felix-Pinedo.webp') ?>">
      <source src="<?= url('assets/video/angler-trailer.mp4') ?>" type="video/mp4" />
    </video>
    <div class="hero__gradient"></div>
  </div>
  <div class="hero__content">
    <p class="eyebrow" data-reveal><?= $page->eyebrow()->or('Für Angler') ?></p>
    <h1 class="hero__title" data-reveal><?= nl2br($page->headline()->or($page->title())->escape()) ?></h1>
    <p class="hero__sub" data-reveal><?= $page->lede() ?></p>
    <div class="hero__cta" data-reveal>
      <a href="<?= page('boards/boost-fishing-pro') ? page('boards/boost-fishing-pro')->url() : '#' ?>" class="btn btn--primary btn--lg">Fishing Pro ansehen</a>
      <a href="<?= page('kontakt') ? page('kontakt')->url() : '#' ?>" class="btn btn--outline btn--lg">Beratung anfragen</a>
    </div>
  </div>
</section>

<section class="prose-section">
  <div class="container prose">
    <?= $page->text()->kt() ?>
  </div>
</section>

<section class="prose-section" style="padding-top:0">
  <div class="container">
    <h2 class="h2" data-reveal>Auf dem Wasser mit Felix Pinedo</h2>
    <p class="lede" data-reveal>Eindrücke aus der Limited-Edition-Entwicklung.</p>
    <div class="gallery">
      <?php
        $felixFiles = [
          'Felix1-scaled-1.jpeg',
          'Felix2-scaled-1.jpeg',
          'Felix3-scaled-1.jpeg',
          'Felix4-scaled-1.png',
          'Felix5-scaled-1.jpeg',
          'Felix6-scaled-1.jpeg',
        ];
        foreach ($felixFiles as $f): ?>
        <figure data-reveal><img src="<?= url('assets/img/felix/' . $f) ?>" alt="Felix Pinedo mit BoostBoards Fishing Pro" loading="lazy" /></figure>
      <?php endforeach ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container cta-band__inner">
    <div>
      <p class="eyebrow">Limited Edition</p>
      <h2 class="h2">„Dieses Board ist eine Waffe."</h2>
      <p class="lede">Felix Pinedo Edition — signiert, limitiert, kompromisslos.</p>
    </div>
    <div class="cta-band__actions">
      <a href="<?= page('boards/boost-fishing-pro') ? page('boards/boost-fishing-pro')->url() : '#' ?>" class="btn btn--primary btn--lg">Zum Fishing Pro</a>
      <a href="mailto:<?= $site->contact_email() ?>" class="btn btn--outline btn--lg">Anfragen</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
