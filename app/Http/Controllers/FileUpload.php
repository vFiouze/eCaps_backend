<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class FileUpload extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . $file->getClientOriginalName();
            $tmp = $request->image->storeAs('uploads', $fileName, 'public');
            //save the document
            $document = new Document();
            $document->name = "/opt/homebrew/var/www/eCaps/storage/app/public/$tmp";
            $document->save();
            $cmd = "tesseract /opt/homebrew/var/www/eCaps/storage/app/public/$tmp - tsv stdout";
            $process = Process::fromShellCommandline($cmd);
            $process->run();
            $res = [
                'ocr' => $process->getOutput(),
                'documentId' => $document->id
            ] ;
            return response()->json($res);
        }
    }
}
