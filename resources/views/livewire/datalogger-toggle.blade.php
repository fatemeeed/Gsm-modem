<div style="display: flex; align-items: center;">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('showMessage', event => {
            Swal.fire({
                icon: event.detail.type,
                title: 'اعلان',
                text: event.detail.message,
            });
        });
    </script>
    

    @if ($datalogger->dataloggerLastStatus() == 'ON')
        <button wire:click="toggleStatus" class="btn btn-danger btn-sm">خاموش</button>
    @elseif($datalogger->dataloggerLastStatus() == 'OFF')
        <button wire:click="toggleStatus" class="btn btn-success btn-sm">روشن</button>
    @else
        <button class="btn btn-success btn-sm" disabled>روشن</button>
    @endif

    
</div>
