<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Document;
use App\Models\SelectedBlock;

class DocumentController extends Controller {
    public function index(Request $request) {
        $documentId = intval($request->documentId);

        try {
            $document = Document::find($documentId);
            $content = file_get_contents($document->name);
            $base64 = base64_encode($content);
            return response()->file($document->name);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }
}
