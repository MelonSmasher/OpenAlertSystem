@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => $subject,
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <h4>The following alert has been issued: </h4>

    <p>{{$alert}}</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop