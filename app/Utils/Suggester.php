<?php

namespace App\Utils;

use App\File;

class Suggester {

    public function get_suggested_name(File $file) {
        $name = $this->get_clean_name($file->get_name());

        $allowedLetters = '[a-z0-9&.$@,!?\'_\[\]\.\s-]';
        $regex = '/^(' . $allowedLetters . '+)\s*-\s*(' . $allowedLetters . '+)\s*\((' . $allowedLetters . '+)\)*(' . $allowedLetters . '+)*$/i';

        if (preg_match($regex, $name, $result)) {
            $artist = trim($result[1]);
            $title = trim($result[2]);
            $remix = trim($result[3]);
            $name = ucwords($artist) . ' - ' . ucwords($title) . ' (' . ucwords($remix) . ')';
        }

        return $name;
    }

    private function get_clean_name(String $name) {
        $name = preg_replace('/^[0-9]+[-_]?/', '', $name); //Remove track
        $name = preg_replace('/_+/', ' ', $name); //Remove _ from the name of the file
        $name = preg_replace('/-+/', '-', $name); //Remove multiple -
        $name = preg_replace('/\[.*\]/', '', $name); //Remove label name between []
        $name = trim($name); //Trim the name to be sure

        return $name;
    }

}