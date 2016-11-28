<?php
session_start();
$json=file_get_contents("php://input");
$parameters=json_decode($json,true);
$userName=$parameters["userName"];
$serverPath=$parameters["serverPath"];
$Directory="users/".$userName."/";
$totalSurveys=count(glob($Directory."*"));  ///survey starts from index 0 
$result["SurveyCounts"]=$totalSurveys;
$totalFiles=glob($Directory."*");
$totalFilesNumber=count($totalFiles);
class Survey
{
    public $questions;
    public $answers;
}
$allSurveys=array();

for($i=0;$i<$totalFilesNumber;$i++)
{
    $survey=new Survey();
    $surverDirectory=$Directory."survey".$i;
    $surveyQuestionsFile=fopen($surverDirectory."/surveyQuestion.json",'r') or die("could not survey file");
    $surveyAnswersFile=fopen($surverDirectory."/surveyAnswers.txt",'r') or die("could not open answer file");
    $tempData="";
    while($line=fgets($surveyQuestionsFile))
{
    $tempData=$tempData.$line;
}
    $survey->questions=$tempData;
    $tempData="";
    while($line=fgets($surveyAnswersFile))
    {
        $tempData=$tempData.$line;
    }
    $survey->answers=$tempData;
    $allSurveys[$i]=$survey;

}

echo json_encode($allSurveys);
?>
