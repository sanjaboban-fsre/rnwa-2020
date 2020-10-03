<?php

class Departments {
    private $department_id;
    private $department_name;
    private $manager_id;
    private $location_id;

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_departments() {
        $query = "SELECT * FROM departments";
        $dbresult = $this->conn->query($query);

        header('Content-Type: application/json');

        if (!$dbresult->num_rows) {
            http_response_code(404);
            die(json_encode(array("message" => "No Departments found")));
        }

        $response = [];
        while ($row = $dbresult->fetch_assoc()) {
            $response[] = $row;
        }

        http_response_code(200);
        return json_encode($response);
    }

    public function get_department($department_id) {
        $query = "SELECT * FROM departments WHERE department_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $department_id);
        $stmt->execute();
        $dbresult = $stmt->get_result();

        header('Content-Type: application/json');

        if (!$dbresult->num_rows) {
            http_response_code(404);
            die(json_encode(array("message" => "No Departments found")));
        }

        $response = [];
        while ($row = $dbresult->fetch_assoc()) {
            $response[] = $row;
        }

        http_response_code(200);
        return json_encode($response);
    }

    public function create_department($department_id, $department_name, $manager_id, $location_id) {
        $query = "INSERT INTO departments (department_id, department_name, manager_id, location_id) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('isii', $department_id, $department_name, $manager_id, $location_id);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Department creation was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Department creation successful"));
    }

    public function update_department($department_id, $department_name, $manager_id, $location_id) {
        $query = "UPDATE departments SET department_name = ?, manager_id = ?, location_id = ? WHERE department_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('siii', $department_name, $manager_id, $location_id, $department_id);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Department update was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Department update successful"));
    }

    public function delete_department($department_id) {
        $query = "DELETE FROM departments WHERE department_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $department_id);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Deleting department was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Department deletion successful"));

    }
}
