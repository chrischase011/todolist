<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="Our Todolist">
    <meta name="author" content="Christopher Robin Chase">
    <meta name="description" content="Our Todolist">
    <meta name="keywords" content="Todolist, Our Todolist, Todo, list, our-todolist, ourtodolist">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ URL::asset('assets/img/list.png') }}" type="image/png">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-dark">
    <style>
        .bg-list {
            background: #7CB9E8;
        }
    </style>
    <div id="app">
        <nav class="shadow-sm navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.dates_done') }}">{{ __('Date\'s Done ') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.add_new') }}">{{ __('Add New List') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.gallery') }}">{{ __('Gallery') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages.resto_roulette') }}">{{ __('Resto-Roulette') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li> --}}
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<footer class="container pb-3 flex-column d-flex justify-content-center">
    <a href="https://www.flaticon.com/free-icons/list" title="list icons" class="text-center text-decoration-none">List icons created by Freepik - Flaticon</a>
    <p class="text-center text-white">Chase &copy; {{ date('Y') }}</p>
</footer>

<script>
    function getList(id, title) {
        $("#edit-title").text(title);

        $.ajax({
            url: "{{ route('pages.get_list') }}",
            type: 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                id: id
            },
            dataType: 'json',
            success: (data) => {
                // $.each(data, (i, e) => {
                //     console.log(e);
                $("#title").val(data.title);
                $("#content").val(data.content);
                $("#set_date").val(data.set_date);
                $("#id").val(data.id);
                // });

                $("#editList").modal('show');
            }
        });
    }

    function markAsDone(id)
    {
        $.ajax({
            url: "{{route('pages.mark_done')}}",
            type: 'post',
            data: {'_token':'{{csrf_token()}}', id:id},
            dataType: 'html',
            success: (data) => {
                window.location.reload();
            }
        });
    }
    function markAsNotDone(id)
    {
        $.ajax({
            url: "{{route('pages.mark_not_done')}}",
            type: 'post',
            data: {'_token':'{{csrf_token()}}', id:id},
            dataType: 'html',
            success: (data) => {
                window.location.reload();
            }
        });
    }

    function deleteList(id)
    {
        Swal.fire({
            title:'Delete List?',
            text: 'Are you sure you want to delete this list?',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonClass: "bg-danger",
            showCancelButton: true,
            cancelButtonClass: "bg-success"
        }).then((res) =>{
            if(res.isConfirmed)
            {
                $.ajax({
                    url: "{{route('pages.delete_list')}}",
                    type: 'post',
                    data: {'_token':'{{csrf_token()}}', id:id},
                    dataType: 'html',
                    success: (data) =>{
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>
</html>
