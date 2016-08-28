<?php

namespace App;

class File {

    /**
     * The full path
     *
     * @var string
     */
    protected $path;

    /**
     * The name of the file
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new File
     *
     * @param string $filepath
     * @return void
     */
    public function __construct(string $filepath) {
        $this->path = $filepath;
        $this->name = basename($filepath, '.mp3');
    }

    /**
     * Get the full path of the file
     *
     * @return string
     */
    public function get_full_path() {
        return $this->path;
    }

    /**
     * Get the name of the file
     *
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Move the file to a new directory and rename it
     *
     * @param string $destinationDir
     * @param string $name
     * @return boolean
     */
    public function rename_file(string $destinationDir, string $name) {
        return rename($this->path, $destinationDir . '\\' . $name . '.mp3');
    }

}
