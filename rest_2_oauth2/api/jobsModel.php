<?php

class Jobs {
    private $job_id;
    private $job_title;
    private $min_salary;
    private $max_salary;

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_jobs() {
        $query = "SELECT * FROM jobs";
        $dbresult = $this->conn->query($query);

        header('Content-Type: application/json');

        if (!$dbresult->num_rows) {
            http_response_code(404);
            die(json_encode(array("message" => "No Jobs found")));
        }

        $response = [];
        while ($row = $dbresult->fetch_assoc()) {
            $response[] = $row;
        }

        http_response_code(200);
        return json_encode($response);
    }

    public function get_job($job_id) {
        $query = "SELECT * FROM jobs WHERE job_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $job_id);
        $stmt->execute();
        $dbresult = $stmt->get_result();

        header('Content-Type: application/json');

        if (!$dbresult->num_rows) {
            http_response_code(404);
            die(json_encode(array("message" => "No Jobs found")));
        }

        $response = [];
        while ($row = $dbresult->fetch_assoc()) {
            $response[] = $row;
        }

        http_response_code(200);
        return json_encode($response);
    }

    public function create_job($job_id, $job_title, $min_salary, $max_salary) {
        $query = "INSERT INTO jobs (job_id, job_title, min_salary, max_salary) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssss', $job_id, $job_title, $min_salary, $max_salary);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Job creation was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Job creation successful"));
    }

    public function update_job($job_id, $job_title, $min_salary, $max_salary) {
        $query = "UPDATE jobs SET job_title = ?, min_salary = ?, max_salary = ? WHERE job_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssss', $job_title, $min_salary, $max_salary, $job_id);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Job update was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Job update successful"));
    }

    public function delete_job($job_id) {
        $query = "DELETE FROM jobs WHERE job_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $job_id);
        $stmt->execute();

        header('Content-Type: application/json');

        if ($stmt->error) {
            http_response_code(500);
            die(json_encode(array("message" => "Deleting job was usuccessful, error : " . $stmt->error)));
        }

        http_response_code(200);
        return json_encode(array("message" => "Job deletion successful"));

    }
}
