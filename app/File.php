<?php

namespace App;

class File {

    /**
     * The full path
     *
     * @var string
     */
    private $path;

    /**
     * The name of the file
     *
     * @var string
     */
    private $name;

    /**
     * Create a new File
     *
     * @param string $filePath
     * @return void
     */
    public function __construct(string $filePath) {
        $this->path = $filePath;
        $this->name = basename($filePath, '.mp3');
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
