# PHP ID3 Tag Modifier

PHP ID3 Tag Modifier (PITM) is a small app that allows you to :
* List all .mp3 files of a given directory (and sub-directories)
* Rename (and move) them to another one
    * You can do each file at a time using an AJAX request
    * You can do a batch move of all the files in the directory
* Manually edit the common ID3 tags of each file with suggestions given

## Current features
### Renaming / Moving files
* List all .mp3 files found recursively in a given directory
* Use the web interface to :
    * Change the name of the file
    * Move them in another directory
    * Delete them (actually move the file to a user-specified "trash" directory)
    * PITM can automatically suggest a better name for the file (most of the time)

### Editing ID3 tags
* Display major ID3 tags of the files in a directory and change them using the given suggestions

## Upcoming features
* Adding a menu to navigate more easily
* Improve suggestions
* Improve the code and add a config file for an easier setup
* Add other search engines (Discogs)
* Improve album detection

## Changelog
### v0.1 (current)
* Added a page to rename and move files between two directories
* Added a page to analyze all files in a directory and edit their ID3 tags
* Added some suggestions for the file name and tags

## Setup
1. Install Laravel 5.3
2. Clone the project
3. Set up the .env file (copy the .env.example in the project)
    * Generate an app key with `php artisan key:generate`
4. Do a `composer update`
    * You may have to change the APP_KEY in `config/app.php`
5. Find the `app/Http/Controllers/RenameController.php` and change the following constants
    * `ROOTDIR` to match the path of the directory you want to scan
    * `DESTDIR` to match the path of the directory you want to move the .mp3 files to
    * `TRASHDIR` to match the path of the directory you want to move the deleted .mp3 files to
6. Find the `app/Http/Controllers/EditTagController.php` and change the following constant
    * `SAMPLEDIR` to match the path of the directory you want to scan for modifying the ID3 tags