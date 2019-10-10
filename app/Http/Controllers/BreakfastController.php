<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;

class BreakfastController extends Controller
{
    public function create_or_update(Request $request, \App\Breakfast $breakfast, $is_new=false) {


        $validator_arr = [
            // TODO
        ];

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }

        // actual creation
            $breakfast->image = json_encode(request('image'));
            $breakfast->filters = json_encode(request('filters'));
            $breakfast->filters_additional_sides = json_encode(request('filters_additional_sides'));
            $breakfast->name = request('name');
            $breakfast->description = request('description');
            $breakfast->weight = request('weight');
            $breakfast->id_number = request('id_number');
            $breakfast->status = 1;
            $breakfast->category = request('category');
            $breakfast->sides = json_encode(request('sides')); 
            $breakfast->ingredients = request('ingredients');
        \DB::beginTransaction();
            try {
                if ($is_new) {
                    $breakfast->save();

                    if($breakfast->id){
                        $breakfast->sizes = $this->add_sizes($request, $is_new, $breakfast->id);
                    }
                
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

    public function add_sizes($request, $is_new, $breakfast){
        $query = $request->only('sizes')['sizes'];

        // if (!$is_new) {
        //     $old_work_experience = \App\WorkExperience::where('id', $breakfast)->get();
        //     foreach ($old_work_experience as $item) {
        //         $item->delete();
        //     }
        // }

        foreach($query as $data){
            $data_item = new \App\sizes();

            $data_item->calorie = $data['calorie'];
            $data_item->protein = $data['protein'];
            $data_item->carbohydrates = $data['carbohydrates'];
            $data_item->fats = $data['fats'];
            $data_item->saturated_fat = $data['saturated_fat'];
            $data_item->sugars = $data['sugars'];
            $data_item->sodium = $data['sodium'];
            $data_item->size = $data['size'];
            $data_item->price  = $data['price'];
            $data_item->meal_id  = $breakfast;
            $data_item->save();
        }

        if($data_item->id === null) { 
            $data_item_value = \App\Breakfast::where('meal_id', $breakfast)->get();
            foreach ($data_item_value as $item) {
                $item->delete();
             }
          }

          return $data_item->id;
    
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

    public function update_category(Request $request, $breakfast) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $table = new \App\Breakfast();
        $table -> where('id', $breakfast)
               -> update(array( "category" => request('category') )); 

        return response()->json(array($table, $breakfast));
    }

    public function update_size(Request $request, $breakfast) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $table = new \App\Breakfast();
        $table -> where('id', $breakfast)
               -> update(array( "sizes" => request('sizes') )); 

        return response()->json(array($table, $breakfast));
    }

    public function list(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $query = \DB::table('breakfast');
        $query = $query->select('*');
        
        // filtering
        $ALLOWED_FILTERS = ['category'];
        $SEARCH_FIELDS = [];
        $JSON_FIELDS = [];
        $BOOL_FIELDS = [];
        $response = $this->paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS, $BOOL_FIELDS, $SEARCH_FIELDS);
        
        $data = $response['data'];
        $result = array();

        foreach($data as $row){
            $array = array();
            $array['id'] = $row->id;
            $array['id_number'] = $row->id_number;
            $array['image'] = json_decode($row->image);
            $array['status'] = $row->status;
            $array['ingredients'] = $row->ingredients;
            $array['name'] = $row->name; 
            $array['description'] = $row->description;
            $array['weight'] = $row->weight;
            $array['default_size'] = \DB::table('sizes')->where('id', $row->sizes)->first();
            $array['filters'] = json_decode($row->filters);
            $array['filters_additional_sides'] = json_decode($row->filters_additional_sides);
            $array['status'] = $row->status;
            $array['category'] = $row->category;
            $array['sizes'] = \DB::table('sizes')->where('meal_id', $row->id)->get();

            array_push($result, $array);
        }

        $response['data'] = $result;
        
        return response()->json($response);

    }

    public function sizes_list(){
        $query = \DB::table('sizes');
        $query = $query->select('*');
        $ALLOWED_FILTERS = [];
        $SEARCH_FIELDS = [];
        $JSON_FIELDS = [];
        $BOOL_FIELDS = [];
        $result = $this->paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS, $BOOL_FIELDS, $SEARCH_FIELDS);
        return response()->json($result);
    }

    public function sizes_list_count(Request $request, $breakfast){
        $query = \DB::table('sizes')->where('meal_id', $breakfast)->count();
     
        return response()->json($query);
    }

}
