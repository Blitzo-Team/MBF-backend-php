<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;

class BreakfastController extends Controller
{
    public function create_or_update(Request $request, \App\Breakfast $breakfast, $is_new=false) {

        $data = $request->only('breakfast')['breakfast'];
    
        \DB::beginTransaction();
            try {
                if ($is_new) {

                    foreach($data as $row) {
                        $breakfast = new \App\Breakfast();

                        $breakfast->file_type = $row['file_type'];
                        $breakfast->file_location = $row['file_location'];
                        $breakfast->file_name = $row['file_name'];

                        $breakfast->calories = $row['cal'];
                        $breakfast->carb = $row['carb'];
                        $breakfast->fat = $row['fat'];

                        $breakfast->protein = $row['pro'];
                        $breakfast->grams = $row['grams'];
                        $breakfast->food_name = json_encode( $row['title']);
                        $breakfast->status = "custom";
                        $breakfast->save();
                    }
                }
                else {
                }
            }
            catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
        \DB::commit();

        // $breakfast = \App\Breakfast::where('id', '=' , $breakfast->id)->first();
        // $breakfast = $this->enrich($breakfast);
        return response()->json(array('data' => $breakfast));
        // response
    }

    public function create(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return $this->create_or_update($request, new \App\Breakfast(), true);
    }

    public function read(Request $request, \App\Breakfast $breakfast) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return response()->json($breakfast);
    }

    public function update(Request $request, \App\Breakfast $breakfast) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return $this->create_or_update($request, $breakfast);
    }

    public function list(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $query = \DB::table('breakfast');
        $query = $query->select('*');
        
        // filtering
        $ALLOWED_FILTERS = [];
        $SEARCH_FIELDS = [];
        $JSON_FIELDS = [];
        $BOOL_FIELDS = [];
        $result = $this->paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS, $BOOL_FIELDS, $SEARCH_FIELDS);
        return response()->json($result);
    }

}
