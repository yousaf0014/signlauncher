<?php
//phpinfo();

/**
* 
*/
class Database
{
	public $conn;
	public function getConnection() {
		$this->conn = @mysqli_connect('localhost', 'talha', '', 'wpsocialposter');
		if (!$this->conn) {
    		echo "Error: " . mysqli_connect_error();
			exit();
		}
		return $this->conn;
	}
}


// $con = 


//echo 'Connected to MySQL';

// $sql 	= 'SELECT * FROM wp_sbwaccounts';
// $query 	= mysqli_query($con, $sql);
// while ($row = mysqli_fetch_array($query))
// {
// 	echo $row['id'];
// }

// // Close connection
// mysqli_close ($con);

?>