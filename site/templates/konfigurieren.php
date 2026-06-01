<?php snippet('header') ?>

<section class="legal-hero">
  <div class="container">
    <p class="eyebrow" data-reveal><?= $page->eyebrow()->or('Konfigurator') ?></p>
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

<section class="prose-section" style="padding-top:0">
  <div class="container">
    <h2 class="h2" data-reveal>Optionen &amp; Zubehör</h2>
    <p class="lede" data-reveal>Modular, austauschbar, jederzeit nachrüstbar.</p>

    <div class="config-grid">
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/schwarz.png') ?>" alt="Hull in Schwarz" loading="lazy" />
        <figcaption><span>Hull-Farbe</span>Schwarz</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/weiss.png') ?>" alt="Hull in Weiß" loading="lazy" />
        <figcaption><span>Hull-Farbe</span>Weiß</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/paddel-mit-logo.png') ?>" alt="BoostBoards Paddel" loading="lazy" />
        <figcaption><span>Paddle</span>Paddel mit Logo</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/Montageplatform.png') ?>" alt="Montageplatform" loading="lazy" />
        <figcaption><span>Rail-Modul</span>Montageplatform</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/gurte.png') ?>" alt="Spanngurte" loading="lazy" />
        <figcaption><span>Transport</span>Spanngurte</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/wagen-mit-gurten.png') ?>" alt="Transportwagen" loading="lazy" />
        <figcaption><span>Transport</span>Transportwagen</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/config/Boost-Box-done-scaled-1.png') ?>" alt="Boost Box" loading="lazy" />
        <figcaption><span>Storage</span>Boost Box</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/Sticker.webp') ?>" alt="BoostBoards Sticker" loading="lazy" />
        <figcaption><span>Extra</span>Sticker</figcaption>
      </figure>
    </div>
  </div>
</section>

<section class="prose-section" style="padding-top:0">
  <div class="container">
    <h2 class="h2" data-reveal>Motoren-Optionen</h2>
    <p class="lede" data-reveal>Vom Trolling-Motor bis 15 PS — wähle den Antrieb für deine Anwendung.</p>

    <div class="config-grid config-grid--motors">
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/35ps.png') ?>" alt="3,5 PS" loading="lazy" />
        <figcaption><span>Verbrenner</span>3,5 PS</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/6ps-blau.png') ?>" alt="6 PS" loading="lazy" />
        <figcaption><span>Verbrenner</span>6 PS</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/8PS-1.png') ?>" alt="8 PS" loading="lazy" />
        <figcaption><span>Verbrenner</span>8 PS</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/9.9-Weiss.png') ?>" alt="9,9 PS" loading="lazy" />
        <figcaption><span>Verbrenner</span>9,9 PS</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/15PS-Pinne-scaled-1.png') ?>" alt="15 PS mit Pinne" loading="lazy" />
        <figcaption><span>Verbrenner</span>15 PS Pinne</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/Recon.png') ?>" alt="Recon Trolling-Motor" loading="lazy" />
        <figcaption><span>Trolling</span>Recon</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/SailPro.png') ?>" alt="SailPro" loading="lazy" />
        <figcaption><span>Spezial</span>SailPro</figcaption>
      </figure>
      <figure class="config-tile" data-reveal>
        <img src="<?= url('assets/img/motors/pinne.png') ?>" alt="Pinne / Steuerung" loading="lazy" />
        <figcaption><span>Steuerung</span>Pinne</figcaption>
      </figure>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container cta-band__inner">
    <div>
      <p class="eyebrow">Bereit?</p>
      <h2 class="h2">Lass uns dein Setup bauen.</h2>
      <p class="lede">Schreib uns deine Wunschkonfiguration — wir melden uns mit Vorschlag und Lieferzeit.</p>
    </div>
    <div class="cta-band__actions">
      <a href="tel:<?= str_replace([' ', '/'], '', $site->contact_phone()) ?>" class="btn btn--primary btn--lg">Anrufen</a>
      <a href="mailto:<?= $site->contact_email() ?>" class="btn btn--outline btn--lg">E-Mail</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
