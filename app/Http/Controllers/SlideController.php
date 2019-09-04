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
        
        // $validator_arr = [
          
        // ];

        // $validator = Validator::make($request->all(), $validator_arr);

        // if ($validator->fails()) {
        //     return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        // }

        // actual creation
        $data = $request->only('slides')['slides'];
       
        foreach($data as $row) {
            $slide = new \App\Slide();
            $slide->file_type = $row['file_type'];
            $slide->file_location = $row['file_location'];
            $slide->file_name = $row['file_name'];
            $slide->file_text = $row['file_text'];

            $slide->save();
        }
        
        \DB::beginTransaction();
        try {
            if ($is_new) {
                $slide->save();
            }
            else {
                $slide->save();
            }
        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
      
        return response()->json(array('slide' => $data));
     
    }

    public function create(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return $this->create_or_update($request, new \App\Slide(), true);
    }

    
}
