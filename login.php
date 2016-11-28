<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//$json=$_POST["data"];
$json=file_get_contents("php://input");
$parameters=json_decode($json,true);

$userName="Nope";;
$password=$parameters["password"];
$fullName="Nope";
$email=$parameters["email"];
$_SESSION["server_path"]="139.59.46.237";
$serverName="localhost";
$dataBaseUser="root";
$dataBasePassword="xyz@hackathon00";
$dataBaseName="survey";
$tableName="user_details";
$conn=new mysqli($serverName,$dataBaseUser,$dataBasePassword,$dataBaseName);

if($conn->connect_error)
{
    $response["status"] = 0;
    $response["message"] = "SQL Data connection error";
    echo json_encode($response);
    return;
}

//if(strcmp($userName,"Nope")!=0)
{   
    //if we have user name and password;
    $sql="select * from $tableName where PASSWORD='$password' and EMAIL='$email'";
    $result=$conn->query($sql);

    //$scriptResult=0;
    if($result->num_rows>0)
    {
	$row = $result->fetch_assoc();
        $_SESSION["USERNAME"] = $row["USERNAME"];
        $_SESSION["FULLNAME"] = $row["NAME"];
        $response["status"] = 1;
        $response["message"] = "Successfully Logged In";
        $response["userName"]=$row["USERNAME"];
	$response["fullName"]=$row["NAME"];
        echo json_encode($response);
        //header("Location: "."/uploadData.html"); //This is for testing purpose only
	return;
    }
    else
    {
        $response["status"] = 0;
        $response["message"] = "Logged In failed";
        echo json_encode($response);
	return; 
    }
}
/*
else
{
    $sql="select USERNAME from $tableName where EMAIL='$email'";
    $result=$conn->query($sql);

    //$scriptResult=0;
    if($result->num_rows>0)
    {
        $row=$result->fetch_assoc();
        $_userName=$row["USERNAME"];
        $_SESSION["USERNAME"]=$userName;
        $_SESSION["FULLNAME"]=$fullName;

        $response["status"] = 1;
        $response["message"] = "Success";
        echo json_encode($response);
        //header("Location: "."/uploadData.html"); //this is for testing purpose only
        return;
    }
	else
    {
        $response["status"] = 0;
        $response["message"] = "Failed login";
        echo json_encode($response);
        return;//failed login
    }
}
*/
?>
