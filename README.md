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

## Deployment (Hetzner)

Auto-Deploy aus `main` per GitHub Action: [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml).

**Architektur:**
- Läuft als eigener Container neben `hub.cevere` auf dem gleichen Hetzner-Host
- **Nicht** hinter der zentralen Caddy-Proxy — bindet stattdessen direkt auf `8090:80`
- Erreichbar über `http://<HETZNER-IP>:8090`
- Eigenes prod-Compose: [`docker-compose.prod.yml`](docker-compose.prod.yml) — kein Code-Bind-Mount, nur `media/` und `site/accounts` als Named Volumes

**Voraussetzungen einmalig:**

1. Self-hosted GitHub Actions Runner mit Label `hetzner` muss Zugriff auf `tobzim/boostboards` haben.
   - Falls der existierende Runner org-scoped (Com-Credit-Con-tor) ist: einen neuen Runner für dieses Repo registrieren via
     `Repo → Settings → Actions → Runners → New self-hosted runner` und auf dem Server einrichten.
2. Port `8090` in der Hetzner-Firewall freigeben (Hetzner Cloud Console → Firewalls → Inbound Rule `TCP/8090` von Source `Any IPv4`).
3. Stack-Verzeichnis: Workflow legt `/home/tobias/stacks/boostboards/` automatisch beim ersten Run an.

**Ablauf:**

```
git push origin main
  → GitHub Action triggert auf [self-hosted, hetzner]
  → rsync repo → /home/tobias/stacks/boostboards/
  → docker compose -f docker-compose.prod.yml up -d --build
  → curl localhost:8090 health-check
  → docker image prune
```

**Zugriff nach dem Deploy:**

- Frontend: `http://<HETZNER-IP>:8090`
- Panel:    `http://<HETZNER-IP>:8090/panel` (Admin beim ersten Aufruf anlegen)

Server-IP findest du in der Hetzner Cloud Console (laut interner Doku vermutlich `167.235.229.203`).

**Manuell deployen:**
GitHub → Actions → "Deploy to Hetzner" → "Run workflow".

**Produktions-Härtung (später):**
In `site/config/config.php` `debug => false` setzen und `panel.install` entfernen, sobald der Admin-Account angelegt ist.

## Quellen

Bilder, Videos und Rechtstexte stammen von <https://boostboards.de/> — bitte vor Veröffentlichung Rechte mit Sebastian Keye klären.
