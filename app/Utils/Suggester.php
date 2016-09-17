<?php

namespace App\Utils;

use App\File;

class Suggester {

    /**
     * Suggest a name for a file using its current name
     *
     * @param App\File
     * @return string
     */
    public function get_suggested_name(File $file) {
        $name = $this->get_clean_name($file->get_name());

        $allowedLetters = '[a-z0-9&.$@,!?\'_\[\]\.\s()-]';
        // $allowedLetters = '[.\w\s]';
        $regex = '/^' . //start
        '(?<label>[a-z]+[0-9]+)?' . //get the label in front of the track name
        '(?<artist>' . $allowedLetters . '+)' . //get the artist name
        '\s*-\s*' . //assumed separation of artist and title
        '(?<title>' . $allowedLetters . '+)' . //get the title
        '\s*' . //assumed separation of title and mix
        '\((?<mix>' . $allowedLetters . '+)\)' . //get the mix
        '(?<other>.+)*' . // get the rest
        '$/i' // end
        ;

        if (preg_match($regex, $name, $result)) {
            $artist = $this->format_artist($result['artist']);
            $title = $this->format_title($result['title']);
            $mix = $this->format_mix($result['mix']);
            $name = $artist . ' - ' . $title . ' (' . $mix . ')';
        }

        return $name;
    }

    /**
     * Format an artist name by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_artist(string $artist) {
        $artist = ucwords(trim($artist));
        $artist = preg_replace('/(ft\.?)|(feat\.?)/i', 'feat.', $artist); //Correct the feat
        $artist = preg_replace('/(vs\.?)/i', 'vs.', $artist); //Correct the vs.
        $artist = preg_replace('/(pres\.?)/i', 'pres.', $artist); //Correct the pres.
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
     * Format the mix name by doing common replacements
     *
     * @param string
     * @return string
     */
    private function format_mix(string $mix) {
        $mix = ucwords(trim($mix));
        $mix = preg_replace('/(ft\.?)|(feat\.?)/i', 'feat.', $mix); //Correct the feat
        $mix = preg_replace('/(vs\.?)/i', 'vs.', $mix); //Correct the vs.
        $mix = preg_replace('/(pres\.?)/i', 'pres.', $mix); //Correct the pres.
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
        $name = preg_replace('/^[0-9]+[-_.]?/', '', $name); //Remove track number
        $name = preg_replace('/_+/', ' ', $name); //Remove multiple _
        $name = preg_replace('/-+/', '-', $name); //Remove multiple -
        $name = preg_replace('/\[.*\]/', '', $name); //Remove label name between []
        $name = trim($name); //Trim the name to be sure

        return $name;
    }

}