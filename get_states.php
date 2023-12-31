<?php
require('connection.inc.php');

if(isset($_POST['countryId'])) {
    $countryId = $_POST['countryId'];

    // Fetch states based on the selected country
    $query = "SELECT id, state_name FROM states WHERE country_id = ?";
    $stmt = $connDropdown->prepare($query);
    $stmt->bind_param('i', $countryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $states = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $states[] = $row;
        }
    }

    echo json_encode($states);
} else {
    echo json_encode(array('error' => 'Invalid request.'));
}
?>
