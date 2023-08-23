<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIIBien</title>    
    <link rel="icon" href="{{asset('images/icon_.png')}}" type="image/ico" />
    <link href="{{asset('resources/vendor/sweetalert/css/sweetalert2.min.css" rel="stylesheet')}}">
    <link href="{{asset('resources/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('resources/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <style> 
    :root { --input-padding-x: .75rem; --input-padding-y: .75rem; } html, body { height: 100%; } body { display:
        -ms-flexbox; display: -webkit-box; display: flex; -ms-flex-align: center; -ms-flex-pack: center;
        -webkit-box-align: center; align-items: center; -webkit-box-pack: center; justify-content: center; padding-top:
        40px; padding-bottom: 40px; background-color: #ffffff; } .form-signin { width: 100%; max-width: 420px; padding:
        15px; margin: 0 auto; } .form-label-group { position: relative; margin-bottom: 1rem; } .form-label-group>
        input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #000000;
        }
    </style>
</head>

<body class="font-sans antialiased" style="background-image:url('resources/images/logo_bg.png'); background-size:10%">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div>
                    @yield('content')
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
    <script src="{{asset('resources/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('resources/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    @yield('script')    
</body>

</html>
