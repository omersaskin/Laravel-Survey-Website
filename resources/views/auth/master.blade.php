<!doctype html>
<html lang="tr">
  <head>
    @include('layouts.partials.head')
    
    <style>
      body {background-color: #fffff0;}
      /* Anket Form */


  select {
    width: 100%;
    min-height: 150px;
    margin-bottom: 20px;
  }

  input[type="submit"] {
    display: block;
    margin: 20px auto;
  }

  label {
    display: block;
    position: relative;
    cursor: pointer;
    font-size: 18px;
    padding-left: 46px;
    margin-bottom: 15px;      
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  label input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  .select {
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    position: absolute;
    border-radius: 50%;
    background-color: #cccccc;
  }

  label:hover input~.select {
    background-color: #ccc;
  }

  label input:checked~.select {
    background-color: #1A33FF;
  }

  .select:after {
    content: "";
    position: absolute;
    display: none;
  }

  label input:checked~.select:after {
    display: block;
  }

  label .select:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
  }
  form input[type="submit"] {
          background-color:#000;
          padding:10px;
          font-weight: bold;
          color:#fff;
          border-style: none;
          border-radius: 5px;
        }

      .a-br {
        margin-bottom: 20px;
      }
</style>
    <title>@yield('title')</title>
  </head>
  <body>

      @yield('content')

    @include('layouts.partials.footer')
  </body>
</html>
