<header>
    <div class="hamber">
        <div class="icon">
            <span class="hamburger-icon">
                <i class="fas fa-bars"></i>
            </span>
        </div>
        <div>
            <h3>آنالیز</h3>
            {{-- <p>نمایش اطلاعات مربوط به سایت</p> --}}
        </div>
    </div>
    <div class="header-action">

        @livewire('UpdateLoggerButtom')

    </div>


</header>

        
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif




</section>
