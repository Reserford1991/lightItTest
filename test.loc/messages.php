<?php
//// Start the session
//session_start();
//?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Messages page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/fbScript.js"></script>
    <?php include'php/Controller.php'; ?>
<body>
<?php $_SESSION['token'] = Controller::CreateToken(); ?>
<br><br>
<div class="center"><div class="fb-login-button"
     data-max-rows="1"
     data-size="medium"
     data-button-type="login_with"
     data-show-faces="false"
     data-auto-logout-link="true"
     data-use-continue-as="false"
     onlogin='window.location="<?php echo $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/messages.php"; ?>";'></div></div>
<div class="center"><div id="hint"><text>*Для добавления и комментирования сообщений выполните вход</text></div></div>
<div class="center"><a href="<?php echo $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/index.php"; ?>">Index page</a></div>
<div class="center"><div id="form"><form action="<?php echo $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/messages.php";?>" method="post">
    <br>
    <textarea id="textbox" type="text" name="textMessage" value="Text"></textarea>
    <br>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
    <input onclick="<?php Controller::saveData(); ?>" type="submit" value="Add Text">
</form></div></div>
<div class="center"><div><br><br><?php echo Controller::getAllMessages(); ?></div></div>
</body>
</html>