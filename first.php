<?php
   
	// з'єднання з БД
    include 'connect.php';

    $style = "";
    $admin_button = "";
    $page = "";

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = $mysqli -> query("SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        // перевірка на логін користувача
        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])){
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            
            $nick = 'Акаунт';
            $nickname = '';
            $add  = '
				<li><a href="login.php">Вхід</a></li>
				<li><a href="register.php">Реєстрація</a></li>
            ';
            $style2 = 'style = "display: none;"';
        } else{
            $nick = $userdata['user_login'];
            $nickname = $userdata['user_login'];
            $add  = '
				<li><a href="exit.php">Вихід</a></li>
            ';
            $style = 'style = "display: none;"';
            
            if ($nick == "admin"){
            	$admin_button = '<hr> <button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Видалити всі</button>';
            }
        }
    } else{
        $nick = 'Акаунт';
        $nickname = '';
        $add  = '
			<li><a href="login.php">Вхід</a></li>
			<li><a href="register.php">Реєстрація</a></li>
        ';
        $style2 = 'style = "display: none;"';
    }

    // інформація про сторінку (номер сторінки)
    $this_page = $_GET[page];
    if (!empty($this_page)){
    	$page_text = "(".$this_page." сторінка)";;
    } else {
    	$page_text = "";
    }
?>
<!DOCTYPE html>
<html>
	<head> 
		<title> Гостьова книга </title>
		<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120229196-3"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-120229196-3');
		</script>
		<link rel="stylesheet" href="style.css">
		<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/6854e2086f.js"></script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://hwork.net/guestbook/">Гостьова книга</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Головна</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_about">Про автора</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_contact">Контакти</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_admin">Перегляд</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $nick; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php echo $add; ?>
						</ul>
					</li>

				</ul>
			</div>
		</div>
	</nav>
	<div class="modal fade" id="myModal_about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Про автора</h4>
				</div>
				<div class="modal-body">
					Автор цієї сторінки — Богдан Щербаков, який навчається в групі ПС-46. <br> Створено спеціально для базового керівництва по створенню сайтів.
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Контакти</h4>
				</div>
				<div class="modal-body">
					<a href="https://t.me/gmastrbit" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i> Telegram</a> <br>
					<a href="https://vk.com/gmastrbit" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i> VK</a> <br>
					<a href="https://www.facebook.com/gmastrbit" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a> <br>
					<a href="https://www.behance.net/gmastrbit" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i> Behance</a> <br>
					<a href="mailto:gmastrbit@gmail.com" target="_blank"> <i class="fa fa-envelope" aria-hidden="true"></i> email</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Перегляд</h4>
				</div>
				<div class="modal-body">
					<form method="POST">
						<button type="submit" class="btn btn-info" name="asc"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> Старі повідомлення зверху </button> <br> <br>
						<button type="submit" class="btn btn-info" name="desc"><i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>  Нові повідомлення зверху</button></i>
						<?php echo $admin_button; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="all">
		<h1 <?php echo $style2; ?>><i class="fa fa-comments" aria-hidden="true"></i> Залиште коментар</h1>
		<br <?php echo $style2; ?>>
		<form method="POST" <?php echo $style2; ?>>
			<div class="form-group">
				<label <?php echo $style2; ?> for="inputComment">Текст коментаря:</label>
				<textarea <?php echo $style2; ?> required class="form-control" rows="5" id="inputComment" placeholder="Будь-який текст коментаря." name="input_text"></textarea>
			</div>
			<button  <?php echo $style2; ?>type="submit" class="btn btn-primary" name="send"><i class="fa fa-paper-plane" aria-hidden="true"></i> Надіслати</button>
		</form>
		<br <?php echo $style2; ?>>
		<h1><i class="fa fa-eye" aria-hidden="true"></i> Перегляд всіх коментарів <small><?php echo $page_text; ?> </small></h1> 
		<br>