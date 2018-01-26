<?php include "inc/header.php"; ?>

<a href="/therapy-box">Back</a>
<div>Photos</div>

<?php

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

function pretty_print($obj){
    echo '<pre>';

    print_r($obj);

    echo '</pre><br/>';
}


$host='localhost';
$dbname='task_database';
$username='root';
$passw='';
$table='images';

try {
    $dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $passw);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

//$sql="SELECT * FROM tasks_table";
//$stmt=$dbh->prepare($sql);
//$stmt->execute();
//$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);



//console_log($rows);


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.js"></script>

<script type="text/javascript">
    $("[data-fancybox]").fancybox({ });
</script>

<div class="container">
    <div class="gallery">
        <?php
        $sql="SELECT * FROM images";
        $stmt=$dbh->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if($stmt->rowCount() > 0){
            foreach($rows as $row){
                $imageThumbURL = '../assets/img-gallery/thumb/'.$row["file_name"].'.jpg';
                $imageURL = '../assets/img-gallery/'.$row["file_name"].'.jpg';
                ?>
                <a href="<?php echo $imageURL; ?>" data-fancybox="group" data-caption="<?php echo $row["title"]; ?>" >
                    <img src="<?php echo $imageThumbURL; ?>" alt="" />
                </a>
            <?php }
        } ?>
    </div>
</div>

<style type="text/css">
    .gallery img {
        width: 20%;
        height: auto;
        border-radius: 5px;
        cursor: pointer;
        transition: .3s;
    }
</style>

<?php include "inc/footer.php"; ?>


