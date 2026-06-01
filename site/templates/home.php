<?php snippet('header') ?>

<?php
  $heroImg     = $page->hero_image()->toFile();
  $heroVideo   = $page->hero_video()->toFile();
  // Default hero video: lightweight 720p loop derived from the angler trailer.
  // Override via Panel field "Hero-Video".
  $heroVideoUrl = $heroVideo ? $heroVideo->url() : url('assets/video/hero-loop.mp4');
  $heroPoster   = $heroImg ? $heroImg->url() : url('assets/img/hero-poster.jpg');
  $boards       = page('boards')?->children()->listed();
?>

<!-- Preload hero video so playback starts as soon as the first chunks arrive -->
<link rel="preload" as="video" href="<?= $heroVideoUrl ?>" type="video/mp4" />

<!-- HERO -->
<section class="hero hero--video" id="top">
  <div class="hero__media">
    <video
      autoplay muted loop playsinline
      preload="auto"
      disablepictureinpicture
      disableremoteplayback
      poster="<?= $heroPoster ?>"
      aria-hidden="true">
      <source src="<?= $heroVideoUrl ?>" type="video/mp4" />
    </video>
    <div class="hero__gradient"></div>
  </div>

  <div class="hero__content">
    <p class="eyebrow" data-reveal><?= $page->hero_eyebrow()->or('Series 2026 — Made in Hamburg') ?></p>
    <h1 class="hero__title" data-reveal><?= nl2br($page->hero_title()->or("Gebaut für\njedes Wasser.")->escape()) ?></h1>
    <p class="hero__sub" data-reveal><?= nl2br($page->hero_sub()->or("SUP-Freiheit trifft Motor-Power. Ein Board.\nUnendliche Möglichkeiten — auf See, Fluss und Meer.")->escape()) ?></p>
    <div class="hero__cta" data-reveal>
      <a href="<?= page('boards') ? page('boards')->url() : '#' ?>" class="btn btn--primary btn--lg">Modelle ansehen</a>
      <a href="<?= page('konfigurieren') ? page('konfigurieren')->url() : '#' ?>" class="btn btn--outline btn--lg">Jetzt konfigurieren</a>
    </div>
  </div>

  <a href="#learn" class="hero__scroll" aria-label="Weiterscrollen">
    <span class="hero__scroll-line"></span>
    <span class="hero__scroll-text">Scroll</span>
  </a>
</section>

<!-- LERNEN -->
<section class="learn" id="learn">
  <div class="container learn__grid">
    <div class="learn__media" data-reveal>
      <img src="<?= url('assets/img/Boost-Electric-500.webp') ?>" alt="Boost Electric 500" />
    </div>
    <div class="learn__copy">
      <p class="eyebrow" data-reveal><?= $page->learn_eyebrow()->or('Lerne BoostBoarding') ?></p>
      <h2 class="h2" data-reveal><?= nl2br($page->learn_title()->or("In Sekunden startklar.\nVom ersten Meter an.")->escape()) ?></h2>
      <p class="lede" data-reveal><?= $page->learn_text()->or('Vereinbare eine persönliche Testfahrt in Hamburg oder einem unserer Partnerstützpunkte. Wir zeigen dir Setup, Trimmung und Motor-Handling — bis du dich auf dem Wasser zuhause fühlst.') ?></p>
      <a href="<?= page('kontakt') ? page('kontakt')->url() : '#' ?>" class="link-arrow" data-reveal>Testfahrt buchen <span>→</span></a>
    </div>
  </div>
</section>

<!-- SHOWROOM -->
<section class="local" id="local">
  <div class="container local__inner">
    <div class="local__copy">
      <p class="eyebrow" data-reveal><?= $page->local_eyebrow()->or('Shop Local') ?></p>
      <h2 class="h2" data-reveal><?= nl2br($page->local_title()->or("Hamburg.\nUnd weit darüber hinaus.")->escape()) ?></h2>
      <p class="lede" data-reveal><?= $page->local_text()->or('Hauptsitz und Showroom in Hamburg-Niendorf. Auslieferung deutschlandweit und in die EU. Persönliche Beratung — telefonisch, per WhatsApp oder vor Ort.') ?></p>
      <div class="local__meta">
        <div data-reveal>
          <span class="local__label">Adresse</span>
          <span><?= $site->contact_address()->kt() ?></span>
        </div>
        <div data-reveal>
          <span class="local__label">Telefon</span>
          <span><?= $site->contact_phone() ?></span>
        </div>
        <div data-reveal>
          <span class="local__label">WhatsApp</span>
          <span><?= $site->contact_mobile() ?></span>
        </div>
      </div>
    </div>
    <div class="local__map" data-reveal>
      <div class="local__pin"></div>
      <span class="local__pin-label">Showroom Hamburg</span>
    </div>
  </div>
</section>

<!-- MODELLE -->
<section class="models" id="boards">
  <div class="container">
    <div class="models__head">
      <p class="eyebrow" data-reveal>Die Modelle</p>
      <h2 class="h2" data-reveal>Ein System.<br/>Sieben Charaktere.</h2>
      <p class="lede lede--center" data-reveal>Vom puren SUP über E-Antrieb bis zur 6 PS-Fuel-Variante — jedes Board basiert auf demselben katamaran­förmigen Rumpf. Du wechselst den Antrieb. Nicht das Board.</p>
    </div>

    <div class="models__grid">
      <?php $i = 0; foreach (($boards ?? []) as $product): $i++;
        $img = product_main_image($product);
        $isFeature = $product->slug() === 'boost-fishing-pro';
      ?>
        <article class="card<?= $isFeature ? ' card--feature' : '' ?>" data-reveal>
          <a href="<?= $product->url() ?>" class="card__link">
            <div class="card__media">
              <?php if ($img): ?>
                <img class="card__img" src="<?= $img->url() ?>" alt="<?= $img->alt()->or($product->title()) ?>" loading="lazy" />
              <?php endif ?>
              <span class="card__badge<?= $isFeature ? ' card__badge--gold' : '' ?>"><?= $product->badge()->or('Boost Board') ?></span>
              <?php if ($product->stripe_payment_link()->isNotEmpty()): ?>
                <span class="card__buy">Direkt kaufen</span>
              <?php endif ?>
            </div>
            <div class="card__body">
              <h3 class="card__title"><?= $product->title() ?></h3>
              <p class="card__desc"><?= $product->short() ?></p>
              <div class="card__foot">
                <span class="card__price"><?= $product->price() ?></span>
                <span class="link-arrow link-arrow--sm">Details <span>→</span></span>
              </div>
            </div>
          </a>
        </article>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- INNOVATION -->
<section class="innovation" id="innovation">
  <div class="container">
    <div class="innovation__head">
      <p class="eyebrow" data-reveal>Innovation</p>
      <h2 class="h2" data-reveal><?= nl2br($page->innovation_title()->or("Eine Plattform.\nVier Stellschrauben.")->escape()) ?></h2>
    </div>
    <div class="innovation__grid">
      <?php foreach ($page->features()->toStructure() as $f): ?>
        <article class="feature" data-reveal>
          <div class="feature__num"><?= $f->number() ?></div>
          <h3 class="feature__title"><?= $f->title() ?></h3>
          <p class="feature__copy"><?= $f->text() ?></p>
        </article>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- ANGLER VIDEO -->
<section class="video-band">
  <div class="container">
    <div class="video-band__inner" data-reveal>
      <video class="video-band__media" controls preload="metadata" poster="<?= url('assets/img/Boost-Fishing-Pro-Limited-Edition-x-Felix-Pinedo.webp') ?>">
        <source src="<?= url('assets/video/angler-trailer.mp4') ?>" type="video/mp4" />
      </video>
      <div class="video-band__copy">
        <p class="eyebrow">Limited Edition — Felix Pinedo</p>
        <h2 class="h2">„Dieses Board ist eine Waffe."</h2>
        <p class="lede">Der Fishing Pro: lautlos, ausgestattet bis ins Detail, signiert von Felix Pinedo.</p>
        <a href="<?= page('angler') ? page('angler')->url() : '#' ?>" class="btn btn--outline btn--lg">Zur Angler-Welt</a>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="quotes">
  <div class="container">
    <div class="quotes__grid">
      <?php foreach ($page->quotes()->toStructure() as $q): ?>
        <figure class="quote" data-reveal>
          <blockquote>„<?= $q->quote() ?>"</blockquote>
          <figcaption>— <?= $q->author() ?></figcaption>
        </figure>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div class="container">
    <p class="eyebrow eyebrow--center" data-reveal>Boost Community</p>
    <h2 class="h2 h2--center" data-reveal><?= nl2br($page->stats_title()->or("Vom Hamburger Hafen\nauf die Wasser Europas.")->escape()) ?></h2>
    <div class="stats__grid">
      <?php foreach ($page->stats()->toStructure() as $s): ?>
        <div class="stat" data-reveal>
          <div class="stat__num" data-count="<?= $s->value() ?>" data-suffix="<?= $s->suffix() ?>">0</div>
          <div class="stat__label"><?= $s->label() ?></div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- SOCIAL BAND -->
<?= snippet('social') ?>

<!-- CTA -->
<section class="cta-band" id="kontakt-band">
  <div class="container cta-band__inner">
    <div>
      <p class="eyebrow" data-reveal>Bereit?</p>
      <h2 class="h2" data-reveal>Komm aufs Wasser.</h2>
      <p class="lede" data-reveal>Persönliche Beratung von Mensch zu Mensch. Per Telefon, WhatsApp, Mail — oder direkt im Showroom Hamburg.</p>
    </div>
    <div class="cta-band__actions" data-reveal>
      <a href="tel:<?= str_replace([' ', '/'], '', $site->contact_phone()) ?>" class="btn btn--primary btn--lg">Anrufen</a>
      <a href="mailto:<?= $site->contact_email() ?>" class="btn btn--outline btn--lg">E-Mail schreiben</a>
    </div>
  </div>
</section>

<?php snippet('footer') ?>
