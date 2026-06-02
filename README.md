# BoostBoards — Kirby CMS

Fliteboard-inspired premium site for BoostBoards GmbH & Co. KG.
Runs on Kirby 5 (flat-file CMS, no database) in Docker.

## Stack

- **PHP 8.3** + Apache (official `php:8.3-apache`)
- **Kirby CMS 5.2** (installed via Composer at build time)
- **Static assets** in `/assets`, content in `/content`, templates in `/site`

## Schnellstart

```bash
docker compose up --build
```

Dann im Browser:

- Frontend: <http://localhost:8080>
- Panel:    <http://localhost:8080/panel>

Beim ersten Panel-Aufruf wird der Admin-Account angelegt (`'panel' => ['install' => true]` in `site/config/config.php`).

## Projektstruktur

```
boostboards-flite/
├─ Dockerfile
├─ docker-compose.yml
├─ composer.json          # Kirby 5 + Composer
├─ index.php              # Kirby bootstrap
├─ .htaccess              # URL-Rewrites + Cache + Security Header
├─ assets/
│  ├─ css/style.css       # Premium Dark Theme
│  ├─ js/main.js          # Reveal-Anim, Counter, Parallax
│  ├─ img/                # Logo + Produktbilder (echte boostboards.de Assets)
│  └─ video/              # Angler-Trailer (boostboards.de)
├─ content/               # Alle Seiteninhalte als .txt-Dateien
│  ├─ home/home.txt
│  ├─ 1_boards/           # Boards-Übersicht + 7 Produktseiten
│  ├─ 2_konfigurieren/
│  ├─ 3_angler/
│  ├─ 4_b2b/
│  ├─ 5_ueber-uns/
│  ├─ 6_kontakt/
│  ├─ 7_impressum/        # verbatim aus boostboards.de
│  ├─ 8_datenschutz/      # verbatim
│  ├─ 9_agb/              # verbatim
│  ├─ 10_widerruf/
│  ├─ 11_barrierefreiheit/
│  └─ 12_zahlungsarten/
└─ site/
   ├─ blueprints/         # Panel-Schema (Felder im Backend)
   ├─ templates/          # PHP-Templates (home, default, legal, boards, product)
   ├─ snippets/           # header.php, footer.php
   └─ config/config.php
```

## Inhalte pflegen

Über `/panel` im Browser — alle Felder sind im Panel editierbar (Hero, Innovation-Features, Testimonials, Stats, Produktpreise, Galerie etc.).

Alternativ: direkt die `.txt`-Dateien unter `content/` editieren (Git-friendly).

## Deployment (privater Hetzner-Server)

Auto-Deploy aus `main` per GitHub Action: [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml).
Gleiches Muster wie `atelierhubpim` — GitHub-Hosted Runner baut, pusht zu GHCR, SSHt rauf, `docker compose pull` + `up`.

**Architektur:**
- Image: `ghcr.io/tobzim/boostboards:latest` (+ `:<sha>` Tags pro Commit)
- Bindet direkt auf Host-Port `8090` — **keine** Caddy-/Reverse-Proxy-Integration, damit `hub.cevere` und `atelierhubpim` unangetastet bleiben
- Server-Pfad: `/opt/boostboards/`
- Eigene Named Volumes für `media/` (Panel-Uploads, Kirby-Thumbnails) und `site/accounts` (Admin-Login)

**Einmal-Setup:**

1. **GitHub-Secrets** im Repo (`Settings → Secrets and variables → Actions`):

   | Secret | Wert |
   |---|---|
   | `SSH_HOST` | IP oder Hostname deines Hetzner-Servers |
   | `SSH_USER` | SSH-User (z. B. `tobias`) |
   | `SSH_PRIVATE_KEY` | privater SSH-Key (passender public-key in `~/.ssh/authorized_keys` auf dem Server) |
   | `SSH_PORT` | optional, Default `22` |

   `GITHUB_TOKEN` wird automatisch bereitgestellt — keine Aktion nötig.

2. **Server-seitig:**
   ```bash
   sudo mkdir -p /opt/boostboards
   sudo chown $USER:$USER /opt/boostboards
   ```

3. **Firewall:** Port `8090/tcp` inbound öffnen (Hetzner Cloud Console → Firewalls → Inbound Rule).

**Ablauf bei `git push origin main`:**

```
GitHub-Hosted Runner
  ├─ docker build → ghcr.io/tobzim/boostboards:<sha> + :latest
  ↓ SSH
Privater Hetzner-Server
  ├─ scp docker-compose.prod.yml → /opt/boostboards/
  ├─ docker login ghcr.io (per GITHUB_TOKEN, schreibt .env mit IMAGE_TAG)
  ├─ docker compose pull
  ├─ docker compose up -d --remove-orphans
  ├─ healthcheck auf 127.0.0.1:8090
  └─ docker image prune
```

**Zugriff nach Deploy:**

- Frontend: `http://<SERVER_IP>:8090`
- Panel:    `http://<SERVER_IP>:8090/panel` (Admin beim ersten Aufruf anlegen)

**Manuell deployen:** GitHub → Actions → "Deploy" → "Run workflow".

**Produktions-Härtung (später):**
In `site/config/config.php` `debug => false` setzen und `panel.install` entfernen, sobald der Admin-Account angelegt ist.

## Inhalte im Panel pflegen

Login: `http://<SERVER_IP>:8090/panel` (lokal: `http://localhost:8080/panel`).

### Was du wo findest

| Sektion | Seite im Panel |
|---|---|
| Hero-Headline, Sub, Animation | `Startseite` (Reiter "Hero") |
| Testfahrt-Block | `Startseite` (Reiter "Lerne") |
| Showroom-Text | `Startseite` (Reiter "Showroom") |
| Innovation-Karten (4) | `Startseite` (Reiter "Innovation") |
| Testimonials | `Startseite` (Reiter "Stimmen") |
| Zahlen-Counter | `Startseite` (Reiter "Zahlen") |
| Boards-Übersichtsseite | `Boards` |
| Einzelnes Board (z.B. Boost Board) | `Boards → Boost Board` |
| Stripe Payment Link pro Board | `Boards → [Board] → Shop & Stripe` |
| Über-uns / Konfigurieren / Angler / B2B / Kontakt | gleichnamige Pages auf Top-Level |
| Impressum / Datenschutz / AGB / Widerruf / Barrierefreiheit / Zahlungsarten | gleichnamige Pages |
| Adresse, Telefon, Social-Profile global | `Settings` (Zahnrad rechts oben) → Site-Felder |

### Schnellhilfe

- **Bild ändern:** Zur Seite → Felder-Sektion → Bild rausziehen, neues drag-and-drop → Speichern
- **Neues Produkt:** `Boards` → "+ Add" → Template `product` → Name vergeben → speichern → dann Felder ausfüllen
- **Neuen Rechtstext:** Top-Level "+ Add" → Template `legal` → Headline + Text
- **Social-Profil ändern:** `Settings` (Zahnrad) → Felder "Social Media" → URL pasten

### Falls Pages nicht erscheinen

War ein Bug — die `site.yml` hatte einen Template-Filter gesetzt, der Home, Angler, Konfigurieren und Checkout-Pages aus der Übersicht ausblendete. Seit Commit `XYZ` gefixt. Falls du älteren Stand auf dem Server hast: `docker compose pull && docker compose up -d` triggern.

## Shop (Stripe Payment Links)

Die zwei Standard-Boards (Boost Board, Boost Chill) sind über **Stripe Payment Links** direkt verkaufbar. Kein Plugin, kein Cart-System — eine URL pro Produkt, fertig.

### Einmal einrichten in Stripe

1. Im [Stripe Dashboard](https://dashboard.stripe.com/) → "Payment Links" → **Neuer Payment-Link**
2. Produkt anlegen:
   - **Name:** `BoostBoards Boost Board` (bzw. `Boost Chill`)
   - **Preis:** 2.990 € (3.390 €), inkl. MwSt
   - **Steuerverhalten:** "inklusive" (Endpreis)
   - **Quantity:** "Kunde kann nicht anpassen" (eine Stückzahl pro Transaktion reicht)
3. Auf der Link-Konfigurations-Seite:
   - **Zahlungsmethoden:** Karte, SEPA, Klarna, PayPal aktivieren
   - **Versandadresse erfassen:** Ja, nur DE+EU
   - **Steuern:** Automatic Tax aktivieren (EU OSS — sonst nur deutsche MwSt)
   - **Nach Bezahlung:** "Auf eine eigene URL umleiten" →
     `https://178.105.42.158:8090/checkout-success` (sobald Domain da ist, hier ersetzen)
   - **Erscheinungsbild → Erweitert → Abbruch-URL:** `https://178.105.42.158:8090/checkout-cancel`
4. **Save** → Stripe liefert dir eine URL wie `https://buy.stripe.com/test_abc123...`

### In Kirby eintragen

Im Panel unter `Boards → Boost Board → Tab "Shop & Stripe"` die URL ins Feld **Stripe Payment Link** kopieren. Auf der Live-Seite:
- Der Hero-CTA wird automatisch zu **"Jetzt kaufen"** (öffnet Stripe-Checkout in neuem Tab)
- Das Board bekommt in der Übersicht ein grünes **"Direkt kaufen"**-Badge
- Unter dem Preis erscheint der gesetzlich vorgeschriebene MwSt-Hinweis
- Zahlungslogos (Visa/MC/PayPal/Rechnung) werden eingeblendet

Boards **ohne** Payment-Link (Electric, Fuel, Fishing Pro — alles individuell konfiguriert) behalten den **"Anfragen"**-CTA → Customer landet auf der Kontaktseite. Passt zu eurer AGB (§4: Custom-Boards bis 10 Wochen Lieferzeit).

### Was Stripe für dich macht

- EU-MwSt automatisch nach OSS-Regelwerk
- MwSt-konforme Rechnung als PDF an den Käufer (auch §14a UStG-konform)
- Refunds, Dunning, SCA (Strong Customer Authentication)
- Reporting für die Buchhaltung im Stripe-Dashboard

### Bei Bedarf erweitern

Wenn später ein echter Warenkorb mit mehreren Produkten + Zubehör nötig wird → Migration auf das [Kart-Plugin](https://kart.bnomei.com/) (Kirby 5+, ~150 €). Die Stripe-Produkte können dort übernommen werden.

## Quellen

Bilder, Videos und Rechtstexte stammen von <https://boostboards.de/> — bitte vor Veröffentlichung Rechte mit Sebastian Keye klären.
