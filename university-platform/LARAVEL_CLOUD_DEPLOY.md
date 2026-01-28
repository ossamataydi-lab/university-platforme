# Deploying University Platform to Laravel Cloud

This guide walks you through deploying this Laravel application to [Laravel Cloud](https://cloud.laravel.com).

---

## 1. Requirements checklist

Before deploying, ensure:

| Requirement | Status |
|-------------|--------|
| **Git** | Your code is in a **GitHub**, **GitLab**, or **Bitbucket** repository |
| **Laravel Cloud account** | Sign up at [cloud.laravel.com](https://cloud.laravel.com) with a valid payment method |
| **PHP 8.2+** | ✅ Project uses `php: ^8.2` |
| **Laravel 9+** | ✅ Project uses Laravel 12 |
| **`league/flysystem-aws-s3-v3`** | ✅ Added for Object Storage (S3-compatible) |
| **Object Storage** | Use Laravel Cloud Object Storage for files (avatars, courses, exercises, exams, attachments) — **do not** rely on local disk |

---

## 2. What we changed for Laravel Cloud

- **File storage**: All uploads use the **default disk** (`FILESYSTEM_DISK`). Locally use `public` (with `php artisan storage:link`). On Cloud, set `FILESYSTEM_DISK` to your bucket’s disk name (e.g. `s3`) and add an Object Storage bucket.
- **Broadcasting**: Added a **Reverb** connection. The messages/chat page uses **Reverb** when `REVERB_APP_KEY` is set (Laravel Cloud WebSockets), otherwise **Pusher** for local dev.
- **Downloads**: Replaced `storage_path()` / `response()->download()` with `Storage::download()` so files work with S3.
- **Avatar & file URLs**: Switched from `asset('storage/...')` to `Storage::url()` so they work with both local and S3.

---

## 3. Push your app to Git

1. Initialize Git (if not already):
   ```bash
   git init
   git add .
   git commit -m "Prepare for Laravel Cloud deployment"
   ```
2. Create a repo on **GitHub** / **GitLab** / **Bitbucket** and add it as `origin`.
3. Push your branch (e.g. `main`):
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
   git branch -M main
   git push -u origin main
   ```

---

## 4. Create the Laravel Cloud application

1. Go to [cloud.laravel.com](https://cloud.laravel.com) and sign in.
2. Click **+ New application**.
3. Connect your **Git** provider (GitHub / GitLab / Bitbucket) and authorize Laravel Cloud.
4. Select this project’s **repository**.
5. Set an **application name** (e.g. `university-platform`) and choose a **region**.
6. Click **Create Application**. A default environment (e.g. `main`) is created.

---

## 5. Add resources in the environment

In your environment’s **infrastructure canvas**:

### 5.1 Database (required)

- Click **Add database** → **Laravel MySQL** (or Postgres if you prefer).
- Create a new cluster or use an existing one, then create/select a database.
- **Important**: Use **MySQL** (or Postgres) on Cloud. The app currently defaults to SQLite; Cloud will inject `DB_*` when you attach a database. Set `DB_CONNECTION=mysql` in environment variables.

### 5.2 Object Storage (required for files)

- Click **Add bucket** → **Laravel Object Storage**.
- Create a bucket (e.g. `uploads`). Choose **public** if course/exercise/exam files and avatars should be directly viewable via URL.
- Set the **disk name** to match what you’ll use for `FILESYSTEM_DISK` (e.g. `s3`). Laravel Cloud injects `AWS_*` and `FILESYSTEM_DISK` when the bucket is attached.

### 5.3 WebSockets (optional, for real-time chat)

- In **Org → Resources → WebSockets**, click **+ New WebSocket cluster** (Laravel Reverb).
- Create a cluster, then in your environment canvas click **Add resource** → **WebSockets** and attach the Reverb app.
- Laravel Cloud will inject `REVERB_*` and `VITE_REVERB_*`. Set `BROADCAST_DRIVER=reverb` in environment variables.

### 5.4 Cache (optional but recommended)

- Add a **KV Store** (Redis) and attach it to the environment. Set `CACHE_STORE=redis` and `SESSION_DRIVER=redis` for better performance.

---

## 6. Environment variables

In **Settings → Environment variables** for your environment, configure:

| Variable | Purpose |
|----------|---------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | Your Cloud domain (e.g. `https://your-app.laravel.cloud`) or custom domain |
| `APP_KEY` | Generate with `php artisan key:generate --show` and set it |
| `DB_CONNECTION` | `mysql` (or `pgsql`) when using Cloud DB |
| `BROADCAST_DRIVER` | `reverb` if using WebSockets, else `log` or `null` |
| `FILESYSTEM_DISK` | Your Object Storage disk name (e.g. `s3`) — Cloud sets this when you attach a bucket |
| `SESSION_SECURE_COOKIE` | `true` for HTTPS |
| `CACHE_STORE` | `redis` if you use a KV store, else `database` |
| `SESSION_DRIVER` | `redis` if using KV store, else `database` |

**Note**: Cloud automatically injects `DB_*`, `AWS_*` / `FILESYSTEM_DISK`, and `REVERB_*` when you attach the database, bucket, and WebSockets. You only need to set overrides or add application-specific variables.

---

## 7. Build and deploy commands

### Build commands (Settings → Deployments)

Defaults usually include `composer install` and `npm run build`. Ensure you have something like:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Adjust if your Cloud environment uses different defaults.

### Deploy commands

Run **after** build, **before** going live:

```bash
php artisan migrate --force
```

**Do not** run:

- `php artisan storage:link` — use Object Storage instead.
- `php artisan queue:restart` — Cloud manages queue workers.
- `php artisan optimize:clear` — avoid clearing caches right before deploy.

---

## 8. Deploy

1. **Trigger deploy**: **Deploy** button on the environment overview, or push to the connected branch (if push-to-deploy is enabled).
2. **First deploy**: Run `php artisan migrate --force` via deploy commands (or manually in **Commands** once) so the DB is ready.
3. After a successful deploy, open your app URL (Cloud or custom domain).

---

## 9. Post-deploy checks

- [ ] App loads without 500 errors.
- [ ] Login / registration works.
- [ ] Database-backed features (courses, exercises, exams, users) work.
- [ ] File uploads (avatars, courses, exercises, exams, attachments) work and URLs load (if using a public bucket).
- [ ] If WebSockets are used: open the messages/chat page and confirm real-time updates.

---

## 10. Troubleshooting

| Issue | What to check |
|-------|----------------|
| **Database connection errors** | `DB_CONNECTION`, `DB_*` in env; database attached to the environment. |
| **Files not found / upload fails** | Object Storage bucket attached; `FILESYSTEM_DISK` set to bucket disk; `league/flysystem-aws-s3-v3` installed. |
| **WebSockets / Reverb not working** | WebSocket cluster attached; `BROADCAST_DRIVER=reverb`; `REVERB_*` injected; frontend uses Reverb config when `REVERB_APP_KEY` is set. |
| **`laravel/framework` version not supported** | Run `composer update laravel/framework` and use a [supported version](https://cloud.laravel.com/docs/deployments#laravel-framework-version-not-supported). |
| **Build timeout** | Simplify build steps or run fewer heavy operations; ensure `npm run build` completes. |

---

## 11. Local development after these changes

- Set `FILESYSTEM_DISK=public` and run `php artisan storage:link` so `storage/app/public` is linked to `public/storage`.
- For real-time messages locally, either use **Pusher** (`BROADCAST_DRIVER=pusher`, set `PUSHER_*`) or run **Reverb** (`php artisan reverb:start`) and set `BROADCAST_DRIVER=reverb` with `REVERB_*`.

---

## 12. Useful links

- [Laravel Cloud Quickstart](https://cloud.laravel.com/docs/quickstart)
- [Laravel Cloud Deployments](https://cloud.laravel.com/docs/deployments)
- [Laravel Cloud Databases](https://cloud.laravel.com/docs/resources/databases)
- [Laravel Cloud Object Storage](https://cloud.laravel.com/docs/resources/object-storage)
- [Laravel Cloud WebSockets (Reverb)](https://cloud.laravel.com/docs/resources/websockets)
