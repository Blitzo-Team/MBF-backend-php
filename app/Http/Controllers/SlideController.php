<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function create_or_update(Request $request, \App\Slide $slide, $is_new=false) {
        
        $validator_arr = [
          
        ];

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        // actual creation
        $slide->fill(
            // TODO
            $request->only([])
        );

        // TODO: fill up other non-required fields
        $slide->is_special = request('is_special', false);

        // TODO: save
        \DB::beginTransaction();
        try {
            if ($is_new) {
            }
            else {
            }
        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        $slide = \App\slide::where('id', '=' , $slide->id)->first();
        $slide = $this->enrich($slide);
        return response()->json(array('slide' => $slide, 'result' => $result));
     
    }
}
