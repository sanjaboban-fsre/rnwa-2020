<?php
require_once('./settings.php');
require_once('./apiHandler.php');

session_start();

if (isset($_GET['code'])) {
    try {
        $g_handle = new GoogleApiHandler();
        $data = $g_handle->getAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

        $user_info = $g_handle->getUserProfile($data["access_token"]);

        $_SESSION['logged_in'] = true;
        $_SESSION['access_token'] = $data["access_token"];

        header("Location: rest_2_oauth2 ./../../../api/v1/jobs.php");

    } catch(\Exception $e) {
        echo $e->getMessage();
        exit();
    }
}
