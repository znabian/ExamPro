<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>ورود به پنل ادمین</title>
    <style>
        @font-face {
            font-family: "PeydaLight";
            src: url("/../../../font/peyda-light.ttf");
        }
        html,
        body {
        height: 100%;
        font-family: "PeydaLight";
        }

        body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }
        .form-signin .checkbox {
        font-weight: 400;
        }
        .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        }
        .form-signin .form-control:focus {
        z-index: 2;
        }
        .form-signin input[type="tel"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        text-align: center;
        }
        .form-signin input[type="password"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        text-align: center;
        }
    </style>
    <link href="signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post" action="{{route('adminConfirm')}}">
        @csrf
        <img class="mb-4" src="{{asset('images/khoshNazar.png')}}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">ورود مدیریت</h1>
        <input type="tel" id="phone" class="form-control" name="phone" placeholder="شماره موبایل" required autofocus autocomplete="off">
        <input type="password" id="password" class="form-control mt-3" name="password" placeholder="رمز عبور" required autocomplete="off">
        <button class="btn btn-lg btn-danger btn-block mt-4" type="submit">ورود</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2022-2023</p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>
