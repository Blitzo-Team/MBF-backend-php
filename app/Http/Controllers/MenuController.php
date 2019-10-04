<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function create_or_update(Request $request, \App\Menu $menu, $is_new=false) {
        
        $validator_arr = [
            "title_menu" => "required"
        ];

        $validator = Validator::make($request->all(), $validator_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        
        $menu->title = request('title_menu');
            
        // TODO: save
        \DB::beginTransaction();
        try {
            if ($is_new) {
                $menu->save();

                if($menu->id !== null){
                    $this->day_1($request, $menu->id);
                    $this->day_2($request, $menu->id);
                    $this->day_3($request, $menu->id);
                    $this->day_4($request, $menu->id);
                    $this->day_5($request, $menu->id);
                    $this->day_6($request, $menu->id);
                    $this->day_7($request, $menu->id);
                }
            }
            
            else {
                $menu->save();
            }
        }
        catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
      
        return response()->json($menu);
    }

    public function day_1( $request, $menu_id) {
        foreach($request->only('day_1')['day_1'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_1";

            $day->save();
        }
        // return $day->id;
    }

    public function day_2( $request, $menu_id) {
        foreach($request->only('day_2')['day_2'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_2";

            $day->save();
        }
        // return $day->id;
    }

    public function day_3( $request, $menu_id) {
        foreach($request->only('day_3')['day_3'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_3";

            $day->save();
        }
        // return $day->id;
    }

    public function day_4( $request, $menu_id) {
        foreach($request->only('day_4')['day_4'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_4";

            $day->save();
        }
        // return $day->id;
    }

    public function day_5( $request, $menu_id) {
        foreach($request->only('day_5')['day_5'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_5";

            $day->save();
        }
        // return $day->id;
    }

    public function day_6( $request, $menu_id) {
        foreach($request->only('day_6')['day_6'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_6";

            $day->save();
        }
        // return $day->id;
    }

    public function day_7( $request, $menu_id) {
        foreach($request->only('day_7')['day_7'] as $row){
            $day = new \App\MenuList();
            $day->day_1_meal_id = $row['item_id_0'];
            $day->day_2_meal_id = $row['item_id_1'];
            $day->day_3_meal_id = $row['item_id_2'];
            $day->day_4_meal_id = $row['item_id_3'];
            $day->day_5_meal_id = $row['item_id_4'];
            $day->day_6_meal_id = $row['item_id_5'];
            $day->day_7_meal_id = $row['item_id_6'];
            $day->menu_id = $menu_id;
            $day->day_range = "day_7";

            $day->save();
        }
        // return $day->id;
    }

    public function create(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        return $this->create_or_update($request, new \App\Menu(), true);
    }

    public function update(Request $request, \App\Menu $menu) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        return $this->create_or_update($request, $menu);
    }

    public function list(Request $request) {
        // $this->me = JWTAuth::parseToken()->authenticate();
        // if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
        //     return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        // }
        $query = \DB::table('menu')->where('is_archived', 1)->get();
        $result = [];

        foreach($query as $row){
         $array = [];
         $array['id'] = $row->id; 
         $array['title'] = $row->title;  
         $data = \DB::table('list_selected_meals')->where('menu_id', $row->id)->get(); 
         $array['days'] = $this->selected_days($data); 
     
         $array['created_at'] = $row->created_at;  
         $array['updated_at'] = $row->updated_at; 
      
         array_push($result, $array);
        }

        return response()->json($result);
    }

    public function selected_days($data){
        $result = [];
        foreach($data as $row){
            $array = [];
            $array['id_for_edit'] = $row->id;
            $array['day_1'] = \DB::table('breakfast')->where('id', $row->day_1_meal_id)->first();
            $array['day_2'] = \DB::table('breakfast')->where('id', $row->day_2_meal_id)->first();
            $array['day_3'] = \DB::table('breakfast')->where('id', $row->day_3_meal_id)->first();
            $array['day_4'] = \DB::table('breakfast')->where('id', $row->day_4_meal_id)->first();
            $array['day_5'] = \DB::table('breakfast')->where('id', $row->day_5_meal_id)->first();
            $array['day_6'] = \DB::table('breakfast')->where('id', $row->day_6_meal_id)->first();
            $array['day_7'] = \DB::table('breakfast')->where('id', $row->day_7_meal_id)->first();
            $array['day_range'] = $row->day_range;
            array_push($result, $array);
        }

        return $result;
    }

    
    public function edit_meal(Request $request, \App\MenuList $menu){
       
        if(request('day_1_meal_id')){
            $menu->day_1_meal_id = request('day_1_meal_id');
        }

        if(request('day_2_meal_id')){
            $menu->day_2_meal_id = request("day_2_meal_id");
        }

        if(request('day_3_meal_id')){
            $menu->day_3_meal_id = request("day_3_meal_id");
        }

        if(request('day_4_meal_id')){
            $menu->day_4_meal_id = request("day_4_meal_id");
        }

        if(request('day_5_meal_id')){
            $menu->day_5_meal_id = request("day_5_meal_id");
        }

        if(request('day_6_meal_id')){
            $menu->day_6_meal_id = request("day_6_meal_id");
        }

        if(request('day_7_meal_id')){
            $menu->day_7_meal_id = request("day_7_meal_id");
        }
        
        $menu->save();
        return $menu;
    }


}

