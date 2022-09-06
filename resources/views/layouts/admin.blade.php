<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js" integrity="sha512-DB4Mu+YChAdaLiuKCybPULuNSoFBZ2flD9vURt7PgU/7pUDnwgZEO+M89GjBLvK9v/NaixpswQtQRPSMRQwYIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{asset('font/font-awesome/css/font-awesome.min.css')}}">
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <title>@yield('title')-پنل ادمین</title>
    <style>
      @font-face {
      font-family: "PeydaLight";
      src: url("/../font/peyda-light.ttf");
      }
      @font-face {
      font-family: "PeydaRegular";
      src: url("/../font/Peyda-Regular.ttf");
      }
      body {
        font-family: "PeydaRegular";
        direction:rtl;
      }
    </style>
  </head>
  <body>
    <x-admin-header />
    @include('sweet::alert')
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   </body>
</html>