<?php snippet('header') ?>

<section class="checkout-hero checkout-hero--cancel">
  <div class="container checkout-hero__inner">
    <div class="checkout-hero__icon checkout-hero__icon--neutral" aria-hidden="true">
      <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="16" cy="16" r="13"/>
        <path d="M11 11l10 10M21 11L11 21"/>
      </svg>
    </div>
    <p class="eyebrow" data-reveal>Kein Problem</p>
    <h1 class="page-hero__title" data-reveal>Vorgang abgebrochen.<br/>Es wurde nichts abgebucht.</h1>
    <p class="page-hero__lede" data-reveal>
      Du hast den Bezahlvorgang abgebrochen. Wir haben keine Zahlung empfangen, und es ist kein Vertrag entstanden.
      Wenn du Fragen zum Board hattest, ruf uns kurz an — wir bauen jedes Board nach deinen Wünschen.
    </p>

    <div class="checkout-hero__cta" data-reveal>
      <a href="<?= page('boards') ? page('boards')->url() : '/' ?>" class="btn btn--primary btn--lg">Zurück zu den Boards</a>
      <a href="<?= page('kontakt') ? page('kontakt')->url() : '/' ?>" class="btn btn--outline btn--lg">Persönliche Beratung</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
