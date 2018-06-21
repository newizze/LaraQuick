<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            QuickBooks + Laravel
        </div>

        <div class="links">
            <a href='{{ $authUrl }}' target="popup" onclick="openPopup(this)"> login </a>
            <a href="/testConnection" >Test Connection</a>
        </div>
    </div>
    @if (isset($message))
        <div class="top-right links" style="color: red">
            You have to get token first.
        </div>
    @endif

    <script type="text/javascript">
        function openPopup(element){
            var popup = window.open(element.href,'QuickBooks','width=600,height=800');
            var timer = setInterval(function() {
                if(popup.closed) {
                    clearInterval(timer);
                    alert('QuickBooks Connected');
                }
            }, 1000);
        }
    </script>
</div>
</body>
</html>
