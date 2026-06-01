<?php
/**
 * Pick the "main" image of a product page:
 * 1. exact match for {slug}.webp / .png / .jpg
 * 2. otherwise the first image alphabetically
 */
if (!function_exists('product_main_image')) {
  function product_main_image($product) {
      $slug = $product->slug();
      foreach (['webp','png','jpg','jpeg'] as $ext) {
          $f = $product->image($slug . '.' . $ext);
          if ($f) return $f;
      }
      return $product->images()->first();
  }
}

$nav = [
  'boards'        => 'Boards',
  'angler'        => 'Für Angler',
  'konfigurieren' => 'Konfigurieren',
  'ueber-uns'     => 'Über uns',
  'b2b'           => 'B2B',
  'kontakt'       => 'Kontakt',
];
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title><?= $page->isHomePage() ? $site->title() : $page->title() . ' — ' . $site->title() ?></title>
<meta name="description" content="<?= $page->seo_description()->or($site->tagline())->escape() ?>" />
<meta name="theme-color" content="#0a0a0c" />
<link rel="icon" href="<?= url('assets/img/BoostBoards_Logo_simple.png') ?>" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />
<?= css('assets/css/style.css') ?>
</head>
<body class="page--<?= $page->template()->name() ?>">

<header class="nav" id="nav">
  <div class="nav__inner">
    <a href="<?= url() ?>" class="nav__logo" aria-label="BoostBoards">
      <img src="<?= url('assets/img/Boostboards-Logo.png') ?>" alt="BoostBoards" class="nav__logo-img" />
    </a>

    <nav class="nav__menu" aria-label="Hauptnavigation">
      <?php foreach ($nav as $slug => $label): $p = page($slug); ?>
        <a href="<?= $p ? $p->url() : url($slug) ?>"<?= ($p && $p->isOpen()) ? ' class="is-active"' : '' ?>><?= $label ?></a>
      <?php endforeach ?>
      <?= snippet('social', ['variant' => 'mobile']) ?>
    </nav>

    <div class="nav__actions">
      <?= snippet('social', ['variant' => 'header']) ?>
      <a href="<?= page('konfigurieren') ? page('konfigurieren')->url() : '#' ?>" class="btn btn--ghost btn--sm">Konfigurieren</a>
      <a href="<?= page('boards') ? page('boards')->url() : '#' ?>" class="btn btn--primary btn--sm">Boards ansehen</a>
      <button class="nav__burger" id="navBurger" aria-label="Menü" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
