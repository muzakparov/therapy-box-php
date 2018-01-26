<?php
function pretty_print($obj){
    echo '<pre>';

    print_r($obj);

    echo '</pre><br/>';
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

//console_log($_GET["teamName"]);

$winnerTeam=$_GET["teamName"];

$gamesResultArr=[];

$loserTeamArr=[];
$strLoserTeamArr='';

//console_log($strLoserTeamArr);


$file_handle = fopen("../../assets/csv/football.csv", "r");

while (!feof($file_handle) ) {

    $rowCsv = fgetcsv($file_handle, 1024);

    array_push($gamesResultArr, array($rowCsv[2], $rowCsv[3], $rowCsv[6]));
}

fclose($file_handle);


foreach ($gamesResultArr as $gameArr){

    $indexOfWinner=array_search( $winnerTeam, $gameArr);
    if($indexOfWinner!==FALSE){
        switch ($indexOfWinner){
            case 0:
                if($gameArr[2]=="H"){
                    array_push($loserTeamArr, $gameArr[1]);
                }
                break;
            case 1:
                if($gameArr[2]=="A"){
                    array_push($loserTeamArr, $gameArr[0]);
                }
                break;
            default:
                break;
        }
    }

}



$strLoserTeamArr=implode("<br/>",array_unique($loserTeamArr));

if(!empty($loserTeamArr)){
    echo $strLoserTeamArr;
}else{
    echo "no Result";
}




