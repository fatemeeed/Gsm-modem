@if (session('toast-success'))
    <section class="toast" data-delay="5000">

        <section class="toast-body py-3 d-flex bg-success text-white">
            <strong class="ml-auto">{{ session('toast-success') }}</strong>
            <button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </section>
    </section>

    {{-- <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">

            <strong class="me-auto">عملیات</strong>

            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <strong class="ml-auto">{{ session('toast-success') }}</strong>
        </div>
    </div> --}}

    
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        })
    </script>
@endif
