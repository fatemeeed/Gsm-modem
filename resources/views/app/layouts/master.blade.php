<!DOCTYPE html>
<html lang="en">

<head>
    @include('app.layouts.head-tag')
    @yield('title')

</head>

<body>

    @include('app.layouts.sidebar')
    <div class="main-content">
        @include('app.layouts.header')


        @yield('content')




        @include('app.layouts.footer')

    </div>

    @include('app.layouts.script')
    @yield('script')
    <section class="toast-wrapper ">
        @include('alerts.toast.success')
        @include('alerts.toast.error')
    </section>

    @include('alerts.sweetalert.error')
    @include('alerts.sweetalert.success')

</body>

</html>
