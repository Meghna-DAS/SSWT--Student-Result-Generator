<?php

	$username_from_html = $_POST["username_from_html"];
	$password_from_html = $_POST["password_from_html"];
	
	$server = "localhost";
	$username = "root";	
	$password = "";
	$database = "Student_Result_DB";

	$conn = mysqli_connect( $server, $username, $password, $database );

	if( $conn )//check connection with database
	{
		$query = "select * from student_login where username=$username_from_html";

		$data = mysqli_query($conn,$query);

		if($data)//check username password in database
		{
			$flag = 0;
			while( $row = mysqli_fetch_array( $data ) )
			{
				if( strcmp($username_from_html,$row["Username"])==0 && strcmp($password_from_html,$row["Password"])==0 )
				{
					$flag = 1;
					break;
				}
			}

			if( $flag==0 )
			{
				echo "Incorrect Username or Password";
				echo "<br><a href='login.html'>Go back to Login Page</a>";
			}
			else
			{
				$query = "select * from student_result where username=$username_from_html";
				$data = mysqli_query($conn,$query);
				$values=mysqli_fetch_array($data);
				
				
				echo "<center><h2>Welcome to Student Result Portal !!</h2></center>";
				
				echo "<body>"; 
				
				echo "<center>";
				
				echo "<link href='result.css' type='text/css' rel='stylesheet'/>";
				
				echo "<center><table><tr><td><img src='abc.jpg'></td><td colspan='3'><b><font size='5'>ABC UNIVERSITY RESULT(MAY-2021)</font></td></tr>";
				
				echo "<tr><td>Name of Student:</td><td>".$values['Name']."</td><td>Division:</td><td>".$values['Division']."</td></tr></table>";
				
				echo "<table><tr><th>Subject Code</th><th>Subject Name</th><th>Marks</th><th>Grade</th></tr>";
				
				$sum=0;
				$data = mysqli_query($conn,$query);
				while( $row = mysqli_fetch_array($data) )
				{
					$sum = $sum + $row["Marks"];
						
					echo "<tr><td>".$row["Subject_code"]."</td><td>".$row["Subject_name"]."</td><td>".$row["Marks"]."</td><td>".$row["Grade"]."</td></tr>";	
				}
				echo "<tr><th>Total Marks</td><th>$sum</th>";
				if($sum > 0.40*400)
				{
					echo "<th>Final Remark:</th>";
					echo "<th>Passed</th></tr>";
				}
				else
				{
					echo "<th>Final Remark:</th>";
					echo "<th>Failed</th></tr>";
				}
				echo "</table>";
				echo "</center><br>";
				echo "<font size='4'><a href='login.html'>Logout</a></font>";
				echo "</body>"; 
						
			}
		}
		else
		{
			echo "Error";
		}

	}
	else
	{
		echo "Error";
		echo "<a href='login.html'>Login Page</a>";
	}

	mysqli_close($conn);
?>
