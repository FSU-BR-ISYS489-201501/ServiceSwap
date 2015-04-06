	
	//sends sql error notification to Administrator
	function sqlErrors($erNo,$erStatus,$fileName)
	{
		error_log("MYSQL Error Code: ".$erNo." MYSQL Error Status:".$erStatus. "File Name: ".                		$fileName,1,"webmaster@example.com");
	}
		


	//creates a connection to the database
	$pageName = basename($_SERVER['PHP_SELF']);
	
	
	function connectToDb($db)
	{
		$servername = "mysql.isys489.com";
		$username = "isys489c_spscam";
		$password = "k5;Tpd#4(c_;";
		
		if(empty($dbname))
		{
			$dbname='isys489c_BR_ServiceSwap';
		}
		else
		{
			$dbname= $db;
		}

		
		$connection = mysqli_connect($servername,$username,$password,$dbname);
		if(!$connection)
		{
			$connErrorCode = mysqli_connect_errno();
			$connErrorStatus = mysqli_connect_error();
			
			$mysqlError = TRUE;
			$mysqlErrorType ='Connection';
			
			sqlErrors($connErrorCode,$connErrorStatus,$pageName);
			$errorMsg='Website Issue, Administrator has been notified';
			die();
		}
		else
		{
			return $connection;
		}
	}
	
	

