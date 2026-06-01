<footer class="footer">
  <div class="container footer__grid">
    <div class="footer__brand">
      <img src="<?= url('assets/img/Boostboards-Logo.png') ?>" alt="BoostBoards" class="footer__logo" />
      <p><?= $site->contact_address()->kt() ?></p>
      <p>
        <a href="tel:<?= str_replace([' ', '/'], '', $site->contact_phone()) ?>"><?= $site->contact_phone() ?></a><br/>
        <a href="mailto:<?= $site->contact_email() ?>"><?= $site->contact_email() ?></a>
      </p>
    </div>

    <div class="footer__col">
      <h4>Boards</h4>
      <?php foreach (page('boards')?->children()->listed() ?? [] as $p): ?>
        <a href="<?= $p->url() ?>"><?= $p->title() ?></a>
      <?php endforeach ?>
    </div>

    <div class="footer__col">
      <h4>Entdecken</h4>
      <a href="<?= page('konfigurieren') ? page('konfigurieren')->url() : '#' ?>">Konfigurieren</a>
      <a href="<?= page('angler') ? page('angler')->url() : '#' ?>">Für Angler</a>
      <a href="<?= page('ueber-uns') ? page('ueber-uns')->url() : '#' ?>">Über uns</a>
      <a href="<?= page('b2b') ? page('b2b')->url() : '#' ?>">B2B-Bereich</a>
      <a href="<?= page('kontakt') ? page('kontakt')->url() : '#' ?>">Kontakt</a>
    </div>

    <div class="footer__col">
      <h4>Service</h4>
      <a href="<?= page('agb') ? page('agb')->url() : '#' ?>">AGB</a>
      <a href="<?= page('datenschutz') ? page('datenschutz')->url() : '#' ?>">Datenschutz</a>
      <a href="<?= page('impressum') ? page('impressum')->url() : '#' ?>">Impressum</a>
      <a href="<?= page('barrierefreiheit') ? page('barrierefreiheit')->url() : '#' ?>">Barrierefreiheit</a>
      <a href="<?= page('zahlungsarten') ? page('zahlungsarten')->url() : '#' ?>">Zahlungsarten</a>
      <a href="<?= page('widerruf') ? page('widerruf')->url() : '#' ?>">Widerruf</a>
    </div>
  </div>

  <div class="footer__bottom">
    <div class="container footer__bottom-inner">
      <span>&copy; <?= date('Y') ?> BoostBoards GmbH &amp; Co. KG</span>
      <span>Made in Hamburg. Built for every water.</span>
    </div>
  </div>
</footer>

<?= js('assets/js/main.js') ?>
</body>
</html>
