<?php

namespace App\Http\Controllers;

use App\DirReader;

// use App\Http\Requests;
use App\File;
use Illuminate\Http\Request;

class RenameController extends Controller {

    const ROOTDIR = 'J:\\Save\\Downloads\\_musique\\_move';
    const DESTDIR = 'C:\\Users\\Alex\\Desktop\\Temp';

    public function index() {
        $dir_reader = new DirReader(self::ROOTDIR);
        $files = $dir_reader->get_files();

        return view('rename', compact('files'));
    }

    public function move(Request $request) {
        $file = new File($request->filepath);
        $file->rename_file(self::ROOTDIR, $request->title);

        return back();
    }

}
