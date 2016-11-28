<?php
require_once "vendor/autoload.php";

session_start();
$json=file_get_contents("php://input");
$tempArray=json_decode($json,true);
$userName=$tempArray["userName"];
$data=$tempArray["data"];
$serverPath=$tempArray["serverPath"];
$userDirectory="users/$userName/";
$questions=$data["questions"];
$data=json_encode($data);
if(!is_dir($userDirectory))
{
	mkdir($userDirectory,0777,true) or die("could not create userDirectory");
}

$files=glob($userDirectory."*");
$fileCount=count($files);
$serveyDirectory=$userDirectory."survey$fileCount/";
mkdir($serveyDirectory,0777,true) or die("could not create surveyDirectory");
$serveyFile=fopen($serveyDirectory."surveyQuestion.json",'w') or die("could not open question file");
$serveyAnswerFile=fopen($serveyDirectory."surveyAnswers.txt",'w') or die("could not open answer file");
$linkToQrCode=$serverPath."/".$serveyDirectory."surveyQuestion.json";
fwrite($serveyFile,$data) or die("could not write file");
fclose($serveyFile);
$answerData="";

//$questions=json_decode($data,true);

$totalQuestions=count($questions);

for($i=0;$i<$totalQuestions;$i++)
{
    $question=$questions[$i];
    $options=$question["options"];
    $options=explode("|",$options);
    $totalOptions=count($options);
    $answerData=$answerData."0";
    for($j=1;$j<$totalOptions;$j++)
    {
        $answerData=$answerData."-0";
    }
    if($i<$totalQuestions-1) $answerData=$answerData.",";
}

fwrite($serveyAnswerFile,$answerData);
fclose($serveyAnswerFile);

$imageSrc="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=$linkToQrCode";
$image=imagecreatefrompng($imageSrc);
imagepng($image,$serveyDirectory."QR_Code.png" );
$response["status"]=1;
$response["message"]="OK";
$response["QRcode"]=$serverPath."/".$serveyDirectory."QR_Code.png";
echo json_encode($response);

//Code to send mail

$conn=new mysqli('localhost','root','xyz@hackathon00','survey');

if($conn->connect_error)
{
    $response["status"] = 194;
    $response["message"] = "SQL Data connection error";
    echo json_encode($response);
    return;
}

$to_id = "dr.droid27@gmail.com";
/*
$sql="SELECT EMAIL from user_details where USERNAME='$userName'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $row=$result->fetch_assoc();
	$to_id=$row["EMAIL"];
}
*/
$email = "realsharma.arjun@gmail.com";
$password = "iamrealarjun";

$message = "<img src = '". 
"http://6devs.com/".$serveyDirectory."QR_Code.png"."'>". 
"<br/> To answer this survey Download our YouDecide App";
$subject = "Survey QR Code";
$fromName = "Arjun";
$image = $serverPath."/".$serveyDirectory."QR_Code.png";

// Configuring SMTP server settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $email;
$mail->Password = $password;

// Email Sending Details
$mail->addAddress($to_id);
$mail->addAttachment($image);
$mail->Subject = $subject;
$mail->msgHTML($message);
$mail->FromName = $fromName;

$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
// Success or Failure
if (!$mail->send()) {
$error = "Mailer Error: " . $mail->ErrorInfo;
echo '<p id="para">'.$error.'</p>';
}
else {
echo '<p id="para">Message sent!</p>';
}
?>
