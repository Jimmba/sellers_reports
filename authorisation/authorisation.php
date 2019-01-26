
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Bootstrap-->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Custom-->
 
    <link rel="stylesheet" type="text/css" href="authorisation/css/stylesAuth.css" />
    <title>Авторизация</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">                   
            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-2 col-1"></div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 col-10 enter-form-block">

                <!--Enter form-->

                <form id="enter-form" class="enter-form">
                    <div class="form-group">
                        <label for="login1">Логин</label>
                        <input type="text" class="form-control" id="login1" name = "email" placeholder="Логин">
                    </div>
                    <div class="form-group">
                        <label for="password1">Пароль</label>
                        <input type="password" class="form-control" id="password1" name = "password" placeholder="Пароль">
                    </div>
                    <input type="hidden" name="action" value="check">
                    <div class="row">                  
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button id="enter-enter-button" type="submit" class="btn btn-block btn-primary">Войти</button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button  id="enter-registration-button" type="button" class="btn btn-block btn-primary">Регистрация</button>
                        </div>
                    </div>
                    <div class="forgot-password-block">
                        <small>
                            <a href="#" class="forgot-password-link" id="forgot-password-button">Забыли пароль?</a>
                        </small>
                    </div>
                </form>  

                <!--Registration form-->

                <form id="registration-form" class="registration-form">
                    <div class="form-group">
                        <label for="first-name">Имя</label>
                        <input type="text" class="form-control" id="first-name" name = "firstName" placeholder="Имя">
                    </div>
                    <div class="form-group">
                        <label for="second-name">Фамилия</label>
                        <input type="text" class="form-control" id="second-name" name = "secondName" placeholder="Фамилия">
                    </div>
                    <div class="form-group">
                        <label for="email1">Email</label>
                        <input type="email" class="form-control" id="email1" name = "email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password2">Пароль</label>
                        <input type="password" class="form-control" id="password2" name = "password" placeholder="Пароль">
                    </div>
                    <div class="form-group">
                        <label for="password3">Повторите пароль</label>
                        <input type="password" class="form-control" id="password3" name = "password2" placeholder="Повторите пароль">
                    </div>
                    <div class="row">                  
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button id="registration-enter-button" type="button" class="btn btn-block btn-primary">Войти</button>  
                        </div>  
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button  id="registration-registration-button" type="submit" class="btn btn-block btn-primary">Регистрация</button>
                        </div>
                    </div>
                </form>  

                <!--Forgot password form-->

                <form id="forgot-password-form" class="forgot-password-form">
                    <div class="form-group">
                        <label for="email2">Email</label>
                        <input type="email" class="form-control" id="email2" name = "email" placeholder="Email">
                    </div>
                    <div class="row">                   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button id="forgot-password-enter-button" type="button" class="btn btn-block btn-primary">Войти</button>
                        </div>                   
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <button id="remember-password-button" type="submit" class="btn btn-block btn-primary">Вспомнить пароль</button>
                        </div>  
                    </div>
                </form>  

            </div>
            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-2 col-1"></div>
        </div>    
    </div>

    <!--jQuery minified version.
    The rest of the pages uses a slim version.
    If any problems with AJAX, replace the slim version with the minified one-->

    <script
            src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <!--Bootstrap-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
    <!--Custom-->
    
    <script src="authorisation/js/scriptAuth.js"></script>


</body>
</html>