<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$pass = $_POST["password"];
	$mobile = (int)$_POST["mobile"];
	$loginResponse = $main->login($mobile, $pass);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="114x114" href="./favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="./favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="./favicons/favicon-16x16.png">
	<link rel="manifest" href="./favicons/site.webmanifest">
	<link rel="mask-icon" href="./favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="./assets/styles/core/materialize.min.css" media="screen,projection" />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet/less" type="text/css" href="./assets/styles/styles.less" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
	<script type='text/javascript' src='./assets/lib/plugins/gen_validatorv31.js'></script>
	<title>Login | Fast value inspection</title>
</head>

<body>
	<header class="site-header">
		<section class="container">
			<nav class="navbar navbar-expand-lg navbar-light sticky-top">
				<a class="navbar-brand" href="./index.html">
					<img src="./assets/images/logo.png" alt="Company Logo" class="logo">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarText">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="#">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="./dashboard.php">Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="#">Login <span class="sr-only">(current)</span></a>
						</li>
					</ul>
				</div>
			</nav>
		</section>
	</header>
	<div class="d-flex justify-content-center align-items-start flex-grow-1">
		<div class="login-wrapper">
			<h2 class="text-center">Login</h2>
			<?php
			if (!empty($loginResponse["status"])) {
			?>
				<?php
				if ($loginResponse["status"] == "error") {
				?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?php echo $loginResponse["message"]; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php
				}
				?>
			<?php
			}
			?>
			<form id='login' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<div class="input-field">
					<input type="text" class="validate" id="mobile" name="mobile">
					<label for="mobile">Mobile number</label>
					<span class="helper-text" id='login_mobile_errorloc'></span>
				</div>
				<div class="input-field">
					<input type="password" class="validate" id="password" name="password">
					<label for="password">Password</label>
					<span class="helper-text" id='login_password_errorloc'></span>
				</div>

				<button type='submit' name='Submit' class="btn btn-primary w-100 mt-3 waves-effect waves-light">Submit</button>
			</form>
		</div>
	</div>
	<footer class="p-3 text-center">Copyrights &copy; Fast value India Pvt.Ltd. All rights reserved</footer>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="./assets/lib/core/materialize.min.js"></script>
	<!-- client-side Form Validations:
	Uses the excellent form validation script from JavaScript-coder.com-->

	<script type='text/javascript'>
		// <![CDATA[
		$(document).ready(function() {
			var frmvalidator = new Validator("login");
			frmvalidator.EnableOnPageErrorDisplay();
			frmvalidator.EnableMsgsTogether();

			frmvalidator.addValidation("mobile", "req", "Please provide your mobile number");

			frmvalidator.addValidation("password", "req", "Please provide the password");
		});
		// ]]>
	</script>
	<script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>