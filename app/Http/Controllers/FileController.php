<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected $slugify;
    public function __construct() {
        parent::__construct();
        $this->slugify = new Slugify();
    }

    public function upload_file(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        
        $date = Carbon::now();
        $location = request()->file('file')->storeAs('uploads/' . $date->toDateString() ,
                    $this->slugify->slugify(request()->file('file')->getClientOriginalName())
                    .  '.' . request()->file('file')->getClientOriginalExtension()
                );
                       
        return response()->json(array('file_location' => $location, 
                                      'file_name' => request()->file('file')->getClientOriginalName(),
                                      'file_type' => request()->file('file')->getClientOriginalExtension()
                                ));
    }

    public function read_file(Request $request) {
        $validator = Validator::make($request->all(), [
            'location' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'validation failed',
                'messages' => $validator->errors()->all()], 404);
        }
        return response()->download(storage_path('app/' . request('location')));
    }
}
