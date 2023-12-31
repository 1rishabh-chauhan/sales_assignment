<?php
require('functions.inc.php');
require('connection.inc.php');

// Check if stateId is set and not empty
if (isset($_POST['stateId']) && !empty($_POST['stateId'])) {
    // Sanitize the input to prevent SQL injection
    $stateId = get_safe_value($connDropdown, $_POST['stateId']);

    // Query to get cities based on the selected state
    $query = "SELECT id, city_name FROM cities WHERE state_id = '$stateId'";
    $result = mysqli_query($connDropdown, $query);

    // Check if the query was successful
    if ($result) {
        $cities = array();

        // Fetch the data
        while ($row = mysqli_fetch_assoc($result)) {
            $cities[] = $row;
        }

        // Return the data as JSON
        echo json_encode($cities);
    } else {
        // Handle the error if the query fails
        echo json_encode(array('error' => 'Error executing query'));
    }
} else {
    // Handle the case where stateId is not set or empty
    echo json_encode(array('error' => 'State ID not provided'));
}
?>
