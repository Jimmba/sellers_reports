<!DOCTYPE HTML>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" type="image/png" href="/img/logo.png" />
		<!--Google Fonts CDN-->
		<link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display" rel="stylesheet">
		<!--Fontawesome CDN-->
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
		<!--Bootstrap CDN-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<!--Custom LESS-->
		<link rel="stylesheet/less" href="views/css/styles.less" type="text/css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
		<!--Custom CSS-->
		<!--<link rel="stylesheet" href="styles.css.css">-->
		<!--Bootstrap CDN-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<!--jQuery Easing Effects CDN-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
		<script src="view/js/script.js"></script>
		<title>Admin</title>
	</head>
	<body>
		<header>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 ">
						<h2>Панель администрирования</h2>
					</div>
				</div>
			</div>
		</header>
		<main>
			<div class="container-fluid">
				<br>
				<!-- Nav tabs -->
				<?php include ("view/menu.php");?>
				<!-- Tab panes -->
				<div class="tab-content">

					<!--HOME-->
					<!-- <div id="home" class="container-fluid tab-pane active"><br>-->
					<div id="home" class="container-fluid tab-pane active"><br>

						<div class="row">
							<!-- Second column -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">


								<!--Поиск
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Поиск: начните вводить" value="" id="searchInput">
									</div>
								</div>
								-->

								<?php
								echo '<h3 class="tableHeadline">Название таблицы</h3>';
								?>

								<!-- Content -->
								<div class="tab-content" id="nav-tabHeaderContent">
									<div class="tab-content" id="nav-tabDishesContent">
										<div class="tab-pane fade show active" id="list-salads" role="tabpanel" aria-labelledby="list-salads-list">
											<div class="container">
												<?php
												include("table.php");                                
												?>
											</div>
										<!-- Content -->
										</div>
									<!-- Second column -->
									</div>
								</div>
								<br><br><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</body>
</html>