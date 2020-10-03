<?php
$html = "</br></br>";
$conn = new mysqli('mysql', 'root', 'root', 'hr');

if ($conn -> connect_errno) {
    $html .= "Failed to connect to MySQL: " . $conn -> connect_error;
    die($html);
}

$sql = "SELECT first_name, last_name, email, phone_number, hire_date, salary FROM employees WHERE 1 = 1";

if (isset($_GET["search_term"]) && $_GET["search_term"] != "") {
    $search_term = $conn->real_escape_string($_GET["search_term"]);
    $sql .= "  AND first_name LIKE '%$search_term%' OR last_name LIKE '%$search_term%'";
}

$dbresult = $conn->query($sql);

if(!$dbresult->num_rows) {
    $html .= "Didn't find any matching results.";
    die($html);
}

// Initialize HTML variable
$html = "";
// Iterate through db results and create HTML Table Rows
// Create table row counter for first column
$trc = 1;
while ($row = $dbresult->fetch_assoc()) {
    $html_row = <<<ROW
    <tr>
        <th scope="row">{$trc}</th>
        <td>{$row["first_name"]}</td>
        <td>{$row["last_name"]}</td>
        <td>{$row["email"]}</td>
        <td>{$row["phone_number"]}</td>
        <td>{$row["hire_date"]}</td>
        <td>{$row["salary"]}</td>
    </tr>
ROW;
    $html .= $html_row;
    $trc++;
}


$html .= "</tbody>";
$html .= "</table>";

echo $html;
