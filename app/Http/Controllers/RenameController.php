<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Http\Requests;
use App\DirReader;

class RenameController extends Controller {

    public function index() {
        $dir_reader = new DirReader('J:\\Save\\Downloads\\_musique\\_move');
        $files = $dir_reader->get_files();

        return view('rename', compact('files'));
    }

    public function move() {

    }

}
