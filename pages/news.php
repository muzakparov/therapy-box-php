<?php include "inc/header.php"; ?>

<?php
if ( isset($_POST['getit']) ) {
    $newsoutput = new SimpleXMLElement('http://feeds.bbci.co.uk/news/rss.xml', LIBXML_NOCDATA, true);
    $newsoutput = json_decode(json_encode($newsoutput), TRUE);
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/therapy-box">Back</a>
            <h1>News</h1>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <form action="" class="form" method="post">
                <input type="hidden" name="getit" value="getit">
                <input type="submit" value="Get BBC RSS" >
            </form>

            <?php
            if (isset($_POST['getit'])) {
                echo "<hr>";
                foreach ($newsoutput['channel']['item'] as $item) { ?>
                    <p>
                        <strong><a target="_blank" href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></strong>
                    </p>
                    <p>
                        <?php echo $item['description'] ?>
                    </p>
                    <hr>
                <?php }
            }
            ?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
