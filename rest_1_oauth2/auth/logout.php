<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
}
if (isset($_SESSION['access_token'])) {
    unset($_SESSION['access_token']);
}
session_destroy();
header("Location: rest_1_oauth2 ./../../api/v1/departments.php");
