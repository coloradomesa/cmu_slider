<?php
include("db/connect.php");

function createSalt($length = 10){
    
    $filename = "/dev/urandom";
    $handle = fopen($filename, "r");
    $salt = fread($handle, 16);
    fclose($handle);
    $salt = bin2hex($salt);

    return $salt;
}

function hashPassword($password, $salt){
	$password .= $salt;
	$password = hash("sha256", $password);
	return $password;
}


function usernameExists($username, $conn){
	$sql = "SELECT username FROM users WHERE username=:username";
	$psql = $conn->prepare($sql);
	$psql->execute(array(":username"=>$username));
	$row = $psql->fetch();
	if($row['username'] == $username) return true;
	else return false;
	
}

function insertUser($user, $conn){
	$salt = createSalt();
	
	$password = hashPassword($user['password'], $salt);

	$sql = "INSERT INTO users(username, salt, password, f_name, l_name, email, group, permissions) 
			VALUES(:username, :salt, :password, :f_name, :l_name, :email, :group, :permissions)";
	$psql = $conn->prepare($sql);
	$psql->execute(array(	":username"=>$user['username'],
							":salt"=>$salt,
							":password"=>$password,
							":f_name"=>$user['f_name'],
							":l_name"=>$user['l_name'],
							":email"=>$user['email'],
							":group"=>$user['group'],
							":permissions"=>$user['permissions']
							));
}

function getSlideById($id){
	global $conn;
	$sql = "SELECT * FROM slide WHERE id=:id";
	$psql = $conn->prepare($sql);
	$query = $psql->execute(array(":id"=>$id));
	$row = $psql->fetchAll();
	return $row;
}

function expired($slide){
	$today = new DateTime();
	$today.date_default_timezone_set("America/Denver");
	if ($today >= new DateTime($slide['startDate'], new DateTimeZone('America/Denver')) && $today <= new DateTime($slide['endDate'], new DateTimeZone('America/Denver')) ) {
		return false;
	}
	else return true;
}

function isFuture($slide){
	$today = new DateTime();
	//$today.date_default_timezone_set("America/Denver");
	if ($today <= new DateTime($slide['startDate']) ) {
		return true;
	}
	else return false;
}

function isEnabled($slide){
	return (bool)$slide['enabled']; 
}


?>