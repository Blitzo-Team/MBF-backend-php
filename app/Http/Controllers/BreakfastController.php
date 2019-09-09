<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;

class BreakfastController extends Controller
{
    public function create_or_update(Request $request, \App\Breakfast $breakfast, $is_new=false) {

        // $data = $request->only('breakfast')['breakfast'];

        $validator_arr = [
            // TODO
        ];

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        // actual creation

        $breakfast->file_type = request('file_type');
        $breakfast->file_location = request('file_location');
        $breakfast->file_name = request('file_name');

        $breakfast->calories = request('calories');
        $breakfast->calories_gram = request('calories_gram');

        $breakfast->protein = request('protein');
        $breakfast->protein_gram = request('protein_gram');

        $breakfast->carbohydrate = request('carbohydrate');
        $breakfast->carbohydrate_gram = request('carbohydrate_gram');
        
        $breakfast->sugar = request('sugar');
        $breakfast->sugar_gram =  request('sugar_gram');

        $breakfast->fat = request('fat');
        $breakfast->fat_gram =  request('fat_gram');

        $breakfast->saturated_fat = request('saturated_fat');
        $breakfast->saturated_fa_gram = request('saturated_fa_gram');

        $breakfast->sodium = request('sodium');
        $breakfast->sodium_gram = request('sodium_gram');

        $breakfast->name = request('name');
        $breakfast->description = request('description');
        $breakfast->weight = request('weight');
        $breakfast->category = request('category');
        $breakfast->price = request('price');
  
        $breakfast->filter = request('filter');
        $breakfast->ingredients =  json_encode(request('ingredients'));
        $breakfast->size =  request('size');
        $breakfast->status = 1;

        \DB::beginTransaction();
            try {
                if ($is_new) {
                    $breakfast->save();
                }
                else {
                    $breakfast->updated_at = Carbon::now();
                    $breakfast->save();
                }
            }
            catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
        \DB::commit();
        return response()->json(array('data' => $breakfast));
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
