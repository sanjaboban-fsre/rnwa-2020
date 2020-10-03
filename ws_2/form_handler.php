<?php
$html = "</br></br>";
$conn = new mysqli('mysql', 'root', 'root', 'hr');

if ($conn -> connect_errno) {
    $html .= "Failed to connect to MySQL: " . $conn -> connect_error;
    die($html);
}

$sql = <<<SQL
SELECT d.department_name,
       l.city,
       l.street_address,
       c.country_name,
       c.country_id AS country_code,
       r.region_name
FROM regions r
         INNER JOIN countries c on r.region_id = c.region_id
         INNER JOIN locations l on c.country_id = l.country_id
         INNER JOIN departments d on l.location_id = d.location_id
WHERE 1 = 1
SQL;

if (isset($_POST["region_name"]) && $_POST["region_name"] != "") {
    $sql .= " AND region_name LIKE '%{$_POST['region_name']}%'";
}

if (isset($_POST["country_name"]) && $_POST["country_name"] != "") {
    $sql .= " AND country_name LIKE '%{$_POST['country_name']}%'";
}

$dbresult = $conn->query($sql);

if(!$dbresult->num_rows) {
    $html .= "Didn't find any matching results.";
    die($html);
}

// Define start of HTML table here, as we're sure we have some results
$html .= <<<HTML
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Department Name</th>
      <th scope="col">City</th>
      <th scope="col">Street Address</th>
      <th scope="col">Country Name</th>
      <th scope="col">Country Code</th>
      <th scope="col">Region Name</th>
    </tr>
  </thead>
  <tbody>
HTML;

// Iterate through db results and create HTML Table Rows
// Create table row counter for first column
$trc = 1;
while ($row = $dbresult->fetch_assoc()) {
    $html_row = <<<ROW
    <tr>
        <th scope="row">{$trc}</th>
        <td>{$row["department_name"]}</td>
        <td>{$row["city"]}</td>
        <td>{$row["street_address"]}</td>
        <td>{$row["country_name"]}</td>
        <td>{$row["country_code"]}</td>
        <td>{$row["region_name"]}</td>
    </tr>
ROW;
    $html .= $html_row;
    $trc++;
}


$html .= "</tbody>";
$html .= "</table>";

echo $html;
