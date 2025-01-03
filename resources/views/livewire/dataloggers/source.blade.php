<section class="source" data-level="level-{{ Str::substr($datalogger->sourceVolumePercentage(), 0, 1) }}">

    <span class="volume-label">Level-{{ $datalogger->lastRecieveMessage()->content['Level'] ?? ' ' }}</span>
    <section class="source-level"></section>

</section>

