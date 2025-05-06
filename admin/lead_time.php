<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php'; // Include your database connection file

// Handle form submission for adding a new request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supplierName'])) {
    // Get the form data
    $supplierName = $_POST['supplierName'];
    $requestDate = $_POST['requestDate'];
    $leadTime = $_POST['leadTime'];
    $expectedDelivery = $_POST['expectedDelivery'];

    // Prepare the SQL query to insert data into the table
    $sql = "INSERT INTO tbl_purchase_lead (supplier_name, request_date, lead_time, expected_delivery)
            VALUES (:supplier_name, :request_date, :lead_time, :expected_delivery)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':supplier_name', $supplierName);
    $stmt->bindParam(':request_date', $requestDate);
    $stmt->bindParam(':lead_time', $leadTime);
    $stmt->bindParam(':expected_delivery', $expectedDelivery);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Purchase request added successfully!'); window.location.href = 'lead_time.php';</script>";
    } else {
        echo "<script>alert('Error adding purchase request.'); window.location.href = 'lead_time.php';</script>";
    }
    exit(); // Stop further script execution after the response
}

// Handle update request (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateRequest'])) {
    $id = $_POST['id'];
    $leadTime = $_POST['leadTime'];
    $requestDate = $_POST['requestDate'];

    // Calculate the expected delivery date based on the lead time
    $dateParts = explode('-', $requestDate);
    $requestDateObj = new DateTime("$dateParts[0]-$dateParts[1]-$dateParts[2]");
    $requestDateObj->modify("+$leadTime days");
    $expectedDelivery = $requestDateObj->format('Y-m-d');

    // Update the record in the database
    $updateQuery = "UPDATE tbl_purchase_lead SET lead_time = :lead_time, expected_delivery = :expected_delivery WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':lead_time', $leadTime);
    $stmt->bindParam(':expected_delivery', $expectedDelivery);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Request updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating request.']);
    }
    exit(); // Stop further script execution after the response
}

// Handle delete request (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeRequest'])) {
    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM tbl_purchase_lead WHERE id = :id";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Request deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting request.']);
    }
    exit(); // Stop further script execution after the response
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Admin - Lead Time Purchase Requests</title>
    <link rel="stylesheet" href="assets/css/lead_time.css">
</head>

<body>
    <header>
        Lead Time Purchase Request
    </header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <h2>Add New Purchase Request</h2>
        <form id="addRequestForm" method="POST" autocomplete="off">
            <label>
                Supplier Name
                <input type="text" name="supplierName" placeholder="Enter supplier name" required />
            </label>
            <label>
                Request Date
                <input type="date" id="requestDate" name="requestDate" required />
            </label>
            <label>
                Lead Time (days)
                <input type="number" id="leadTime" name="leadTime" placeholder="Enter days" min="0" required />
            </label>
            <label>
                Expected Delivery
                <input type="date" id="expectedDelivery" name="expectedDelivery" readonly />
            </label>
            <button type="submit">Add Request</button>
        </form>

        <h2>Purchase Requests</h2>
        <table id="requestsTable" aria-label="Purchase Requests Table">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Request Date</th>
                    <th>Lead Time (days)</th>
                    <th>Expected Delivery</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP to loop through records and display them -->
                <?php
                $fetchQuery = "SELECT * FROM tbl_purchase_lead";
                $records = $conn->query($fetchQuery)->fetchAll(PDO::FETCH_ASSOC);
                foreach ($records as $record) {
                    echo "<tr id='row_{$record['id']}'>
                            <td>{$record['supplier_name']}</td>
                            <td>{$record['request_date']}</td>
                            <td><input type='number' class='lead-time-input' value='{$record['lead_time']}' data-id='{$record['id']}' data-requestdate='{$record['request_date']}' /></td>
                            <td>{$record['expected_delivery']}</td>
                            <td>
                                <button class='delete-btn' data-id='{$record['id']}'>Remove</button>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <script>
        // Handle Lead Time input change
        document.querySelectorAll('.lead-time-input').forEach(function(input) {
            input.addEventListener('input', function() {
                var leadTime = parseInt(this.value);
                var requestDate = this.getAttribute('data-requestdate');
                var id = this.getAttribute('data-id');

                if (!isNaN(leadTime)) {
                    // Calculate the new expected delivery date
                    var dateParts = requestDate.split("-");
                    var requestDateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                    requestDateObj.setDate(requestDateObj.getDate() + leadTime);
                    var expectedDelivery = requestDateObj.toISOString().split('T')[0];

                    // Update the expected delivery cell
                    var row = this.closest('tr');
                    row.querySelector('td:nth-child(4)').textContent = expectedDelivery;

                    // Send the updated data to the server
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    };
                    xhr.send('updateRequest=1&id=' + id + '&leadTime=' + leadTime + '&requestDate=' + requestDate);
                }
            });
        });

        // Delete request functionality
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                if (confirm("Are you sure you want to remove this request?")) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            alert(response.message);
                            document.getElementById('row_' + id).remove(); // Remove the row from the table
                        } else {
                            alert(response.message);
                        }
                    };

                    xhr.send('removeRequest=1&id=' + id);
                }
            });
        });
    </script>

    <script>
        // Function to update the expected delivery date dynamically
        function updateExpectedDelivery() {
            var requestDate = document.getElementById('requestDate').value;
            var leadTime = parseInt(document.getElementById('leadTime').value);

            // Check if both request date and lead time are provided
            if (requestDate && !isNaN(leadTime)) {
                // Split the request date into year, month, and day
                var dateParts = requestDate.split("-");
                var requestDateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);

                // Add the lead time to the request date
                requestDateObj.setDate(requestDateObj.getDate() + leadTime);

                // Format the new expected delivery date
                var expectedDelivery = requestDateObj.toISOString().split('T')[0];

                // Update the expected delivery input field
                document.getElementById('expectedDelivery').value = expectedDelivery;
            }
        }

        // Add event listeners to the input fields for Request Date and Lead Time
        document.getElementById('requestDate').addEventListener('change', updateExpectedDelivery);
        document.getElementById('leadTime').addEventListener('input', updateExpectedDelivery);
    </script>

</body>

</html>