<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Index page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/fbScript.js"></script>
    <?php include_once "php/Controller.php"; ?>
<body>

<?php Controller::createTable(); ?>
<div class="center-vertical">
    <div class="center-index">
        <div class="fb-login-button" data-max-rows="1"
             data-size="medium"
             data-button-type="login_with"
             data-show-faces="false" data-auto-logout-link="true"
             data-use-continue-as="false"
             onlogin='window.location="<?php echo $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/index.php"; ?>";'></div>

        <div id="invitation">
            <text>Пожалуйста, выполните вход</text>
        </div>
        <div id="link"><a
                href="<?php echo $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/messages.php"; ?>">Messages
                page</a></div>
    </div>
</div>
</body>
</html>


