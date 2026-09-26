<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        .main-container {
            width: 70%; 
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #F9BD24;
            padding: 10px;
            border-radius: 10px;
        }

        .logo-div {
            text-align: center;
        }

        .logo-img{
            max-width: 100px;
            height: auto;
        }
        .link{
            background:black;
            padding:0.3em;
            border-radius:5px;
        }
        .link > a{
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            color: #F9BD24;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="logo-div">
            <a href="{{ route('home') }}">
            <img class="logo-img" src="{{ asset('images/logo.png') }}">
            </a>
        </div>
        
        <div class="header">
            <h1>
                {{ $subject }}
            </h1>
        </div>

        <div class="message">
            <p>
                {{ $mailMessage }}
            </p>

            @if($emailLink != null)
            <span class="link">
                <a href="{{ $emailLink }}" >Download</a>
            </span>
            @endif
        </div>
    </div>

</body>
</html>