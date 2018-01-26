<?php include "pages/inc/header.php"; ?>

<?php

session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<div class="container">
    <?php
    if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
        include './classes/class.User.php';
        $user = new User();
        $conditions['where'] = array(
            'id' => $sessData['userID'],
        );
        $conditions['return_type'] = 'single';
        $userData = $user->getRows($conditions);
        ?>
        <h1>Good Day Swapnil!</h1>
        <h2>Welcome <?php echo $userData['username']; ?>!</h2>
        <a href="pages/controllers/userAccount.php?logoutSubmit=1"  class="btn btn-danger">Logout</a>
        <div class="regisFrm">
            <p><b>Username: </b><?php echo $userData['username']; ?></p>
        </div>
        <div class="container">
            <div class="row">
                <div class="box">
                    <?php include "pages/weather.php"; ?>
                </div>
                <div class="box">
                    <a href="pages/news.php">News</a>
                </div>
                <div class="box">
                    <a href="pages/sports.php">Sports</a>
                </div>
            </div>
            <div class="row">
                <div class="box card">
                    <a href="pages/photos.php">Photos</a>
                </div>
                <div class="box">
                    <a href="pages/tasks.php">Tasks</a>
                </div>
                <div class="box">
                    <?php include "pages/clothes.php"; ?>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <h2>Login to Your Account</h2>
        <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
        <div class="regisFrm">
            <form action="./pages/controllers/userAccount.php" method="post">
                <input type="text" name="username" placeholder="USERNAME" required="">
                <input type="password" name="password" placeholder="PASSWORD" required="">
                <div class="send-button">
                    <input type="submit" name="loginSubmit" value="LOGIN">
                </div>
            </form>
            <p>Don't have an account? <a href="./pages/controllers/registration.php">Register</a></p>
        </div>
    <?php } ?>
</div>

<?php include "pages/inc/footer.php"; ?>
