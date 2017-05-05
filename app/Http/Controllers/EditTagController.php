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
    public function tagFiles(Request $request) {
        $filesTagged = 0;
        $filesInError = 0;


        foreach ($request->filepath as $key => $filepath) {
            
            $tags = array(
                'artist'       => $request->artist[$key],
                'title'        => $request->title[$key],
                'album'        => $request->album[$key],
                'band'         => $request->band[$key],
                'publisher'    => $request->publisher[$key],
                'genre'        => $request->genre[$key],
                'year'         => $request->year[$key],
                'track_number' => $request->track_number[$key],
                'bpm'          => $request->bpm[$key],
                'initial_key'  => $request->initial_key[$key],
            );

            $file = new File($filepath);
            $result = $file->write_tags($tags);
            if ($result) {
                $filesTagged++;
            } else {
                $filesInError++;
            }
        }

        session()->flash('files_tagged', $filesTagged);
        session()->flash('files_in_error', $filesInError);

        return back();
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
