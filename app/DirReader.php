<?php

namespace App;

class DirReader {

    /**
     * The path of the directory to read
     *
     * @var string
     */
    private $directory;

    /**
     * The eligible files inside the directory
     *
     * @var array
     */
    private $files;

    /**
     * Create a new directory reader
     *
     * @param string $dir
     * @return void
     */
    public function __construct(string $dir) {
        $this->directory = $dir;
    }

    /**
     * Get the path of the directory to read
     *
     * @return string
     */
    public function get_directory() {
        return $this->directory;
    }

    /**
     * Get all the eligible files in the directory
     *
     * @param bool
     * @return array
     */
    public function get_files(bool $fetchTags = false) {
        $this->set_top_level_files($this->directory, $fetchTags);

        return $this->files;
    }

    /**
     * Set all the top level files of a given directory (excluding sub-directories)
     *
     * @param string $directroy
     * @param bool $fetchTags
     * @return void
     */
    private function set_top_level_files(string $directory, bool $fetchTags = false) {
        if ($handle = opendir($directory)) {

            while (($fileName = readdir($handle)) !== false) {

                if (preg_match('/mp3$/', $fileName)) {
                    //If the file is an MP3, we can add it
                    $this->files[] = new File($this->get_full_path($directory, $fileName), $fetchTags);
                } else if ($fileName !== '.' && $fileName !== '..' && is_dir($this->get_full_path($directory, $fileName))) {
                    //If the file is a subdirectory we explore the files inside
                    $this->set_top_level_files($this->get_full_path($directory, $fileName));
                }

            }

        }
    }

    /**
     * Get the full path of a path (full or not)
     *
     * @param string $currentDirectory
     * @param string $fileName
     * @return string
     */
    private function get_full_path($currentDirectory, $fileName) {
        return preg_match('/^[A-Z]:/', $fileName) ? $fileName : $currentDirectory . '\\' . $fileName;
    }

}
