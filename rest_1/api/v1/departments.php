<?php

include("../connection.php");
include("../departmentsModel.php");

$db = new Connection();
$conn = $db->getConnection();

$departments = new Departments($conn);

$r_method = $_SERVER["REQUEST_METHOD"];
switch ($r_method) {

    case 'GET':
        if (isset($_GET["department_id"])) {
            $department_id = $_GET["department_id"];
            echo $departments->get_department($department_id);
            exit();
        }
        echo $departments->get_departments();
    break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'));
        if (
            !empty($data->department_id) &&
            !empty($data->department_name) &&
            (!empty($data->manager_id) || $data->manager_id == null) &&
            !empty($data->location_id)
        ) {
            echo $departments->create_department(
                $data->department_id,
                $data->department_name,
                $data->manager_id,
                $data->location_id
            );
            exit();
        }

        http_response_code(400);
        die(json_encode(array("message" => "Missing department parameters")));
    break;

    case 'PUT':
        if (!isset($_GET["department_id"])) {
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode(array("message" => "Missing Department ID")));
        }

        $department_id = $_GET["department_id"];
        $data = json_decode(file_get_contents('php://input'));
        if (
            !empty($data->department_name) &&
            (!empty($data->manager_id) || $data->manager_id == null) &&
            !empty($data->location_id)
        ) {
            echo $departments->update_department(
                $department_id,
                $data->department_name,
                $data->manager_id,
                $data->location_id
            );
            exit();
        }

        http_response_code(400);
        die(json_encode(array("message" => "Missing department parameters")));
    break;

    case 'DELETE':
        if (!isset($_GET["department_id"])) {
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode(array("message" => "Missing Department ID")));
        }
        $department_id = $_GET["department_id"];
        echo $departments->delete_department($department_id);
    break;
}
