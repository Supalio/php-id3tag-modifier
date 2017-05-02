<?php

namespace App\Utils;

use App\File;

class Suggester {

    /**
     * Suggest basic information for a file using its current name
     *
     * @param App\File
     * @return array
     */
    public function get_suggested_info_from_name(File $file) {
        $name = $this->get_clean_name($file->get_name());

        if (preg_match($this->get_regex(true), $name, $result) ||
            preg_match($this->get_regex(false), $name, $result)
        ) {
            $artist = $this->format_artist($result['artist']);
            $title = $this->format_title($result['title']);
            $mix = isset($result['mix']) ? $this->format_mix($result['mix']) : 'Original Mix';
        }

        return array(
            'artist' => $artist,
            'title' => $title,
            'mix' => $mix,
        );
    }

    /**
     * Suggest a name for a file using its current name
     *
     * @param App\File
     * @return string
     */
    public function get_suggested_name(File $file) {
        $info = $this->get_suggested_info_from_name($file);
        $name = $info['artist'] . ' - ' . $info['title'] . ' (' . $info['mix'] . ')';
        return $name;
    }

    /**
     * Suggest info from the current value of the tags and the name of the file
     *
     * @param App\File
     * @return array
     */
    public function get_suggested_info(File $file) {
        $suggestedFromName = $this->get_suggested_info_from_name($file);
        $suggestedFromName['title'] .= ' (' . $suggestedFromName['mix'] . ')'; //Add the mix to the title
        $suggestedFromName['band'] = array($suggestedFromName['artist']); //Assume the album artist is the same as the artist of the track
        unset($suggestedFromName['mix']);

        $suggestedFromTags = $this->get_suggested_info_from_tags($file);

        return array_merge_recursive($suggestedFromName, $suggestedFromTags);
    }

    /**
     * Suggest some tags for a file using already exsiting tags
     *
     * @param App\File
     * @return array
     */
    private function get_suggested_info_from_tags(File $file) {
        $tags = $file->get_tags();
        $suggestedTags = array();

        //Artist
        if (isset($tags['artist'])) {
            $suggestedTags['artist'] = array_map(array(get_class($this), 'format_artist'), $tags['artist']);
        }

        //Album Artist
        if (isset($tags['band'])) {
            $suggestedTags['band'] = array_map(array(get_class($this), 'format_artist'), $tags['band']);
        }

        //Title
        if (isset($tags['title'])) {
            $suggestedTags['title'] = array_map(array(get_class($this), 'format_title'), $tags['title']);
        }

        //Album
        if (isset($tags['album'])) {
            $suggestedTags['album'] = array_map(array(get_class($this), 'format_album'), $tags['album']);
        }

        //Label
        if (isset($tags['publisher'])) {
            $suggestedTags['publisher'] = $tags['publisher'];
            $suggestedTags['content_group_description'] = $tags['publisher'];
        }

        //Track #
        if (isset($tags['track_number'])) {
            $track_numbers = explode('/', $tags['track_number'][0]);
            $suggestedTags['track_number'] = array(intval($track_numbers[0]));
            if (isset($track_numbers[1])) {
                $suggestedTags['track_number'][] = intval($track_numbers[1]);
            }

        }

        //BPM
        if (isset($tags['bpm'])) {
            $suggestedTags['bpm'] = ($tags['bpm'][0] === '93') ? array('140') : array(round($tags['bpm'][0]));
        }

        //Genre
        if (isset($tags['genre'])) {
            $suggestedTags['genre'] = array_map(function (string $genre) {
                $genre = str_replace('Chillout', 'Chill Out', $genre);
                $genre = preg_replace('/^(Tech|Uplifting|Progressive|Vocal|Dance -) Trance$/i', 'Trance', $genre);
                $genre = str_replace('Psychedelic', 'Psy-Trance', $genre);
                return $genre;
            }, $tags['genre']);
        }

        return $suggestedTags;
    }

    /**
     * Format an artist name by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_artist(string $artist) {
        $artist = ucwords(trim($artist));
        $artist = preg_replace('/(\bft\b\.?)|(\bfeat\b\.?)|(featuring)/i', 'feat.', $artist); //Correct the feat
        $artist = preg_replace('/(\bvs\b\.?)/i', 'vs.', $artist); //Correct the vs.
        $artist = preg_replace('/(\bpres\b\.?)/i', 'pres.', $artist); //Correct the pres.
        $artist = preg_replace('/\band\b/i', '&', $artist); //Correct the and
        $artist = preg_replace('/\bwith\b/i', 'with', $artist); //Correct the with

        return $artist;
    }

    /**
     * Format the title by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_title(string $title) {
        return mb_convert_case(trim($title), MB_CASE_TITLE);
    }

    /**
     * Format the album by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_album(string $album) {
        $album = mb_convert_case(trim($album), MB_CASE_TITLE);
        $album = preg_replace('/\bep\b/i', 'EP', $album);
        return $album;
    }

    /**
     * Format the mix name by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_mix(string $mix) {
        $mix = ucwords(trim($mix));
        $mix = preg_replace('/(\bft\b\.?)|(\bfeat\b\.?)|(featuring)/i', 'feat.', $mix); //Correct the feat
        $mix = preg_replace('/(\bvs\b\.?)/i', 'vs.', $mix); //Correct the vs.
        $mix = preg_replace('/(\bpres\b\.?)/i', 'pres.', $mix); //Correct the pres.
        $mix = preg_replace('/\band\b/i', '&', $mix); //Correct the and
        $mix = preg_replace('/\bwith\b/i', 'with', $mix); //Correct the with
        $mix = preg_replace('/\brmx\b/i', 'Remix', $mix); //Correct the remix

        return $mix;
    }

    /**
     * Get a cleaner filename by doing some common replacements
     *
     * @param string
     * @return string
     */
    private function get_clean_name(string $name) {
        $name = preg_replace('/^[0-9]+[-_.\s]/', '', $name); //Remove track number
        $name = preg_replace('/_+/', ' ', $name); //Remove multiple _
        $name = preg_replace('/-+/', '-', $name); //Remove multiple -
        $name = preg_replace('/\[.*\]/', '', $name); //Remove label name between []
        $name = trim($name); //Trim the name to be sure

        return $name;
    }

    private function get_regex(bool $includeMix) {
        $allowedLetters = '[a-z0-9&.$@,!?\'_\[\]\.\s()-]';
        $regex = '/^'; //start
        $regex .= '(?<label>[a-z]+[0-9]+[A-Z]?)?'; //get the label in front of the track name
        $regex .= '(?<artist>' . $allowedLetters . '+)'; //get the artist name
        $regex .= '\s*-\s*'; //assumed separation of artist and title
        $regex .= '(?<title>' . $allowedLetters . '+)'; //get the title
        $regex .= '\s*'; //assumed separation of title and mix
        $regex .= ($includeMix) ? '\((?<mix>' . $allowedLetters . '+)\)' : ''; //get the mix
        $regex .= '(?<other>.+)*'; // get the rest
        $regex .= '$/i'; // end
        ;

        return $regex;
    }

}