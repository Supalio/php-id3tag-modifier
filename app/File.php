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
     * The tag written in the file
     *
     * @var array
     */
    private $tags;

    /**
     * Some suggested tags
     *
     * @var array
     */
    private $suggested_tags;

    /**
     * Create a new File
     *
     * @param string $filepath
     * @return void
     */
    public function __construct(string $filepath, bool $fetchTags = false) {
        $this->path = $filepath;
        $this->name = basename($filepath, '.mp3');
        $this->tags = array();
        $this->suggested_tags = array();
        if ($fetchTags) {
            $this->fetch_tags();
            $this->suggested_tags = app('suggester')->get_suggested_info_from_tags($this);
        }
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
     * Get the tags of the file
     *
     * @return @array
     */
    public function get_tags() {
        return $this->tags;
    }

    /**
     * Get the suggested tags
     *
     * @return @array
     */
    public function get_suggested_tags() {
        return $this->suggested_tags;
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

    /**
     * Analyze the file to read the tags and store them
     *
     * @return void
     */
    public function fetch_tags() {
        $getID3 = new \getID3;
        $fileInfo = $getID3->analyze($this->path);

        $this->tags = $fileInfo['tags_html']['id3v2'];
        if (isset($fileInfo['comments']['picture'])) {
            $this->tags['image'] = $fileInfo['comments']['picture'][0];
        }
    }

}
