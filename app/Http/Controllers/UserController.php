<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use \App\Constants;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private $PASSWORD_VALIDATION = ['required', 
        'min:8', 
        'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%]).*$/'];
    private $PASSWORD_VALIDATION_MESSAGE = "Password must have a minimum of 8 characters and must contain the following: \n
        a. Numbers\n
        b. Letters (uppercase and lowercase)\n
        c. Special Characters (!, @, #, $, etc.)";

    public function create_or_update(Request $request, \App\User $user) {
        $previous = $user;

        $validator_arr = [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
        ];

        if (request('password', null)) {
            $validator_arr['password'] = $this->PASSWORD_VALIDATION;
        }
        $messages_arr = [
            'password.regex' => $this->PASSWORD_VALIDATION_MESSAGE
        ];

        $validator = Validator::make($request->all(), $validator_arr, $messages_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        // required fields
        $user->fill(
            $request->only(['name', 'email', 'permissions'])
        );
        // optional fields
        if (request('password', null)) {
            $user->password = bcrypt(request('password'));
        }
        $user->division = request('division', null);
        $user->section = request('section', null);

        if ($user->id) {
            $success = 'updated';
            $historyAction = 'UPDATE';
        }
        else {
            // assigned fields
            $user->is_disabled = false;
            $success = 'created';
            $historyAction = 'CREATE';
        }
        $user->save();
        return response()->json(array('user'=> $user, 'result' => $success));
    }

    public function create(Request $request) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        return $this->create_or_update($request, new \App\User());
    }

    public function read(Request $request, \App\User $user) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        return response()->json($user);
    }

    public function update(Request $request, \App\User $user) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        return $this->create_or_update($request, $user);
    }

    public function update_profile(Request $request) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        $validator_arr = [
            'name' => 'required',
        ];

        if (request('password', null)) {
            $validator_arr['password'] = $this->PASSWORD_VALIDATION;
        }
        $messages_arr = [
            'password.regex' => $this->PASSWORD_VALIDATION_MESSAGE
        ];

        $validator = Validator::make($request->all(), $validator_arr, $messages_arr);
        
        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 400);
        }
        $user = \App\User::where('id', '=', $this->me->id)->first();
        // required fields
        $user->fill(
            $request->only(['name'])
        );
        // optional fields
        if (request('password', null)) {
            $user->password = bcrypt(request('password'));
        }
        $user->save();
        return response()->json(array('user'=> $user, 'result' => 'updated'));
    }

    public function disable(Request $request, \App\User $user) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        $user->is_disabled = true;
        $user->save();
        return response()->json(array('user'=> $user, 'result' => 'disabled'));
    }

    public function enable(Request $request, \App\User $user) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        $user->is_disabled = false;
        $user->save();
        return response()->json(array('user'=> $user, 'result' => 'enabled'));
    }

    public function login(Request $request)
    {
        $error = null;
        $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 404);
        }
        $user = \App\User::where('email', request('email'))->first();
        if ($user->is_disabled) {
            $error = "User is disabled. Please contact an administrator";
            $error_code = 'user_disabled';
        }
        else if (!$user) {
            $error = "Invalid username / password!";
            $error_code = 'invalid_password';
        }
        else if (!Hash::check(request('password'), $user->password)) {
            $error = "Invalid username / password!";
            $error_code = 'invalid_password';
        }

        if ($error) {
            $user->num_attempts = $user->num_attempts + 1;
            if ($user->num_attempts >= 5) {
                $user->is_disabled = true;
            }
            $user->save();
            return response()->json(['error' => $error_code, 'messages' => [$error]], 401);
        }
        else {
            $user->last_login_date = Carbon::now()->toDateTimeString();
            $user->num_attempts = 0;
            $user->save();
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            else {
                return response()->json(['user' => $user, 'token' => $token, 'token_expiry' => auth()->factory()->getTTL()]);
            }
        }

    }
    public function list(Request $request) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        $query = \DB::table('users');
        $query = $query->select('id', 'name', 'email', 'is_disabled', 'division', 'section');
        
        // filtering
        $ALLOWED_FILTERS = ['is_disabled'];
        $JSON_FIELDS = [];
        $SEARCH_FIELDS = ['name', 'email'];
        $BOOL_FIELDS = ['is_disabled'];
        $result = $this->paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS, $BOOL_FIELDS, $SEARCH_FIELDS);
        return response()->json($result);
    }

    public function request_reset_password(Request $request) {
        $error = null;
        $validator = Validator::make($request->all(), [
                'email' => 'required|exists:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 404);
        }
        $user = \App\User::where('email', request('email'))->first();

        // check if request is recently sent
        if ($user->forgot_password_date != '') {
            if (Carbon::parse($user->forgot_password_date)->gt(Carbon::now()->subHour(0))) {
                $error ='Please wait 1 hour to request again or contact us';
                $error_code = 'reset_password_limit';
            }
        }

        if ($error) {
            return response()->json(['error' => $error_code, 'messages' => [$error]], 400);
        }
        else {
            $forgot_password_code = Str::random(4);
            $user->forgot_password_code = $forgot_password_code;
            $user->forgot_password_date = Carbon::now()->toDateTimeString();

            Mail::to($user->email)->send(new \App\Mail\UserResetPasswordMail($user, $forgot_password_code));
            $user->save();

            return response()->json(['success' => true]);
        }
    }


    public function reset_password(Request $request) {
        $error = null;

        $validator_arr = [
            'forgot_password_code' => 'required',
            'email' => 'required|exists:users,email'
        ];

        if (request('password', null)) {
            $validator_arr['password'] = $this->PASSWORD_VALIDATION;
        }
        $messages_arr = [
            'password.regex' => $this->PASSWORD_VALIDATION_MESSAGE
        ];

        $validator = Validator::make($request->all(), $validator_arr, $messages_arr);

        if ($validator->fails()) {
            return response()->json(['error' => 'validation_failed', 'messages' => $validator->errors()->all()], 404);
        }
        $user = \App\User::where('email', request('email'))->first();
        // check if forgot_password_code is valid
        if (!Carbon::parse($user->forgot_password_date)->gt(Carbon::now()->subMinutes(15))) {
            $error ='Request is expired';
            $error_code = 'reset_password_code_expired';
        }
        else if ($user->forgot_password_code != request('forgot_password_code')) {
            $error ='Invalid code';
            $error_code = 'invalid_code';
        }

        if ($error) {
            return response()->json(['error' => $error_code, 'messages' => [$error]], 400);
        }
        else {
            $user->password = bcrypt(request('password'));
            $user->forgot_password_code = '';
            $user->save();
            return response()->json(['success' => true]);
        }
    }

    public function me(Request $request) {
        $this->me = JWTAuth::parseToken()->authenticate();
        if (!($this->me->claims['temporary'] ?? $this->DISABLE_AUTH)) {
            return response()->json(Constants::ERROR_UNAUTHORIZED, 403);
        }
        $user = \App\User::find($this->me->id);
        return response()->json($user);
    }


}
