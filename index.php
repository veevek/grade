<?php
session_start();
require_once "include/auth.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grades</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>

	<?php include "include/nav.php"; ?>

	<div class="content">

		<h1>Welcome to the Grades System</h1>
		<p>Here you can login to check your grades</p>
		<p>Try 555001 / password</p>


		<?php
		
		if(is_logged_in()): ?>
			<h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
			<form action="logout.php" method="POST">
				<button>Log out</button>
			</form>
		<?php else: ?>

		<form action="login.php" method="POST">
			<ul>
			<li>
				<label for="student_id">Student ID</label>
				<input type="text" size="10" maxlength="10" name="student_id" id="student_id">
			</li>

			<li>
				<label for="password">Password</label>
				<input type="password" size="10" name="password" id="password">
			</li>
			</ul>
			<button>Log in to the Grades system</button>
		</form>

		<?php endif ?>
	</div>

	<?php include "include/footer.php"; ?>

	<script src="script/validate_login.js"></script>

</body>
</html>