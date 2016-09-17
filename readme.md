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

## Upcoming features
* Adding a page to display information about ID3 tags of the files in a directory and change them

## Setup
1. Install Laravel 5.3
2. Clone the project
3. Do a `composer update`
    * You may have to change the APP_KEY in `config/app.php`
4. Find the `app/Http/Controllers/RenameController.php` and change the following constants
    * `ROOTDIR` to match the path of the directory you want to scan
    * `DESTDIR` to match the path of the directory you want to move the .mp3 files to
    * `TRASHDIR` to match the path of the directory you want to move the deleted .mp3 files to