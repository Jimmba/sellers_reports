<?php
include_once($_SERVER['DOCUMENT_ROOT']."/service/Sessions.php");
$session = new Sessions();
$session->startSession();
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Google Fonts CDN-->
    <link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display" rel="stylesheet">
    <!--Fontawesome CDN-->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!--Bootstrap CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--Custom LESS-->
    <link rel="stylesheet" href="view/css/styles.css" type="text/css">
    <link rel="icon" href="view/img/report-icon.png">
    <title>Отчеты</title>
</head>
<body>

<div class="container-fluid">
	<?
    include_once($_SERVER['DOCUMENT_ROOT']."/service/FilterController.php");
    $filter = new FilterController();
    $filter->init();
    ?>
    <div class="row reports">
		<?include ("menu.php")?>
		<div id="content" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
			<!--<div class="tab-content">-->
				<?include ($_SERVER['DOCUMENT_ROOT']."/model/report/data.php");?>
				<?//include ("prihody.php")?>
				<?//include ("rashody.php")?>
				<?//include ("vozvraty.php")?>
				<?//include ("vzp.php")?>
				<?//include ("akb.php")?>
			<!--</div>-->
		</div>
	</div>
</div>

<!--jQuery minified version.
 The rest of the pages uses a slim version.
 If any problems with AJAX, replace the slim version with the minified one-->

<script
        src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<!--Bootstrap CDN-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!--Custom JS-->
<script src="view/js/script.js"></script>
<script>
    $('#logout').click(function (e) {
        e.preventDefault();
        console.log("exit");
        $.ajax({
            type: "POST",
            url: "authorisation/logout.php",
            async: false,
            success: function ($result) {
                console.log($result);
                window.location.href='/';
            },
            error: function () {
                console.log("logout is crashed");
            }
        });
    });
</script>
</body>
</html>