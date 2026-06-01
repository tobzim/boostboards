<?php snippet('header') ?>

<section class="legal-hero">
  <div class="container">
    <p class="eyebrow" data-reveal><?= $page->eyebrow()->or('Die Modelle') ?></p>
    <h1 class="page-hero__title" data-reveal><?= nl2br($page->headline()->or($page->title())->escape()) ?></h1>
    <?php if ($page->lede()->isNotEmpty()): ?>
      <p class="page-hero__lede" data-reveal><?= $page->lede() ?></p>
    <?php endif ?>
  </div>
</section>

<section class="models" style="padding-top:40px">
  <div class="container">
    <div class="models__grid">
      <?php foreach ($page->children()->listed() as $product):
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

<?php snippet('footer') ?>
