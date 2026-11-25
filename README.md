# Laravel Ekatte

The project is a multilingual admin panel built with [Laravel 13](https://laravel.com/framework/docs/13.x/installation) and [Bootstrap 4](https://getbootstrap.com/docs/4.6/getting-started/introduction/).

Fully responsive design for all mobile devices and browsers.

## Setup

Clone the repository and follow the steps below.

1. Run `composer install`
2. Copy `.env.example` to `.env`
3. Run `php artisan key:generate` to generate application key
4. Set valid database credentials of env variables `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`
5. Run `php artisan migrate --seed` to run migrations and seed the database
6. Run `npm i` (Recommended node version `>= v26.13.0`)
7. Run `npm run dev` or `npm run prod` as per your environment

## Testing

The application includes Feature tests covering the EKATTE administrative hierarchy, multilingual translations, model relationships, user management, and role-based access control.

Run `php artisan test` to execute the full test suite.

Covered areas include:

### EKATTE administrative hierarchy

- Creation of regions, districts, municipalities, town halls, and settlements
- Creation of settlement kinds
- Hierarchical relationships between administrative entities
- Database integrity and foreign key relationships

### Multilingual translations

- Translation configuration validation
- Creation and persistence of translations for all configured locales (bg / en)
- Translation records associated with their respective models

### User management

- User creation and database persistence
- Password hashing verification
- Unverified user creation

### Roles and permissions

- Role and permission creation
- Multilingual permission display names
- Assigning permissions to roles
- Assigning roles and permissions directly to users
- Inherited permissions through assigned roles

## Demo Credentials

### Admin Login

- **Email:** admin@example.com
- **Password:** qwerty

### Manager Login

- **Email:** manager@example.com
- **Password:** qwerty

### User Login

- **Email:** user@example.com
- **Password:** qwerty

## Credits & References

The following software libraries and other references are utilized in the creation this project.

- [Laravel](https://github.com/laravel/laravel)
- [Laravel UI](https://github.com/laravel/ui)
- [Astrotomic Laravel Translatable](https://github.com/Astrotomic/laravel-translatable)
- [Marc Cámara Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Spatie Laravel Activity Log](https://github.com/spatie/laravel-activitylog)
- [Spatie Laravel Roles & Permissions](https://github.com/spatie/laravel-permission)
- [Yajra Laravel Datatables](https://github.com/yajra/laravel-datatables)
- [Spartner Laravel Excel](https://github.com/SpartnerNL/Laravel-Excel)
- [Soft Delete & Restore](https://codeanddeploy.com/blog/laravel/complete-laravel-8-soft-delete-restore-deleted-records-tutorial)
- [Custom Method Addition to Resource Controllers in Laravel](https://copyprogramming.com/howto/laravel-add-custom-method-to-resource-controller)
- [Service Repository Pattern](https://dev.to/safventure11000/implement-crud-with-laravel-service-repository-pattern-1dkl)
- [Bootstrap](https://getbootstrap.com/)
- [jQuery](https://jquery.com/)
- [UX Solutions Bootstrap Datepicker](https://github.com/uxsolutions/bootstrap-datepicker)
- [Sebastien MALOT Bootstrap Datetimepicker](https://github.com/smalot/bootstrap-datetimepicker)
- [DataTables](https://github.com/DataTables/Dist-DataTables-Bootstrap4)
- [Select2](https://github.com/select2/select2)
- [SweetAlert2](https://github.com/sweetalert2/sweetalert2)

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Screenshots

### List Settlements

![Screenshot](screenshots/settlements.png)

### List Town halls

![Screenshot](screenshots/town-halls.png)

### List Municipalities

![Screenshot](screenshots/municipalities.png)

### List Districts

![Screenshot](screenshots/districts.png)

### List Regions

![Screenshot](screenshots/regions.png)

### List Activity Logs

![Screenshot](screenshots/activity-logs.png)

### List Users

![Screenshot](screenshots/users.png)

### List Deleted Users

![Screenshot](screenshots/deleted-users.png)

### List Roles

![Screenshot](screenshots/roles.png)

### List Permissions

![Screenshot](screenshots/permissions.png)

### Profile

![Screenshot](screenshots/profile.png)

### Profile - Update Password

![Screenshot](screenshots/profile-update-password.png)

### Profile - Delete Account

![Screenshot](screenshots/profile-delete-account.png)
