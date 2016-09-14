
<?php session_start();
	require_once "include/config.php";
	require_once "include/auth.php";
	require_once "include/utils.php";

	require_admin();

	 
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
		<h2>Currently logged in as <?php echo htmlentities(logged_in_user()); ?></h2>
		<form action="logout.php" method="POST">
			<button>Log out</button>
		</form>
	<?php 
		if(!isset($_POST['userId'])){ ?>
	<form action="" method="POST">
		<table>
			<tr>
				<td>Student id </td>
				<td><select name="userId">
					<?php 
					$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
					$query = "SELECT studentid from student where studentid != 'admin'";
					echo $query;
					$result = mysqli_query($conn,$query); 
							while($a = mysqli_fetch_assoc($result) ){
								echo "<option>".$a['studentid']."</option>" ;
							}
					?>
				</select></td>					
			</tr>
			
			<tr>
				<td>Course id </td>
				<td><select name="cousrseId">
				<?php 
					$query = "SELECT id from course";
					echo $query;
					$result = mysqli_query($conn,$query); 
							while($a = mysqli_fetch_assoc($result) ){
								echo "<option>".$a['id']."</option>" ;
							}
					mysqli_close($conn)	;	
					?>
				</select></td>	
			</tr>
			<tr>
				<td>year</td>
				<td><input type="text" name="year"/></td>
			</tr>
			<tr>
				<td>Semester</td>
				<td><select name="semester">
						<option>1</option>
						<option>2</option>
						</select></td>
			</tr>	
			<tr>
				<td>Grade</td>
				<td><select name="grade">
						<option>HD</option>
						<option>D</option>
						<option>C</option>
						<option>P</option>
						<option>F</option>
						</select></td>
			</tr>					
			<tr>
				<td></td>
				<td><input type="submit" name="go" value="Add Details"/></td>
			</tr>			
			</table>	
	</form>
		<?php } else { 
			//$userId = $_POST['userId']; or
			$userId = get_or_default($_POST, 'userId', '');
			$cousrseId = get_or_default($_POST, 'courseId', '') ;
			$year = get_or_default($_POST, 'year', '') ;
			$semester = get_or_default($_POST, 'semester', '') ;
			$grade = get_or_default($_POST, 'grade', '') ;
			
			$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
			$query = "INSERT INTO achievement VALUES 
			    ('$userId', $cousrseId, $year, $semester, '$grade')";
			if(mysqli_query($conn,$query))
				echo "created";
			else
				echo mysqli_error($conn);
			mysqli_close($conn)	;	
		
		}?>
		
	<?php include "include/footer.php"; ?>

<script>
	
</script>
</body>
</html>