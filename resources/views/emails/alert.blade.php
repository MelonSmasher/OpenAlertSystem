@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => $subject,
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{$alert}}</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop