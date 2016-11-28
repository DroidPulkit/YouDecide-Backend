<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
//$json=$_POST["data"];
$json=file_get_contents("php://input");
$parameters=json_decode($json,true);
$password = $parameters["password"];
$fullName = $parameters["fullName"];
$email = $parameters["email"];
$userName="Nope";
$_SESSION["server_path"] = "139.59.46.237";
$serverName = "localhost";
$dataBaseUser = "root";
$dataBasePassword = "xyz@hackathon00";
$dataBaseName = "survey";
$tableName = "user_details";
$conn = new mysqli($serverName,$dataBaseUser,$dataBasePassword,$dataBaseName);
if($conn->connect_error)
{
    $response["status"] = 0;
    $response["message"] = "Error in connection to database";
    echo json_encode($response);
}
//if email already exists
$sql="select * from $tableName where email='$email' ";
$result=$conn->query($sql);
/*
$emailExists=0;
//When the user already exists then we login the user as we use this as login and signup
if($result->num_rows>0)
{
	$row = $result->fetch_assoc();
    $_SESSION["USERNAME"] = $row["USERNAME"];
    $_SESSION["FULLNAME"]=$row["NAME"];
	$emailExists=1;
	if(strcmp($password,"Nope")==0)
{
    $response["status"] = 1;
    $response["message"] = "User exist";
	$response["userName"]=$userName;
    echo json_encode($response);
}
else
{
$response["status"]=0;
$response["message"]="User exist";
echo json_encode($response);
}
    return;
}
*/
//For gmail login if the username is not entered or left blank
if(strcmp($userName,"Nope")==0)
{
    //create new userName
    $tempString = $fullName;
    $userName = str_replace(" ","",$tempString);
    $sql="select * from $tableName where username like '$userName%'";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
	$temp=$result->num_rows;
        $userName = $userName.$temp;
    }
}
/*
else
{
    //check user userName
    $sql="select * from $tableName where userName='$userName'";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        $response["status"] = 215;
        $response["message"] = "User already exists";
        echo json_encode($response);
        return;
    }
}*/

if(strcmp($password,"Nope")==0)
{   
    //if no passwoed then gmail login
    $sql="insert into $tableName (USERNAME,NAME,EMAIL) values('$userName','$fullName','$email')";
}
else
{
    $sql="insert into $tableName (USERNAME,PASSWORD,NAME,EMAIL) values('$userName','$password','$fullName','$email')";
}

$result = $conn->query($sql);
if($result == false)
{
	$response["status"]=0;
	$response["message"]="SQL error";
    echo json_encode($response);
    return;
}
$_SESSION["USERNAME"]=$userName;
$_SESSION["FULLNAME"]=$fullName;

$response["status"]=1;
$response["message"]="OK";
$response["userName"]=$userName;
$response["fullName"]=$fullName;
echo json_encode($response);
?>
