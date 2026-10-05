# Laravel Boost Guidelines

## Foundational Context
This application is a Laravel 13 application running on PHP 8.5. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

Application purpose: Official website and CMS for Kijura Town Council — a local government public information portal with news, projects, tenders, vacancies, documents, gallery, citizen feedback, and a role-based admin CMS.

## Conventions
- Follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods.
- Check for existing components to reuse before writing a new one.

## Application Structure & Architecture
- Backend: Laravel 13, PHP 8.5, MySQL via WAMP (wampmysqld64 service).
- Frontend: Bootstrap 5, vanilla JS, Blade templates — no Inertia/Livewire/React.
- CMS admin lives under the `admin` route prefix with its own Blade layout.
- Public site uses a separate public layout.
- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Running Commands
- PHP binary: `C:\Users\User\.config\herd-lite\bin\php.exe`
- Composer: `C:\Users\User\.config\herd-lite\bin\composer.bat`
- Artisan: `php artisan <command>` (once PATH is set) or use full path.
- To set PATH in PowerShell before running commands: `$env:PATH = "C:\Users\User\.config\herd-lite\bin;" + $env:PATH`
- MySQL: Start via `Start-Service wampmysqld64` (requires admin), or use WAMP tray.
- The database is `kijura_council` on 127.0.0.1:3306, user `root`, no password.

## Do Things the Laravel Way
- Use `php artisan make:` commands to create new files (migrations, controllers, models, etc.).
- Pass `--no-interaction` to all Artisan commands.
- This project uses the streamlined Laravel 11+ structure: register middleware, exceptions, and routing in `bootstrap/app.php` and service providers in `bootstrap/providers.php`. There is no `app/Http/Kernel.php`. Commands in `app/Console/Commands/` auto-register.

## Database
- When modifying a column, the migration must include all attributes previously defined on the column.
- Models use the `casts()` method rather than a `$casts` property.

## APIs & URL Generation
- Prefer named routes and the `route()` function when generating links.

## Frontend Bundling
- Frontend assets are compiled with Vite (`npm run build` or `npm run dev`).
- If a frontend change doesn't show, run `npm run build`.

## Documentation Files
- Only create documentation files if explicitly requested by the user.
