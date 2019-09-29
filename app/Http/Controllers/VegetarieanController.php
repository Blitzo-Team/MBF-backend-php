<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;

class VegetarieanController extends Controller
{
    public function create_or_update(Request $request, \App\Vegetarian $Vegetarian, $is_new=false) {
        
        $validator_arr = [
            // TODO
        ];

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        $data = $request->only('data')['data'];

        // checking valiidation

        // $table = \DB::table('vegetarian')->pluck('meal_id');

        // for($i = 0; $i < count($data); $i++) {
        //     for($a = 0; $a < count($table); $a++) {
            
        //         if($data[$i]['id'] == $table[$a]) {
        //             return response()->json(array("result" => "check list already in use in the menu!"), 404);
        //         }
        //     }
        // }

        \DB::beginTransaction();
        try {
            if ($is_new) {
                foreach($data as $row) {
                    $Vegetarian =  new \App\Vegetarian();
                    $Vegetarian->size_id  = 0;
                    $Vegetarian->meal_id  = $row['id'];
                    $Vegetarian->save();
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

        return response()->json(array('Vegetarian' => $Vegetarian));
    }

    public function create(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return $this->create_or_update($request, new \App\Vegetarian(), true);
    }

    public function update(Request $request, \App\Vegetarian $vegetarian) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        if(request('id')){
         $vegetarian->meal_id = request('id');
        }

        if(request('size')){
            $vegetarian->size_id = request('size');
        }
      
        $vegetarian->save();
        return response()->json($vegetarian);
    }
    
    public function list(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $query = \DB::table('vegetarian');
        $query = $query->join('breakfast', 'breakfast.id', '=', 'vegetarian.meal_id')
                       ->select(
                           'breakfast.id_number',
                           'breakfast.image',
                           'breakfast.status',
                           'breakfast.name',
                           'breakfast.description',
                           'breakfast.weight',
                           'breakfast.filters',
                           'breakfast.filters_additional_sides',
                           'breakfast.status',
                           'breakfast.category',
                           'vegetarian.meal_id',
                           'vegetarian.size_id',
                           'vegetarian.id',
                        );
                       
        // filtering
        $ALLOWED_FILTERS = [];
        $SEARCH_FIELDS = [];
        $JSON_FIELDS = [];
        $BOOL_FIELDS = [];
        $response = $this->paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS, $BOOL_FIELDS, $SEARCH_FIELDS);
      
        $data = $response['data'];
        $result = array();

        foreach($data as $row){
            $array = array();
            $array['meal_id'] = $row->meal_id;
            $array['id'] = $row->id;
            $array['id_number'] = $row->id_number;
            $array['image'] = json_decode($row->image);
            $array['status'] = $row->status;

            $array['name'] = $row->name;
            $array['description'] = $row->description;
            $array['weight'] = $row->weight;

            $array['filters'] = json_decode($row->filters);
            $array['filters_additional_sides'] = json_decode($row->filters_additional_sides);
            $array['status'] = $row->status;

            $array['category'] = $row->category;
            $array['size'] = \DB::table('sizes')->where('id', json_decode($row->size_id))->first();

            array_push($result, $array);
        }

        $response['data'] = $result;

        return response()->json($response);
    }

    
    public function read(Request $request,  $vegetarian) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }

        $query = \DB::table('vegetarian')->where('vegetarian.id', $vegetarian);
        $query = $query->join('breakfast', 'breakfast.id', 'vegetarian.meal_id')
                       ->select(
                           'breakfast.id_number',
                           'breakfast.image',
                           'breakfast.status',
                           'breakfast.name',
                           'breakfast.description',
                           'breakfast.weight',
                           'breakfast.filters',
                           'breakfast.filters_additional_sides',
                           'breakfast.status',
                           'breakfast.category',
                           'vegetarian.meal_id',
                           'vegetarian.size_id',
                           'vegetarian.id',
                       )
                       ->get();
                  
            $result = array();
    
            foreach($query as $row){
                $array = array();
                $array['id'] = $row->id;
                $array['id_number'] = $row->id_number;
                $array['image'] = json_decode($row->image);
                $array['status'] = $row->status;
    
                $array['name'] = $row->name;
                $array['description'] = $row->description;
                $array['weight'] = $row->weight;
    
                $array['filters'] = json_decode($row->filters);
                $array['filters_additional_sides'] = json_decode($row->filters_additional_sides);
                $array['status'] = $row->status;
    
                $array['category'] = $row->category;
                $array['sizes'] = \DB::table('sizes')->where('id', json_decode($row->size_id))->get();
    
                array_push($result, $array);
            }
    
        
            return response()->json($result);
    }

    public function truncate_vegetarian(){
        $query = \DB::table('vegetarian')->truncate();

        return response()->json(array("result" => "Reset Items!"));
    }
    
    public function remove_muscle_item(Request $request, $vegetarian){
        $query = \DB::table('vegetarian')->where('id', $vegetarian)->delete();

        return response()->json(array("result" => "Item Deleted!"));
    }
}
