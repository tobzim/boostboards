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

## Quellen

Bilder, Videos und Rechtstexte stammen von <https://boostboards.de/> — bitte vor Veröffentlichung Rechte mit Sebastian Keye klären.
