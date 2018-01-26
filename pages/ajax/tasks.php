<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 22/01/2018
 * Time: 18:19
 */

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

echo $_GET['task'];

$host='localhost';
$dbname='therapy_box';
$username='root';
$passw='';
$table='tasks';

$dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $passw);

if(isset($_GET['task'])){
    $sql = "INSERT INTO tasks_table (description) VALUES (:description)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':description', $_GET['task'], PDO::PARAM_STR);

    $stmt->execute();

    $row=$stmt->fetch();

}



echo "<div>$row".'<input type="checkbox">'."</div>";


