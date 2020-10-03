<?php
class Connection {
    private $host = 'mysql';
	private $account = 'root';
	private $password = 'root';
	private $database = 'hr';
    private $port = 3306;
    private $connection;

    public function getConnection() {
        try {

			$this->connection = new \mysqli($this->host, $this->account, $this->password, $this->database);
			$this->connection->set_charset('utf8');

		} catch (mysqli_sql_exception $e) {

			sprintf("Connect failed: %s\n", mysqli_connect_error());
			die('DB Connection error');

        }

        return $this->connection;
    }
}
