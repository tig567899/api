<?php
	require_once("config/database.php");
	
	$con = new database(getenv("RDS_SERVER"), getenv("RDS_USER"), getenv("RDS_PASSWORD"), "harvold");
	$con->set_charset('UTF8');
	
	$request = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	
	$request = clean_statement($request);
	
	$reply = $request($_REQUEST);
	
	echo json_encode($reply);
	
	function get_pokemon($input)
	{
		$data = safe_mysql($input['username']);
		global $con;
		
		$stmt = $con->prepare("SELECT name, hp, max_hp, exp, to_next FROM pokemon WHERE owner=?");
		$stmt->bind_param("s", $data);
		$stmt->execute();
		$assoc = $stmt->get_result();
		$stmt->close();
		while ($row = mysqli_fetch_assoc($assoc))
		{
			$pokemon[] = $row;
		}
		$result['pokemon'] = $pokemon;
		$result['status'] = "success";
		return $result;
	}
	
	function clean_statement($request) {
		if (in_array($request, array("login", "get_pokemon")))
		{
			return $request;
		} 
		else 
		{
			return false;
		}
	}
	
	function safe_mysql($input){
		return (strip_tags(stripslashes($input)));
	}
?>