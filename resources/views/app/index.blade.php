@extends('app.layouts.master')
@section('title')
    <link rel="stylesheet" href="{{ asset('assets/css/shape.css') }}">
@endsection

@section('content')
<br>
<h6>
    {{-- @foreach ($dataloggers as $datalogger)
        <section class="{{ $datalogger->deviceSahpe }}">
            <h6 class="d-flex text-center ">{{ $datalogger->name }}</h6>
           
            @foreach ($datalogger->checkCodes as $checkCode)

            {{  $datalogger->lastMessageRecieve()->content[$checkCode] ?? '' }}

            
                
            @endforeach
        </section>
    @endforeach --}}
</h6>
<h5>
    وضعیت چاه ها
</h5>
  @if(1==1) 
    <div class="well-off" >
       <div style="padding-top:60px;"> چاه شماره 1 <br> OFF</div>
    </div>
  
  @else 
    <div class="well-on" >
        <div style="padding-top:60px;"> چاه شماره 1 <br> ON</div>
     </div>
    
   @endif

@endsection
