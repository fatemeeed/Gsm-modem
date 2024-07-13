<input type="text" id="menu-toggle">
<div class="sidebar">
    <div class="sidebar-container">
        <div class="brand">
            <h4>
                <span class="fab fa-pied-piper-square"></span>
                تله متری چاه ها و منابع
            </h4>
        </div>
        <div class="sidebar-avatar">
            <div class="avatar-image">
                <img src="{{ asset('assets/images/model.png') }}" alt="">
            </div>
            <div class="avatar-info">
                <div class="avatar-text">
                    <h5> {{ auth()->user()->fullName }} </h5>
                   
                </div>
                {{-- <span class="fas fa-chevron-down"></span> --}}
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="sidebar-menu-link">
                <li class="sidebar-menu-link-item"><a href="{{ route('app.index') }}" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>داشبورد</span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.data-logger.index') }}">
                        <span class="fas fa-key"></span>
                        <span>تجهیزات </span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.Message.send-box') }}">
                        <span class="fas fa-paper-plane"></span>
                        <span>صندوق ارسال </span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.Message.recieve-box') }}">
                        <span class="fas fa-check"></span>
                        <span>صندوق دریافت</span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.setting.index') }}">
                        <span class="fas fa-cog"></span>
                        <span>تنظیمات مودم </span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.check-code.index') }}">
                        <span class="fas fa-cog"></span>
                        <span> چک کد ها </span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.order-code.index') }}">
                        <span class="fas fa-cog"></span>
                        <span> کدهای کنترل </span>
                    </a>
                </li>
                <li class="sidebar-menu-link-item">
                    <a href="{{ route('app.user.index') }}" >
                        <span class="fas fa-user"></span>
                        <span>کاربران</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- <div class="sidebar-card">
            <i class="fas fa-ticket-alt"></i>
            <div>
                <h3>افزودن تبلیغات  </h3>
                <p>برای کسب درآمد به ویدیوهای خود تبلیغات اضافه کنید</p>
            </div>
            <button>الان بسازید</button>
        </div> -->
    </div>
</div>