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
    <a class="btn btn-primary btn-sm" href="{{ route('app.read-message') }}">بروزرسانی</a>
    </div>
    
</header>
<section class="row">
        
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif



</section>
