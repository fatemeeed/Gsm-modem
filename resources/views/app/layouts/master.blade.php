<!DOCTYPE html>
<html lang="en">

<head>
    @include('app.layouts.head-tag')
    @yield('title')
    @livewireStyles

</head>

<body>

    @include('app.layouts.sidebar')
    <div class="main-content">
        @include('app.layouts.header')


        @yield('content')




        @include('app.layouts.footer')

    </div>
    @livewireScripts
    @include('app.layouts.script')
    @yield('script')

    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />
    <section class="toast-wrapper ">
        @include('alerts.toast.success')
        @include('alerts.toast.error')
    </section>

    @include('alerts.sweetalert.error')
    @include('alerts.sweetalert.success')

</body>

</html>
