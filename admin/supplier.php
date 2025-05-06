<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['supplierName'];
    $contact = $_POST['supplierContact'];
    $email = $_POST['supplierEmail'];
    $address = $_POST['supplierAddress'];

    $stmt = $conn->prepare("INSERT INTO tbl_suppliers (supplier_name, supplier_contact, supplier_email, supplier_address) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $contact, $email, $address]);

    echo "<script>alert('Supplier added successfully.'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
    exit;
}

// Fetch suppliers from the database
$stmt = $conn->prepare("SELECT * FROM tbl_suppliers");
$stmt->execute();
$suppliers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Online Shopping Admin - Suppliers</title>
    <link rel="stylesheet" href="assets/css/supplier.css">

    <style>
        /* Modal Overlay - covers the entire screen */
        .modal-overlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Fixed positioning */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            justify-content: center;
            align-items: center;
            z-index: 999;
            /* Ensures it's on top of other content */
        }

        /* Modal Content */
        .modal {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            /* Set the width of the modal */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-height: 80%;
            /* Optional: limit max height of modal */
            overflow-y: auto;
            /* Allows scrolling if content is long */
        }

        /* Modal Header */
        .modal h2 {
            margin-top: 0;
        }

        /* Close Button (Cancel) */
        .btn-secondary {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Save Button */
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Align the form elements */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>Suppliers</header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <div class="controls">
            <button class="btn-primary" id="btnAddSupplier" aria-label="Add supplier" style="background-color: blue;">+ Add Supplier</button>
        </div>
        <table aria-label="Suppliers information table" role="grid" aria-describedby="tableSummary">
            <caption id="tableSummary"
                style="text-align:left; padding: 0 0 0.5rem 0; font-weight: 600; font-size: 1.1rem; color:#555;">
                List of suppliers with contact details
            </caption>
            <thead>
                <tr role="row">
                    <th role="columnheader" scope="col">Name</th>
                    <th role="columnheader" scope="col">Contact</th>
                    <th role="columnheader" scope="col">Email</th>
                    <th role="columnheader" scope="col">Address</th>
                    <th role="columnheader" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="suppliersTableBody" role="rowgroup">
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['supplier_contact']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['supplier_email']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['supplier_address']); ?></td>
                        <td>
                            <a href="javascript:void(0)" onclick="viewSupplier(<?php echo $supplier['supplier_id']; ?>)">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal for Viewing Supplier -->
    <div class="modal-overlay" id="viewModalOverlay" role="dialog" aria-modal="true" aria-labelledby="viewModalTitle" tabindex="-1">
        <div class="modal" role="document">
            <h2 id="viewModalTitle">Supplier Details</h2>
            <div id="supplierDetails">
                <!-- Supplier details will be injected here by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnClose">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal for Add Supplier -->
    <div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
        <div class="modal" role="document">
            <h2 id="modalTitle">Add Supplier</h2>
            <form id="supplierForm" method="POST" action="" novalidate>
                <input type="hidden" id="supplierId" name="supplierId" />
                <div class="form-group">
                    <label for="supplierName">Name <span aria-hidden="true" style="color:#dc3545;">*</span></label>
                    <input type="text" id="supplierName" name="supplierName" required maxlength="50" autocomplete="off" />
                    <span class="error-message" aria-live="polite">Please enter a name.</span>
                </div>
                <div class="form-group">
                    <label for="supplierContact">Contact Number <span aria-hidden="true" style="color:#dc3545;">*</span></label>
                    <input type="tel" id="supplierContact" name="supplierContact" required pattern="^[0-9+\-\s()]{6,20}$" autocomplete="off" />
                    <span class="error-message" aria-live="polite">Please enter a valid contact number.</span>
                </div>
                <div class="form-group">
                    <label for="supplierEmail">Email <span aria-hidden="true" style="color:#dc3545;">*</span></label>
                    <input type="email" id="supplierEmail" name="supplierEmail" required autocomplete="off" />
                    <span class="error-message" aria-live="polite">Please enter a valid email.</span>
                </div>
                <div class="form-group">
                    <label for="supplierAddress">Address</label>
                    <textarea id="supplierAddress" name="supplierAddress" maxlength="200" autocomplete="off"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="btnCancel">Cancel</button>
                    <button type="submit" class="btn-primary" id="btnSave">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show the modal when "Add Supplier" is clicked
        document.getElementById('btnAddSupplier').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'flex'; // Changed to 'flex' for centering
        });

        // Close the modal when the "Cancel" button is clicked
        document.getElementById('btnCancel').addEventListener('click', function() {
            document.getElementById('modalOverlay').style.display = 'none';
        });

        // Show supplier details in modal
        function viewSupplier(supplierId) {
            // Fetch supplier details via AJAX
            fetch('get_supplier_details.php?id=' + supplierId)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        const supplierDetails = `
                            <p><strong>Name:</strong> ${data.supplier_name}</p>
                            <p><strong>Contact:</strong> ${data.supplier_contact}</p>
                            <p><strong>Email:</strong> ${data.supplier_email}</p>
                            <p><strong>Address:</strong> ${data.supplier_address}</p>
                        `;
                        document.getElementById('supplierDetails').innerHTML = supplierDetails;
                        document.getElementById('viewModalOverlay').style.display = 'flex';
                    }
                });
        }

        // Close the view modal
        document.getElementById('btnClose').addEventListener('click', function() {
            document.getElementById('viewModalOverlay').style.display = 'none';
        });
    </script>
</body>

</html>