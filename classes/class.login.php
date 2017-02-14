<?php
function logIn(){
	
	 global $_CON;
	if(isset($_POST['submit']))
	{
		$user = $_POST['user'];
		$pass =$_POST['pass'];
		if (empty($user) or empty($pass))
		{
			echo "<p>Fields Empty !</p>";
		}
		else
		{
			$query = "SELECT id FROM student WHERE student_cin='$user' AND std_pwd='$pass' ";
			$result = mysqli_query($_CON,$query) or die(mysql_error());
			$count = mysqli_num_rows($result);
			if ($count == 1)
			{
				$_SESSION['std_id'] = $id;
				header('location:student.php');
			}
			else
			{
				echo "<p>User or Password incorrect</p>";
				header('location:index.php');
			}
		}
	}
}	
?>