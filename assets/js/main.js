(() => {
  const nav    = document.getElementById('nav');
  const burger = document.getElementById('navBurger');
  const menu   = document.querySelector('.nav__menu');
  const root   = document.documentElement;

  /* ------------------------------------------------------------------
     1. Track the nav's actual height as --nav-h on <html>.
        The mobile menu uses it for top:var(--nav-h) so the panel always
        starts exactly below the bar — independent of scrolled state,
        font scaling, or container width.
  ------------------------------------------------------------------ */
  const syncNavHeight = () => {
    if (!nav) return;
    root.style.setProperty('--nav-h', nav.offsetHeight + 'px');
  };
  syncNavHeight();
  window.addEventListener('resize',     syncNavHeight, { passive: true });
  window.addEventListener('orientationchange', syncNavHeight, { passive: true });
  // Re-measure once fonts have loaded (may change logo height slightly)
  if (document.fonts?.ready) document.fonts.ready.then(syncNavHeight);

  /* ------------------------------------------------------------------
     2. Sticky nav state — also re-syncs --nav-h because the scrolled
        state changes the padding.
  ------------------------------------------------------------------ */
  let lastScrolled = false;
  const onScroll = () => {
    if (!nav) return;
    const scrolled = window.scrollY > 30;
    if (scrolled !== lastScrolled) {
      nav.classList.toggle('is-scrolled', scrolled);
      lastScrolled = scrolled;
      // Measure after the transition kicks in
      requestAnimationFrame(syncNavHeight);
      setTimeout(syncNavHeight, 300);
    }
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ------------------------------------------------------------------
     3. Mobile burger — viewport-fixed slide-down menu.
        body.menu-open locks scroll behind it.
  ------------------------------------------------------------------ */
  const setMenu = (open) => {
    if (!menu || !burger) return;
    menu.classList.toggle('is-open', open);
    burger.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('menu-open', open);
  };
  if (burger && menu) {
    burger.addEventListener('click', (e) => {
      e.stopPropagation();
      setMenu(!menu.classList.contains('is-open'));
    });
    menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setMenu(false)));
    window.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });
    window.addEventListener('resize', () => { if (window.innerWidth > 960) setMenu(false); });
  }

  /* ------------------------------------------------------------------
     4. Reveal-on-scroll for [data-reveal] elements.
  ------------------------------------------------------------------ */
  const revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e, i) => {
        if (e.isIntersecting) {
          const delay = (i % 6) * 60;
          setTimeout(() => e.target.classList.add('is-in'), delay);
          io.unobserve(e.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.12 });
    revealEls.forEach(el => io.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('is-in'));
  }

  /* ------------------------------------------------------------------
     5. Animated counters in the stats grid.
  ------------------------------------------------------------------ */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const countObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.count, 10) || 0;
        const suffix = el.dataset.suffix || '';
        const dur = 1600;
        const start = performance.now();
        const tick = (now) => {
          const p = Math.min((now - start) / dur, 1);
          const eased = 1 - Math.pow(1 - p, 3);
          const val = Math.round(target * eased);
          el.textContent = val.toLocaleString('de-DE') + suffix;
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
        countObs.unobserve(el);
      });
    }, { threshold: 0.4 });
    counters.forEach(c => countObs.observe(c));
  }

  /* Hero parallax intentionally removed — moving the video under the nav
     forced backdrop recomposition and caused the header to jitter. The
     hero now stays still; the nav background is fully opaque on scroll. */
})();
