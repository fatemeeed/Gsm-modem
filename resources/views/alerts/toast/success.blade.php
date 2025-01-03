@if (session('toast-success'))
    {{-- <section class="toast" data-delay="5000">

        <section class="toast-body py-3 d-flex bg-success text-white">

            <strong class="ml-auto">{{ session('toast-success') }}</strong>
            <button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </section>

    </section> --}}

    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('toast-success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        })
    </script> --}}
@endif
