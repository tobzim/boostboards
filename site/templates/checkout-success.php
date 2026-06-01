<?php snippet('header') ?>

<section class="checkout-hero checkout-hero--success">
  <div class="container checkout-hero__inner">
    <div class="checkout-hero__icon" aria-hidden="true">
      <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="16" cy="16" r="13"/>
        <path d="M10 16.5l4 4 8-9"/>
      </svg>
    </div>
    <p class="eyebrow" data-reveal>Bestellung erfolgreich</p>
    <h1 class="page-hero__title" data-reveal>Danke, wir bauen<br/>dein Board.</h1>
    <p class="page-hero__lede" data-reveal>
      Wir haben deine Zahlung erhalten und melden uns innerhalb von 24 Stunden mit der Auftrags­bestätigung
      und voraussichtlichem Liefertermin per E-Mail. Stripe sendet dir parallel die offizielle Rechnung als PDF.
    </p>

    <div class="checkout-hero__cta" data-reveal>
      <a href="<?= page('boards') ? page('boards')->url() : '/' ?>" class="btn btn--primary btn--lg">Weitere Boards ansehen</a>
      <a href="<?= page('kontakt') ? page('kontakt')->url() : '/' ?>" class="btn btn--outline btn--lg">Kontakt</a>
    </div>

    <p class="checkout-hero__hint">
      Fragen zur Bestellung? Schreib uns an
      <a href="mailto:<?= $site->contact_email() ?>"><?= $site->contact_email() ?></a>
      oder ruf an unter <a href="tel:<?= str_replace([' ', '/'], '', $site->contact_phone()) ?>"><?= $site->contact_phone() ?></a>.
    </p>
  </div>
</section>

<?php snippet('footer') ?>
