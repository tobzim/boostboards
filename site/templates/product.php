<?php snippet('header') ?>

<?php
  // Main product image: prefer file named like the slug, otherwise first
  $allImages = $page->images();
  $img       = product_main_image($page);
?>

<section class="product-hero">
  <div class="container product-hero__grid">
    <div class="product-hero__media" data-reveal>
      <?php if ($img): ?>
        <img src="<?= $img->url() ?>" alt="<?= $img->alt()->or($page->title()) ?>" />
      <?php endif ?>
    </div>
    <div class="product-hero__copy">
      <p class="eyebrow" data-reveal><?= $page->badge()->or('Boost Board') ?></p>
      <h1 class="page-hero__title" data-reveal><?= $page->title() ?></h1>
      <p class="page-hero__lede" data-reveal><?= $page->short() ?></p>
      <div class="product-hero__meta" data-reveal>
        <div>
          <span class="local__label">Antrieb</span>
          <span><?= ucfirst($page->motor()->or('Paddle')) ?></span>
        </div>
        <?php if ($page->power()->isNotEmpty()): ?>
        <div>
          <span class="local__label">Leistung</span>
          <span><?= $page->power() ?></span>
        </div>
        <?php endif ?>
        <div>
          <span class="local__label">Preis</span>
          <span class="product-hero__price"><?= $page->price() ?></span>
        </div>
      </div>
      <?php $buyUrl = $page->stripe_payment_link()->value(); ?>
      <div class="product-hero__cta" data-reveal>
        <?php if ($buyUrl): ?>
          <a href="<?= esc($buyUrl) ?>" class="btn btn--primary btn--lg btn--buy" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 1v22M19 5H8.5a3.5 3.5 0 0 0 0 7H15a3.5 3.5 0 1 1 0 7H5"/>
            </svg>
            Jetzt kaufen
          </a>
          <a href="<?= page('konfigurieren') ? page('konfigurieren')->url() : '#' ?>" class="btn btn--outline btn--lg">Konfigurieren</a>
        <?php else: ?>
          <a href="<?= page('kontakt') ? page('kontakt')->url() : '#' ?>" class="btn btn--primary btn--lg">Anfragen</a>
          <a href="<?= page('konfigurieren') ? page('konfigurieren')->url() : '#' ?>" class="btn btn--outline btn--lg">Konfigurieren</a>
        <?php endif ?>
      </div>

      <?php if ($buyUrl): ?>
        <p class="product-hero__legal" data-reveal>
          <?= $page->price_note()->or('Inkl. 19 % MwSt., zzgl. Versand. Lieferzeit ca. 4–10 Wochen.') ?>
        </p>
        <div class="product-hero__trust" data-reveal>
          <span>Sichere Zahlung via Stripe</span>
          <span class="product-hero__pay">
            <img src="<?= url('assets/img/pay/visa.png') ?>" alt="Visa" />
            <img src="<?= url('assets/img/pay/mastercard.png') ?>" alt="Mastercard" />
            <img src="<?= url('assets/img/pay/paypal.png') ?>" alt="PayPal" />
            <img src="<?= url('assets/img/pay/invoice.png') ?>" alt="SEPA / Rechnung" />
          </span>
        </div>
      <?php endif ?>
    </div>
  </div>
</section>

<?php if ($page->description()->isNotEmpty()): ?>
<section class="prose-section">
  <div class="container prose">
    <?= $page->description()->kt() ?>
  </div>
</section>
<?php endif ?>

<?php $specs = $page->specs()->toStructure(); if ($specs->count()): ?>
<section class="prose-section" style="padding-top:0">
  <div class="container">
    <h2 class="h2" data-reveal>Technische Daten</h2>
    <div class="specs">
      <?php foreach ($specs as $s): ?>
        <div class="specs__row">
          <span class="specs__label"><?= $s->label() ?></span>
          <span class="specs__value"><?= $s->value() ?></span>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<?php
  // Gallery: explicit selection if provided, otherwise auto-fallback to all images in the page folder (minus the main one)
  $gallery = $page->gallery()->toFiles();
  if (!$gallery->count()) {
      $gallery = $allImages->filter(fn($f) => !$img || $f->id() !== $img->id());
  }
?>
<?php if ($gallery->count()): ?>
<section class="prose-section" style="padding-top:0">
  <div class="container">
    <h2 class="h2" data-reveal>Eindrücke</h2>
    <div class="gallery">
      <?php foreach ($gallery as $g): ?>
        <figure data-reveal><img src="<?= $g->url() ?>" alt="<?= $g->alt()->or($page->title()) ?>" loading="lazy" /></figure>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<section class="cta-band">
  <div class="container cta-band__inner">
    <div>
      <p class="eyebrow">Bereit?</p>
      <h2 class="h2">Komm aufs Wasser.</h2>
      <p class="lede">Persönliche Beratung, individuelle Konfiguration — wir melden uns innerhalb von 24 Stunden.</p>
    </div>
    <div class="cta-band__actions">
      <a href="tel:<?= str_replace([' ', '/'], '', $site->contact_phone()) ?>" class="btn btn--primary btn--lg">Anrufen</a>
      <a href="mailto:<?= $site->contact_email() ?>" class="btn btn--outline btn--lg">E-Mail</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
