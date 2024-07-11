@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
    @foreach ($dataloggers as $datalogger)
        <section class="{{ $datalogger->deviceSahpe }}">
            <h6 class="d-flex text-center ">{{ $datalogger->name }}</h6>
           
            @foreach ($datalogger->checkCodes as $checkCode)

            {{  $datalogger->lastMessageRecieve()->content[$checkCode] }}

            
                
            @endforeach
        </section>
    @endforeach
@endsection
