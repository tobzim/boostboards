<?php
/**
 * Social media row. Usage:
 *   <?= snippet('social', ['variant' => 'footer']) ?>
 *
 * Variants:
 *   - default  : large prominent row (band / hero)
 *   - footer   : compact icons for the footer
 *   - mobile   : in the mobile menu (medium size)
 *   - header   : just the IG icon next to the actions
 */

$variant = $variant ?? 'default';

$wa = (string) $site->social_whatsapp();
$wa = preg_replace('/[^0-9]/', '', $wa);

$links = array_filter([
  'instagram' => [
    'label' => 'Instagram',
    'url'   => (string) $site->social_instagram(),
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
  ],
  'whatsapp' => [
    'label' => 'WhatsApp',
    'url'   => $wa ? 'https://wa.me/' . $wa : '',
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.5 8.5 0 0 1-12.83 7.31L3 20.5l1.74-5.04A8.5 8.5 0 1 1 21 11.5z"/><path d="M8.5 9.5c.3 1.6 1.4 3 3 4 1.6 1 3 1.4 4.5 1.5l-1-2-2 .5c-1-.5-2-1.5-2.5-2.5l.5-2-2-1-.5 1.5z"/></svg>',
  ],
  'youtube' => [
    'label' => 'YouTube',
    'url'   => (string) $site->social_youtube(),
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="6" width="19" height="12" rx="3"/><path d="M10 9.5l5 2.5-5 2.5z" fill="currentColor"/></svg>',
  ],
  'facebook' => [
    'label' => 'Facebook',
    'url'   => (string) $site->social_facebook(),
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8h2V5h-2a3 3 0 0 0-3 3v2H9v3h2v8h3v-8h2.2l.3-3H14V8.5c0-.3.2-.5.5-.5z"/></svg>',
  ],
  'tiktok' => [
    'label' => 'TikTok',
    'url'   => (string) $site->social_tiktok(),
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4v9.5a3.5 3.5 0 1 1-3.5-3.5"/><path d="M14 4c0 2.5 2 4 4.5 4"/></svg>',
  ],
  'linkedin' => [
    'label' => 'LinkedIn',
    'url'   => (string) $site->social_linkedin(),
    'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 0 1 4 0v4M12 12v5"/></svg>',
  ],
], fn($l) => !empty($l['url']));

if (empty($links)) return;
?>

<?php if ($variant === 'header'): ?>
  <?php $ig = $links['instagram'] ?? null; if ($ig): ?>
    <a href="<?= esc($ig['url']) ?>" class="social-icon social-icon--header" target="_blank" rel="noopener" aria-label="<?= esc($ig['label']) ?>">
      <?= $ig['svg'] ?>
    </a>
  <?php endif ?>

<?php elseif ($variant === 'footer'): ?>
  <div class="social-row social-row--footer">
    <?php foreach ($links as $k => $l): ?>
      <a href="<?= esc($l['url']) ?>" class="social-icon" target="_blank" rel="noopener" aria-label="<?= esc($l['label']) ?>">
        <?= $l['svg'] ?>
      </a>
    <?php endforeach ?>
  </div>

<?php elseif ($variant === 'mobile'): ?>
  <div class="social-row social-row--mobile">
    <?php foreach ($links as $k => $l): ?>
      <a href="<?= esc($l['url']) ?>" class="social-icon social-icon--lg" target="_blank" rel="noopener" aria-label="<?= esc($l['label']) ?>">
        <?= $l['svg'] ?>
      </a>
    <?php endforeach ?>
  </div>

<?php else: /* default = big prominent band */ ?>
  <section class="social-band">
    <div class="container">
      <p class="eyebrow eyebrow--center" data-reveal>Folg uns</p>
      <h2 class="h2 h2--center" data-reveal>BoostBoards — auf jedem Kanal.</h2>
      <p class="lede lede--center" data-reveal>Videos, Setups, Storys aus der Hamburger Werkstatt und vom Wasser.</p>
      <div class="social-grid" data-reveal>
        <?php foreach ($links as $k => $l): ?>
          <a href="<?= esc($l['url']) ?>" class="social-card social-card--<?= $k ?>" target="_blank" rel="noopener" aria-label="<?= esc($l['label']) ?>">
            <span class="social-card__icon"><?= $l['svg'] ?></span>
            <span class="social-card__label"><?= esc($l['label']) ?></span>
            <span class="social-card__arrow" aria-hidden="true">→</span>
          </a>
        <?php endforeach ?>
      </div>
    </div>
  </section>
<?php endif ?>
