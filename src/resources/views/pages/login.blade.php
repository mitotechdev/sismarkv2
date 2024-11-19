<!DOCTYPE html>
<html lang="en" class="layout">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="description" content="Perusahaan distributor dan bahan kimia">
    <meta name="keywords" content="chemical, pome, mechanical">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="canonical" href="https://sismark.mitoenergiindonesia.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    {{-- <script src="{{ Vite::asset('resources/js/app.js') }}"></script> --}}
    @vite(['resources/js/login.js'])
</head>
<body>
    
    <section style="background-color: #eee;" class="section_login">
        <div class="wrapper_login">
            <div class="text-center mb-5">
                <h4 class="mt-1 pb-1">Sistem Marketing</h4>
                <p>Please login to your account</p>
            </div>

            @if ($message = Session::get('error'))
                <div class="alert alert-danger my-2">
                    {{ $message }}
                </div>
            @endif

            <form action="{{ route('authenticate') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" class="form-control" title="Username" name="username" autofocus spellcheck="false" required/>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control" title="Password" name="password" required/>
                </div>
                <div class="text-center pt-1 pb-1">
                    <button class="btn btn-primary" type="submit">Log In</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>