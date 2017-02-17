@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.1.1/bootstrap-social.css"
          integrity="sha256-rnmbX+ZXZml9xbNUKt/qXfgpCi6zLJX7qqR+7vX/1ZY=" crossorigin="anonymous"/>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="center-div">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <h1>{{ config('app.name', 'Open Alert') }}</h1>
                                    <h5>Emergency Alert System</h5>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 btn-group-lg">
                                    @if(env('GOOGLE_AUTH_ENABLED', false))
                                        <a class="btn btn-block btn-social btn-lg btn-google"
                                           href=" {{route('social.redirect', 'google')}}">
                                            <i class="fa fa-btn fa-google"></i> Google
                                        </a>
                                    @endif
                                    @if(env('FACEBOOK_AUTH_ENABLED', false))
                                        <a class="btn btn-block btn-social btn-lg btn-facebook"
                                           href="{{route('social.redirect', 'facebook')}}">
                                            <i class="fa fa-btn fa-facebook-f"></i> Facebook
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
