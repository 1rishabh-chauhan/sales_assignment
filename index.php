<?php
require('connection.inc.php');
require('functions.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Form</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
        <!-- jQuery (CDN link) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS (CDN link) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container custom-form">
        <h2 class="text-center mb-4">Sales Form</h2>

        <!-- Sales Form -->
        <form id="salesForm" action="process.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="customerName">Customer Name</label>
                <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter customer name" required>
            </div>

            <div class="form-group">
                <label for="totalSales">Total Sales</label>
                <input type="number" class="form-control" id="totalSales" name="totalSales" placeholder="Enter total sales" required>
            </div>

            <div class="form-group">
            <label for="country">Select Country:</label>
            <select id="country" name="country" onchange="getStates(this.value)">
            <option value="">Select country</option>
            <?php
                // Fetch countries from the database
                
                $result = mysqli_query($connDropdown,"SELECT id, name FROM countries Order by name desc");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                
                }  
            ?>    
            
            </select>   
            </div>
            <div class="form-group">
                <label for="state">Select State:</label>
                <select id="state" name="state" onchange="getCities(this.value)">
                    <option value="">Select a country first</option>
                </select>
            </div>

            <div class="form-group"> 
                <label for="city">Select City:</label>
                <select id="city" name="city">
                <option value="">Select a state first</option>
            </select>
            </div>
            <div class="form-group">
                <label for="invoice">Invoice (PDF only)</label>
                <input type="file" class="form-control-file" id="invoice" name="invoice" accept=".pdf" multiple required>
            </div>
            <div class="form-group">
                <label for="customerImage">Customer Image (PNG, 64x64)</label>
                <input type="file" class="form-control-file" id="customerImage" name="customerImage" accept=".png" required>
            </div>
            <div class="form-group">
                <label for="invoiceDate">Invoice Date:</label>
                <input type="date" class="form-control" id="invoiceDate" name="invoiceDate" required max="<?php echo date('Y-m-d'); ?>">
            </div>

            <button type="submit" id ="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    

    
<script>
        function getStates(countryId) {
            $.ajax({
                type: 'POST',
                url: 'get_states.php',
                data: { countryId: countryId },
                dataType: 'json',
                success: function(data) {
                    var stateDropdown = $('#state');
                    stateDropdown.empty();

                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            stateDropdown.append($('<option>').text(data[i].state_name).attr('value', data[i].id));
                        }
                    } else {
                        stateDropdown.append($('<option>').text('No states found').attr('value', ''));
                    }

                    $('#city').empty().append($('<option>').text('Select a state first').attr('value', ''));
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log('XHR:', xhr);
                    console.log('Status:', status);
                }
            });
        }


        function getCities(stateId) {
        $.ajax({
            type: 'POST',
            url: 'get_cities.php',
            data: { stateId: stateId },  // Fix the parameter name here
            dataType: 'json',
            success: function (data) {
                var cityDropdown = $('#city');
                cityDropdown.empty();

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        cityDropdown.append($('<option>').text(data[i].city_name).attr('value', data[i].id));  // Fix the field names here
                    }
                } else {
                    cityDropdown.append($('<option>').text('No cities found').attr('value', ''));
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                console.log('XHR:', xhr);
                console.log('Status:', status);
            }
        });
    }
</script>
</body>
</html>
