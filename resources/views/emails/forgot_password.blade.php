@extends('emails._layout')
@section('content')

Dear {{ $user->name }}, <br />
<br />
Please input this code to reset your password.<br />
<br />
<h3>{{ $forgot_password_code }}</h3><br />
<br />

@endsection
