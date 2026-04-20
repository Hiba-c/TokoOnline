<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tokoonline</title>
</head>
<body>
    <a href="{{route('backend.beranda')}}">Beranda</a>  |
    <a href="#">User</a>  |
    <a href="" onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">Keluar</a>
    <p></p>
<!-- @yieldAwal -->
 @yield('content') <!--pemangilan konten-->
 <!-- @yieldAkhir -->

<!-- form keluar app -->
    <form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- form keluar app end -->

    <!-- sweetalert -->
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- sweetalert End -->
    <!-- konfirmasi success-->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}"
        });
    </script>
    @endif
    <!-- konfirmasi success End-->

</body>
</html>
