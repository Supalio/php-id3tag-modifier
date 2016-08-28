<?php

namespace App\Http\Controllers;

use App\DirReader;

// use App\Http\Requests;
use App\File;
use Illuminate\Http\Request;

class RenameController extends Controller {

    const ROOTDIR = 'J:\\Save\\Downloads\\_musique\\_move';
    const DESTDIR = 'C:\\Users\\Alex\\Desktop\\Temp';
    const TRASHDIR = 'C:\\Users\\Alex\\Desktop\\Temp\\_delete';

    public function index() {
        $dir_reader = new DirReader(self::ROOTDIR);
        $files = $dir_reader->get_files();

        return view('rename', compact('files'));
    }

    /**
     * @param Request $request
     */
    public function moveFiles(Request $request) {
        $filesMoved = 0;
        $filesInError = 0;

        foreach ($request->filepath as $key => $filepath) {
            $file = new File($filepath);
            $result = $file->rename_file(self::ROOTDIR, $request->title[$key]);
            if ($result) {
                $filesMoved++;
            } else {
                $filesInError++;
            }

        }

        session()->flash('files_moved', $filesMoved);
        session()->flash('files_in_error', $filesInError);

        return back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function moveFile(Request $request) {
        $file = new File($request->filepath);
        $result = $file->rename_file(self::ROOTDIR, $request->title);

        return [
            'result' => $result,
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function delete(Request $request) {
        $file = new File($request->filepath);
        $result = $file->rename_file(self::TRASHDIR, $file->get_name());

        return [
            'result' => $result,
        ];
    }

}
