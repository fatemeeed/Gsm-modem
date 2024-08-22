<div>

    @if ($datalogger->dataloggerLastStatus() == 'ON')
        <button class="btn btn-danger  btn-sm">خاموش </button>
    @elseif($datalogger->dataloggerLastStatus() == 'OFF')
        <button class="btn btn-success btn-sm"> روشن</button>
    @else
    <button class="btn btn-success btn-sm" disabled> روشن</button>
    @endif



</div>
