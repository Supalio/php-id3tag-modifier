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
            $this->suggested_tags = app('suggester')->get_suggested_info($this);
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

        // Get all the common tags
        if (isset($fileInfo['tags_html'])) {
            $this->tags = $fileInfo['tags_html']['id3v2'];
        }
        // Adding the cover art if it is available
        if (isset($fileInfo['comments']['picture'])) {
            $this->tags['image'] = $fileInfo['comments']['picture'][0];
        }
    }

    /**
     * Write the given tags in the file
     *
     * @param array $tags
     * @return array
     */
    public function write_tags(array $tags) {
        $textEncoding = 'UTF-8';
        $getID3 = new \getID3;
        $getID3->setOption(array('encoding' => $textEncoding));

        $tagwriter = new  \getid3_writetags;
        $tagwriter->filename = $this->path;
        $tagwriter->tagformats = array('id3v2.3');

        // set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $textEncoding;
        $tagwriter->remove_other_tags = true;

        $fileInfo = $getID3->analyze($this->path);

        //XXX This will remove all tags
        // \getid3_lib::CopyTagsToComments($fileInfo);
        // foreach ($fileInfo['tags']['id3v2'] as $key => $value) {
        //     $tagData[$key] = $value;
        // }

        // populate data array
        $tagData['comment'] = array();
        foreach ($tags as $tag => $value) {
            $tagData[$tag] = array($value);
        }

        if (!empty($fileInfo['comments']['picture'])) {
            $tagData['attached_picture'][0]['picturetypeid'] = 3;
            $tagData['attached_picture'][0]['description']   = 'Cover';
            $tagData['attached_picture'][0]['data'] = $fileInfo['comments']['picture'][0]['data'];
            $tagData['attached_picture'][0]['mime'] = $fileInfo['comments']['picture'][0]['image_mime'];
        }

        $tagwriter->tag_data = $tagData;

        // write tags
        $tagwriter->WriteTags();

        return array(
            'warnings' => $tagwriter->warnings,
            'errors'   => $tagwriter->errors
        );
    }

    /**
     * Generate a search link using the tags
     *
     * @param string
     * @return string
     */
    private function get_search_link_with_tags(string $searchEngine) {
        switch ($searchEngine) {
        case 'Beatport':
        case 'Beatport Classic':
            $link = ($searchEngine === 'Beatport') ? 'https://www.beatport.com/search?q=' : 'http://classic.beatport.com/search?query=';
            if (isset($this->suggested_tags['band'])) {
                $link .= strtolower($this->suggested_tags['band'][0]);
            } else {
                $link .= strtolower($this->suggested_tags['artist'][0]);
            }
            if (isset($this->suggested_tags['album'])) {
                $link .= '+' . strtolower($this->suggested_tags['album'][0]);
            } else {
                $link .= '+' . strtolower($this->suggested_tags['title'][0]);
            }
            $link = str_replace(' ', '+', $link);
            $link = str_replace('&', '%26', $link);
            break;
        default:
            $link = '#';
        }

        return $link;
    }

    public function get_search_link(string $searchEngine) {
        return $this->get_search_link_with_tags($searchEngine);
    }

}
