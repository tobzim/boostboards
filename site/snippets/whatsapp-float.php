<?php
$wa = preg_replace('/[^0-9]/', '', (string) $site->social_whatsapp());
if (!$wa) return;
?>
<a href="https://wa.me/<?= $wa ?>?text=<?= rawurlencode('Hi, ich interessiere mich für ein BoostBoard.') ?>"
   class="wa-float"
   target="_blank" rel="noopener"
   aria-label="WhatsApp">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M21 11.5a8.5 8.5 0 0 1-12.83 7.31L3 20.5l1.74-5.04A8.5 8.5 0 1 1 21 11.5z"/>
    <path d="M8.5 9.5c.3 1.6 1.4 3 3 4 1.6 1 3 1.4 4.5 1.5l-1-2-2 .5c-1-.5-2-1.5-2.5-2.5l.5-2-2-1-.5 1.5z"/>
  </svg>
</a>
