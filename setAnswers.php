<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
$Error=0;
//$json=$_POST["data"];
$json=file_get_contents("php://input");
$parameters=json_decode($json,true);
$UserName=$parameters["userName"];
$SurveyNumber=$parameters["surveyNumber"];
$Answers=$parameters["answers"];
$ArrayUserAnswer=explode(",",$Answers) or $Error=1;
$Directory="users/".$UserName."/survey".$SurveyNumber."/";
$answerFile=fopen($Directory."surveyAnswers.txt",'r') or $Error=1;
$StringAnswers=fgets($answerFile) or $Error=1;
$ArrayAnswers=explode(",",$StringAnswers) or $Error=1;
$ArrayLenght=count($ArrayAnswers) or $Error=1;
for($i=0;$i<$ArrayLenght;$i++)
{
    $optionsArray=explode("-",$ArrayAnswers[$i]) or $Error=1;
    $optionsArray[$ArrayUserAnswer[$i]]=$optionsArray[$ArrayUserAnswer[$i]]+1;
    
    $tempString=$optionsArray[0];
    $tempCount=count($optionsArray) or $Error=1;
    for($j=1;$j<$tempCount;$j++)
    {
        $tempString=$tempString."-".$optionsArray[$j];
    }
    $ArrayAnswers[$i]=$tempString;
}

$tempString=$ArrayAnswers[0];
for($i=1;$i<$ArrayLenght;$i++)
{
    $tempString=$tempString.",".$ArrayAnswers[$i];
}
$answerFile=fopen($Directory."surveyAnswers.txt",'w') or $Error=1;
fwrite($answerFile,$tempString);
if($Error==0)
{
    echo "Thank You";
}
else{
    echo "Error";
}
?>
