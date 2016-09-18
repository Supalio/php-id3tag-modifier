<?php

namespace App\Http\Controllers;

use App\DirReader;

class EditTagController extends Controller {
    const SAMPLEDIR = 'C:\\Users\\Alex\\Desktop\\Temp\\_sample';

    public function index() {
        $dirReader = new DirReader(self::SAMPLEDIR);
        $files = $dirReader->get_files(true); //Get the files and read their tags

        return view('list_tags', compact('files'));
    }
}
