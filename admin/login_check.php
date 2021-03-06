<?php

	session_start();
	
	require_once('../../confidential/_GLOBALS.php');
	require_once('../class/classloader.php');
	
	$auth = 0;
	
	$db = new database();
	$db->connect();
	
	$sql = "
		SELECT
			*
		FROM
			db_admins
	";
	
	$db->query($sql);
	$db->disconnect();
	
	while($row = $db->fetch_object())
	{
		if($_POST['input_name'] == $row->name and $row->active == 1)
		{
			if(hash_hmac($GLOBALS_encryptions_passwords_algorythm, $_POST['input_password'], $GLOBALS_encryptions_passwords_key) == $row->pw_hash)
			{
				$auth = 1;
				$_SESSION['login'] = 1;
				$_SESSION['admin_id'] = $row->id;
			}
		}
	}
?>
<html>
	<head>
		<meta http-equiv="refresh" content="2; URL=index.php">
		<title>Administration</title>
	</head>
	<body>
		<?php
			
			if($auth == 1)
			{
				echo('Logged in!');
			}else{
				echo('Versuch fehlgeschlagen. Falsches Passwort?');
			}
		?>
		<br>
		<br>
		Sie werden in 2 Sekunden weitergeleitet!
	</body>
</html>