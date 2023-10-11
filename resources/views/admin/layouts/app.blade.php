<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel | Admin</title>


    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template_adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/fontawesome/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template_adminlte/dist/css/adminlte.min.css') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/manager.css') }}">

</head>

<body class="hold-transition sidebar-mini">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <div class="main">
        @if (session('success'))
            @php
                Alert::success(session('success'));
            @endphp
        @elseif (session('error'))
            @php
                Alert::error(session('error'));
            @endphp
        @endif
        @yield('content')
    </div>
    @include('admin.layouts.footer')
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#province').change(function(event) {
                var provinceId = this.value;
                $('#district').html('');
                $.ajax({
                    url: "{{ route('selectProvince') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        province_id: provinceId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#district').html('<option value="">Select District</option>');
                        $.each(response.districts, function(index, val) {
                            $('#district').append('<option value="' + val.id + '"> ' +
                                val.name + ' </option>')
                        });
                        $('#commune').html('<option value="">Select Commune</option>');
                    }
                })
            });
            $('#district').change(function(event) {
                var districtId = this.value;
                $('#commune').html('');
                $.ajax({
                    url: "{{ route('selectProvince') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        district_id: districtId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#commune').html('<option value="">Select State</option>');
                        $.each(response.communes, function(index, val) {
                            $('#commune').append('<option value="' + val.id + '"> ' +
                                val.name + ' </option>')
                        });
                    }
                })
            })
        });
    </script>

</body>

</html>
