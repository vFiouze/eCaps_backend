<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Flight;
use App\Models\SelectedBlock;

class SaveBlocks extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) {
        $content = $request->all();
        $documentId = $content["documentId"];
        $blocks = json_decode($content["selectedBlocks"]);
        foreach ($blocks as $step => $blocksForStep) {
            foreach ($blocksForStep as $blockInfo) {
                $selectedblocks = new SelectedBlock;
                $selectedblocks->documentId = $documentId;
                $selectedblocks->step = $step;
                $selectedblocks->top = $blockInfo->topForBlock;
                $selectedblocks->left = $blockInfo->leftForBlock;
                $selectedblocks->width = $blockInfo->widthForBlock;
                $selectedblocks->height = $blockInfo->heightForBlock;
                try {
                    $selectedblocks->save();
                } catch (\Exception $e) {
                    return response($e->getMessage());
                }
                
            }
            
        }
        return response($documentId);
    }

    public function getSavedBlocks (Request $request) {
        $documentId = $request->documentId;
        $selectedBlocks = SelectedBlock::where('documentId', $documentId)->get();
        $res = [
            "selectedBlocks" => [],
        ];
        foreach ($selectedBlocks as $selectedBlock) {
            if (!array_key_exists($selectedBlock->step, $res['selectedBlocks'])) {
                $res['selectedBlocks'][$selectedBlock->step] = [];
            }
            $arrayToPush = [
                'topForBlock' => $selectedBlock->top,
                'leftForBlock' => $selectedBlock->left,
                'widthForBlock' => $selectedBlock->width,
                'heightForBlock' => $selectedBlock->height,
            ];
            array_push($res['selectedBlocks'][$selectedBlock->step], $arrayToPush);
            
        }
        return response()->json($res);
    }
}
