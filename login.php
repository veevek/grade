<?php
session_start();
require_once "include/config.php";
require_once "include/utils.php";
require_once "include/auth.php";
?>
<?php

	$student_id = get_or_default($_POST, 'student_id', '');
	$password = get_or_default($_POST, 'password', '');

	
	if($student_id and $password) {

		$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);


		$query = "SELECT studentid, password FROM student WHERE studentid=?";
		
		

		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "s", $student_id);

		if(mysqli_stmt_execute($stmt))
		{
			// Get the results
			$result = mysqli_stmt_get_result($stmt);

			$row = mysqli_fetch_array($result);

			// If it exists
			if($row) {
				// Get the stored password
				$db_password = $row['password'];

				// Re-hash the password using the same parameters that we used to make the DB one
				$hashed_supplied = crypt($password, $db_password);

				if($db_password === $hashed_supplied)
				{
					login($student_id);
					header('Location: view.php');
					exit;
				}
			}
		}

		mysqli_stmt_close($stmt);
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grades - Login</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>
	<?php include "include/nav.php"; ?>

	<div class="content">

		<h1>Welcome to the Grades System</h1>

		<?php if(is_logged_in()): ?>
			<h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
			<form action="logout.php" method="POST">
				<button>Log out</button>
			</form>
		<?php else: ?>

		<form action="login.php" method="POST">
			<?php if($student_id) : ?>
				<div class="warning">Login failed, please try again</div>
			<?php endif; ?>
			<ul>
			<li>
				<label for="student_id">Student ID</label>
				<input type="text" size="10" maxlength="10"
				name="student_id" id="student_id"
				value="<?php echo htmlentities($student_id); ?>">
			</li>

			<li>
				<label for="password">Password</label>
				<input type="password" size="10" name="password" id="password">
			</li>
			</ul>
			<button>Log in to the Grades system</button>
		</form>
		<?php endif; ?>
	</div>

	<?php include "include/footer.php"; ?>

	<script src="script/validate_login.js"></script>
</body>
</html>