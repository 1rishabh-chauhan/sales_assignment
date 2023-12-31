<?php
require('connection.inc.php');
require('functions.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerName = get_safe_value($connForm, $_POST['customerName']);
    $totalSales = get_safe_value($connForm, $_POST['totalSales']);
    $countryId = get_safe_value($connForm, $_POST['country']);
    $stateId = get_safe_value($connForm, $_POST['state']);
    $cityId = get_safe_value($connForm, $_POST['city']);
    $invoiceDate = get_safe_value($connForm, $_POST['invoiceDate']);

    $countryName = getEntityNameById($connDropdown, 'countries', $countryId);
    $stateName = getEntityNameById($connDropdown, 'states', $stateId);
    $cityName = getEntityNameById($connDropdown, 'cities', $cityId);
    
    $customerImage = uploadFile('customerImage', 'images/');
    $invoiceFile = uploadFile('invoice', 'invoices/');

    if ($customerImage && $invoiceFile) {

        $customerInsertQuery = "INSERT INTO customers (customer_name, total_sales, country, state, city, image, invoice_date) VALUES ('$customerName', '$totalSales', '$countryName', '$stateName', '$cityName', '$customerImage','$invoiceDate')";
        $customerResult = mysqli_query($connForm, $customerInsertQuery);

        if (!$customerResult) {
            die("Error inserting into customers: " . mysqli_error($connForm));
        }

        $customerId = mysqli_insert_id($connForm);

        $invoiceInsertQuery = "INSERT INTO invoices (customer_id, invoice_name) VALUES ('$customerId', '$invoiceFile')";
        $invoiceResult = mysqli_query($connForm, $invoiceInsertQuery);

        if ($customerResult && $invoiceResult) {
            echo "Form data successfully stored in the database.";
        } else {
            echo "Error storing form data: " . mysqli_error($connForm);
        }

    } else {
        echo "Error uploading files.";
    }

} else {
    echo "Invalid request method.";
}
function getEntityNameById($connForm, $tableName, $entityId)
{
    $columnNames = [
        'countries' => 'name',
        'states' => 'state_name',
        'cities' => 'city_name',
    ];

    if (isset($columnNames[$tableName])) {
        $columnName = $columnNames[$tableName];
        $query = "SELECT $columnName FROM $tableName WHERE id = '$entityId'";
        $result = mysqli_query($connForm, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if (isset($row[$columnName])) {
                return $row[$columnName];
            }
        } 
    } 
}

function uploadFile($inputName, $uploadDirectory)
{
    $imageFileType = strtolower(pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION));
    $uniqueFileName = uniqid() . '.' . $imageFileType;
    $targetFile = $uploadDirectory . $uniqueFileName;

    if ($_FILES[$inputName]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        return false;
    }
    if ($imageFileType != "pdf" && $imageFileType != "png") {
        echo "Sorry, only PDF and PNG files are allowed.";
        return false;
    }
    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
        return $uniqueFileName;
    } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
    }
}

if ($customerResult && $invoiceResult) {
    header("Location: success.php");
    exit();
} else {
    echo "Error storing form data: " . mysqli_error($connForm);
}
?>