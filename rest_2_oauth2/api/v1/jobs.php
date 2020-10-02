<?php

include("../connection.php");
include("../jobsModel.php");

session_start();

if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    die('Login required. <a href="./../../auth/">Login here</a>');
}

$db = new Connection();
$conn = $db->getConnection();

$jobs = new Jobs($conn);

$r_method = $_SERVER["REQUEST_METHOD"];
switch ($r_method) {

    case 'GET':
        if (isset($_GET["job_id"])) {
            $job_id = $_GET["job_id"];
            echo $jobs->get_job($job_id);
            exit();
        }
        echo $jobs->get_jobs();
    break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        if (
            !empty($data->job_id) &&
            !empty($data->job_title) &&
            !empty($data->min_salary) &&
            !empty($data->max_salary)
        ) {
            echo $jobs->create_job(
                $data->job_id,
                $data->job_title,
                $data->min_salary,
                $data->max_salary
            );
            exit();
        }

        http_response_code(400);
        die(json_encode(array("message" => "Missing job parameters")));
    break;

    case 'PUT':
        if (!isset($_GET["job_id"])) {
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode(array("message" => "Missing Job ID")));
        }

        $job_id = $_GET["job_id"];
        $data = json_decode(file_get_contents('php://input'));
        if (
            !empty($data->job_title) &&
            !empty($data->min_salary) &&
            !empty($data->max_salary)
        ) {
            echo $jobs->update_job(
                $job_id,
                $data->job_title,
                $data->min_salary,
                $data->max_salary
            );
            exit();
        }

        http_response_code(400);
        die(json_encode(array("message" => "Missing job parameters")));
    break;

    case 'DELETE':
        if (!isset($_GET["job_id"])) {
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode(array("message" => "Missing Job ID")));
        }
        $job_id = $_GET["job_id"];
        echo $jobs->delete_job($job_id);
    break;
}
