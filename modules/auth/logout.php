<?php
require_once '../../functions/auth_helper.php';
logout_user();

if (!headers_sent()) {
    header('Location: /PROJECT_DEPOT_PURNOMO/modules/auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="0;url=/PROJECT_DEPOT_PURNOMO/modules/auth/login.php">
    <title>Logging Out</title>
</head>
<body>
    <p>Logging out... If you are not redirected, <a href="/PROJECT_DEPOT_PURNOMO/modules/auth/login.php">click here</a>.</p>
</body>
</html>

