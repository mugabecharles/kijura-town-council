# Kijura Town Council — Deployment Guide

This document covers deploying the website to **Render.com** (free tier) with a
managed **PostgreSQL** database, and keeping the code in sync via **GitHub**.

---

## Repository

| Item | Value |
|------|-------|
| GitHub repo | https://github.com/mugabecharles/kijura-town-council |
| Branch | `main` |
| Stack | Laravel 13 · PHP 8.3 · PostgreSQL · Bootstrap 5 |

---

## 1 — One-time Render setup

### 1.1 Create a Render account

Go to https://render.com and sign up (free). Connect your GitHub account when
prompted so Render can pull code from `mugabecharles/kijura-town-council`.

---

### 1.2 Create the PostgreSQL database first

1. In the Render dashboard click **New → PostgreSQL**.
2. Fill in:
   - **Name** → `kijura-db`
   - **Database** → `kijura_council`
   - **User** → `kijura`
   - **Region** → choose closest to Uganda (Frankfurt `eu-central` or Singapore `ap-southeast`)
   - **Plan** → Free
3. Click **Create Database**.
4. Once created, open the database and copy the **Internal Database URL** — you will need it in step 1.4.

---

### 1.3 Create the Web Service

1. Click **New → Web Service**.
2. Connect the repo `mugabecharles/kijura-town-council`.
3. Fill in:

   | Field | Value |
   |-------|-------|
   | Name | `kijura-town-council` |
   | Runtime | **PHP** |
   | Region | Same as database |
   | Branch | `main` |
   | Build Command | `./scripts/render-build.sh` |
   | Start Command | `php artisan serve --host=0.0.0.0 --port=$PORT` |
   | Plan | Free |

4. Scroll down to **Environment Variables** and add every variable from the
   table in section 2 below.

5. Click **Create Web Service**. Render will immediately run the first build.

---

### 1.4 Link database → web service

In the web service environment variables, add:

| Key | Value |
|-----|-------|
| `DATABASE_URL` | Paste the **Internal Database URL** from step 1.2 |

Render also supports **auto-linking** via `render.yaml` (already committed). If
you used the Blueprint flow (New → Blueprint) instead of manual setup, Render
reads `render.yaml` and creates both the service and the database automatically.

---

## 2 — Required environment variables

Set these in **Render → Web Service → Environment**:

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Laravel encryption key — click **Generate** in Render or run `php artisan key:generate --show` locally | `base64:abc...` |
| `APP_URL` | Your Render service URL (set after first deploy) | `https://kijura-town-council.onrender.com` |
| `APP_ENV` | Always `production` | `production` |
| `APP_DEBUG` | Always `false` in production | `false` |
| `DB_CONNECTION` | `pgsql` | `pgsql` |
| `DATABASE_URL` | Internal connection string from Render PostgreSQL | `postgresql://kijura:...@...` |
| `SESSION_DRIVER` | `cookie` (no Redis needed on free tier) | `cookie` |
| `CACHE_STORE` | `file` | `file` |
| `QUEUE_CONNECTION` | `sync` | `sync` |
| `LOG_CHANNEL` | `stderr` (Render captures stderr as logs) | `stderr` |
| `LOG_LEVEL` | `error` | `error` |

**Optional — mail (add when ready):**

| Variable | Description |
|----------|-------------|
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | Your SMTP host (e.g. `smtp.mailgun.org`) |
| `MAIL_PORT` | `587` |
| `MAIL_USERNAME` | SMTP username |
| `MAIL_PASSWORD` | SMTP password |
| `MAIL_FROM_ADDRESS` | `info@kijuratowncouncil.go.ug` |
| `MAIL_ENCRYPTION` | `tls` |

---

## 3 — What happens on every deploy

When you push to `main`, Render automatically runs `./scripts/render-build.sh`
which does the following in order:

1. `composer install --no-dev --optimize-autoloader`
2. Copies `.env.render` → `.env` (structural settings only; secrets come from Render env vars)
3. `php artisan key:generate --force`
4. `php artisan migrate --force` (safe to run repeatedly — only applies new migrations)
5. `php artisan db:seed --force` (idempotent — uses `firstOrCreate` everywhere)
6. `php artisan storage:link`
7. `php artisan config:cache && route:cache && view:cache`

Total build time on free tier: approximately 3–5 minutes.

---

## 4 — After first deploy: update APP_URL

1. Once the service is live, copy the public URL from the Render dashboard
   (e.g. `https://kijura-town-council.onrender.com`).
2. Go to **Environment → APP_URL** and set it to that URL.
3. Render will redeploy automatically.

---

## 5 — Admin login

After the first successful deploy, log in with:

| Field | Value |
|-------|-------|
| URL | `https://your-app.onrender.com/admin` |
| Email | `admin@kijuratowncouncil.go.ug` |
| Password | `Admin@2026!` |

**Change the password immediately** via Admin → Users after first login.

---

## 6 — File uploads on Render free tier

> ⚠️ Render's free tier uses an **ephemeral filesystem** — uploaded files
> (images, documents) are lost on every redeploy or restart.

For production with persistent uploads, choose one of:

### Option A — Cloudflare R2 (free 10 GB/month)
1. Create an R2 bucket at https://dash.cloudflare.com
2. Install the S3 driver: `composer require league/flysystem-aws-s3-v3`
3. Add env vars: `FILESYSTEM_DISK=s3`, `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`,
   `AWS_DEFAULT_REGION=auto`, `AWS_BUCKET`, `AWS_ENDPOINT=https://<accountid>.r2.cloudflarestorage.com`

### Option B — Render Persistent Disk (paid, $0.25/GB/month)
Add a disk in Render → Web Service → Disks, mount at `/var/task/storage/app`.

### Option C — Upgrade to Render paid plan
Paid instances have persistent storage.

---

## 7 — Keeping code up to date

```bash
# Make changes locally, then:
git add .
git commit -m "describe your change"
git push origin main
# Render auto-deploys from GitHub within ~1 minute
```

---

## 8 — Useful Render CLI / dashboard actions

| Action | How |
|--------|-----|
| View live logs | Render dashboard → Web Service → Logs |
| Run artisan command | Render dashboard → Web Service → Shell → `php artisan ...` |
| Manual redeploy | Render dashboard → Web Service → Manual Deploy |
| Rollback | Render dashboard → Web Service → Deploys → select previous → Rollback |

---

## 9 — Custom domain (when council has official domain)

1. In Render dashboard → Web Service → Settings → Custom Domains → Add Domain.
2. Add a `CNAME` record pointing to your Render service URL at your DNS registrar.
3. Render provisions a free TLS/SSL certificate automatically via Let's Encrypt.
4. Update `APP_URL` to the custom domain once active.

The recommended domain pattern for Uganda local government sites is
`kijura.go.ug` or `kijuratowncouncil.go.ug`, registered through the Uganda
Communications Commission / NIC Uganda.

---

*Last updated: October 2026 — Kijura Town Council website v1.0*
