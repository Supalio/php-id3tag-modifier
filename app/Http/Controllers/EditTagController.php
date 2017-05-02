<?php

namespace App\Http\Controllers;

use App\DirReader;
use App\File;
use Illuminate\Http\Request;

class EditTagController extends Controller {
    const SAMPLEDIR = 'C:\\Users\\Alex\\Desktop\\Temp\\_sample';

    public function index() {
        $dirReader = new DirReader(self::SAMPLEDIR);
        $files = $dirReader->get_files(true); //Get the files and read their tags

        return view('list_tags', compact('files'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function tagFile(Request $request) {
        $file = new File($request->filepath);
        $result = $file->write_tags($request->tags);

        return [
            'result' => $result,
        ];
    }
}
