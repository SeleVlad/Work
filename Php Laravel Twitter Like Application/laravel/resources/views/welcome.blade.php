@extends('layouts.master')

@section('title')
    {{--Welcome!--}}
    Socialize
@endsection

@section('content')
    @include('includes.message-block')
    <link rel="stylesheet" href="{{ URL::to('css/loginStyle.css') }}">

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Login</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Register</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="{{ route('signin') }}" method="post" role="form" style="display: block;">
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <form id="register-form" action="{{ route('signup') }}" method="post" role="form" style="display: none;">

                                    <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="{{ Request::old('email') }}">
                                    </div>

                                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                        <input type="text" name="first_name" id="first_name" tabindex="1" class="form-control" placeholder="Name" value="{{ Request::old('first_name') }}">
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="{{ Request::old('password') }}">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
