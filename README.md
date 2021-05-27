# Laravel S3 File Migration
[![Build Status](https://travis-ci.org/robbfountain/laravel-s3-migrate.svg?branch=master)](https://travis-ci.org/robbfountain/laravel-s3-migrate) [![StyleCI](https://github.styleci.io/repos/255435601/shield?branch=master)](https://github.styleci.io/repos/255435601)

Migrate files in local storage to an AWS S3 Bucket

## Installation
Install with composer
```bash
composer require onethirtyone/laravel-s3-migrate
```

Publish the config
```bash
php artisan vendor:publish --tag=s3migrate-config
```

## Usage
in `config/s3migrate.php` set your configuration options

Run the artisan command
```bash
php artisan onethirtyone:s3-migrate {--force : Migrates without confirmation prompt}
```
This will migrate all files in your selected local disks to S3.  

When the migration is complete a `OneThirtyOne\S3Migration\Events\S3MigrationCompleted` event will be fired. The event will receive a collection of `Illuminate\Support\File` files. These are the files that have been migrated.

You should listen for this event to perform actions locally such as updating a database table with the new S3 image path or delete the local storage files.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
