<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

include '../connection/database.php';

// Handling Add Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supplier_purchase'])) {
    $supplierName = $_POST['supplierName'];
    $supplierEmail = $_POST['supplierEmail'];
    $requestDate = $_POST['requestDate'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO tbl_purchase_suppliers (supplier_name, supplier_email, request_date, item, quantity)
            VALUES (:supplier_name, :supplier_email, :request_date, :item, :quantity)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':supplier_name', $supplierName);
    $stmt->bindParam(':supplier_email', $supplierEmail);
    $stmt->bindParam(':request_date', $requestDate);
    $stmt->bindParam(':item', $item);
    $stmt->bindParam(':quantity', $quantity);

    if ($stmt->execute()) {
        // After successful add, redirect back to the current page (using JavaScript).
        echo "<script>alert('Supplier request added successfully!'); window.location.href = window.location.href;</script>";
        exit(); // Stop further script execution after redirect
    } else {
        echo "<script>alert('Error adding supplier request.'); window.location.href = window.location.href;</script>";
        exit();
    }
}

// Handling Edit Request
if (isset($_POST['edit_supplier'])) {
    $id = $_POST['id'];
    $supplierName = $_POST['supplierName'];
    $supplierEmail = $_POST['supplierEmail'];
    $requestDate = $_POST['requestDate'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE tbl_purchase_suppliers SET supplier_name = :supplier_name, supplier_email = :supplier_email,
            request_date = :request_date, item = :item, quantity = :quantity WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':supplier_name', $supplierName);
    $stmt->bindParam(':supplier_email', $supplierEmail);
    $stmt->bindParam(':request_date', $requestDate);
    $stmt->bindParam(':item', $item);
    $stmt->bindParam(':quantity', $quantity);

    if ($stmt->execute()) {
        // After successful update, redirect back to the current page (using JavaScript).
        echo "<script>alert('Supplier request updated successfully!'); window.location.href = window.location.href;</script>";
        exit();
    } else {
        echo "<script>alert('Error updating supplier request.'); window.location.href = window.location.href;</script>";
        exit();
    }
}

// Handling Delete Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM tbl_purchase_suppliers WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Supplier request deleted successfully!'); window.location.href = 'purchase_supplier.php';</script>";
        exit();
    } else {
        echo "<script>alert('Supplier request deleted successfully!'); window.location.href = 'purchase_supplier.php';</script>";
        exit();
    }
}

$fetchQuery = "SELECT * FROM tbl_purchase_suppliers";
$records = $conn->query($fetchQuery)->fetchAll(PDO::FETCH_ASSOC);
?>



<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        MOBILE HUB Admin Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        /* Edit Modal */
        #editModal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            /* Hide by default */
            justify-content: center;
            align-items: center;
            z-index: 9000;
        }

        /* Delete Modal */
        #deleteModal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            /* Hide by default */
            justify-content: center;
            align-items: center;
            z-index: 9000;
        }
    </style>
</head>

<body class="bg-[#f8f9fa] min-h-screen flex flex-col">
    <div class="flex flex-1 min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-[#0f2a47] w-72 flex flex-col text-white">
            <div class="flex flex-col items-center py-6 border-b border-[#0a1a2e]">
                <img alt="" class="rounded-full w-20 h-20 object-cover" height="80" src="" width="" />
                <h2 class="mt-3 font-semibold text-lg">
                    Jeffrey DelaCruz
                </h2>
            </div>
            <nav class="flex-1 overflow-y-auto mt-6 px-3">
                <ul class="space-y-1 text-sm">
                    <!-- Dashboard -->
                    <li>
                        <a href="admin.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-tachometer-alt mr-3 text-[#f0a500]"></i>
                            Dashboard
                        </a>
                    </li>
                    <!-- Record Management -->
                    <li>
                        <a href="record_management.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-clipboard-list mr-3 text-[#f0a500]"></i>
                            Record Management
                        </a>
                    </li>
                    <!-- Supplier -->
                    <li>
                        <a href="supplier.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-truck mr-3 text-[#6a4a9a]"></i>
                            Supplier
                        </a>
                    </li>
                    <!-- Product -->
                    <li>
                        <a href="product.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-warehouse mr-3 text-[#4ab98a]"></i>
                            Product
                        </a>
                    </li>
                    <!-- Purchase Requests -->
                    <li>
                        <button aria-controls="purchase-requests-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="purchase-requests-btn" type="button">
                            <i class="fas fa-file-alt mr-3 text-[#b94a8a]"></i>
                            Purchase Requests
                            <i class="fas fa-chevron-down ml-auto text-xs"></i>
                        </button>
                        <ul class="hidden mt-1 ml-8 space-y-1 text-xs text-[#a0b8d6]" id="purchase-requests-menu">
                            <li>
                                <a href="purchase_supplier.php" class="w-full text-left block px-2 py-1 rounded hover:text-white hover:bg-[#0a1a2e]">
                                    Suppliers
                                </a>
                            </li>
                            <li>
                                <a href="lead_time.php" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2">
                                    Lead Time
                                </a>
                            </li>
                        </ul>

                    </li>
                    <!-- Inventory -->
                    <li>
                        <a href="inventory.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-warehouse mr-3 text-[#4ab98a]"></i>
                            Inventory
                        </a>
                    </li>
                    <!-- Orders -->
                    <li>
                        <a href="orders.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-shopping-cart mr-3 text-[#d9a84a]"></i>
                            Orders
                        </a>
                    </li>
                    <!-- Sales (POS) -->
                    <li>
                        <a href="pos.php" aria-controls="inventory-menu" aria-expanded="false" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="inventory-btn">
                            <i class="fas fa-cash-register mr-3 text-[#db4437]"></i>
                            Sales (POS)
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <header class="flex items-center justify-between bg-[#0f2a47] px-4 md:px-6 h-14 text-white">
                <div class="flex items-center space-x-4">
                    <button aria-label="Back to main site" class="text-white text-lg focus:outline-none">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="font-semibold text-lg select-none">
                        MOBILE HUB Admin
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2 bg-[#ff5722] px-3 py-1 rounded cursor-pointer select-none">
                        <img alt="" class="rounded-full w-8 h-8 object-cover" height="" src="" width="" />
                        <span class="text-sm font-semibold">Jeffrey</span>
                    </div>
                    <button aria-label="Logout" onclick="window.location.href='admin_logout.php'" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2">
                        <i class="fas fa-sign-out-alt mr-3 text-[#f0a500]"></i>
                        Logout
                    </button>
                </div>
            </header>
            <main class="p-4 md:p-6 space-y-6 bg-[#f8f9fa] flex-1 overflow-auto" id="main-content">
                <div id="supplier-record-management">
                    <h2 class="text-lg font-semibold mb-4">Supplier Record Management</h2>
                    <div id="form-container">
                        <form id="purchaseForm" action="" method="POST">
                            <div>
                                <label for="supplierName">Supplier Name</label>
                                <input type="text" id="supplierName" name="supplierName" placeholder="Supplier Name" required />
                            </div>
                            <div>
                                <label for="supplierEmail">Supplier Email</label>
                                <input type="email" id="supplierEmail" name="supplierEmail" placeholder="Supplier Email" required />
                            </div>
                            <div>
                                <label for="requestDate">Request Date</label>
                                <input type="date" id="requestDate" name="requestDate" required />
                            </div>
                            <div>
                                <label for="item">Item</label>
                                <input type="text" id="item" name="item" placeholder="Item Description" required />
                            </div>
                            <div>
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1" placeholder="Quantity" required />
                            </div>
                            <div>
                                <button type="submit" id="submitBtn" name="supplier_purchase">Add Request</button>
                            </div>
                        </form>
                    </div>

                    <!-- Displaying Records in Table -->
                    <table id="recordsTable" aria-label="Purchased Requests Records">
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Supplier Email</th>
                                <th>Request Date</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recordsBody">
                            <!-- PHP to loop through records and display them -->
                            <?php foreach ($records as $record) { ?>
                                <tr id="row-<?php echo $record['id']; ?>">
                                    <td class="editable" data-name="supplier_name"><?php echo htmlspecialchars($record['supplier_name']); ?></td>
                                    <td class="editable" data-name="supplier_email"><?php echo htmlspecialchars($record['supplier_email']); ?></td>
                                    <td class="editable" data-name="request_date"><?php echo htmlspecialchars($record['request_date']); ?></td>
                                    <td class="editable" data-name="item"><?php echo htmlspecialchars($record['item']); ?></td>
                                    <td class="editable" data-name="quantity"><?php echo htmlspecialchars($record['quantity']); ?></td>
                                    <td>
                                        <button class="text-blue-500 hover:underline edit-btn" data-id="<?php echo $record['id']; ?>">Edit</button>
                                        <button class="text-red-500 hover:underline delete-btn" data-id="<?php echo $record['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-md shadow-lg w-1/3">
            <h3 class="text-xl font-semibold mb-4">Edit Supplier Request</h3>
            <form id="editForm">
                <div>
                    <label for="editSupplierName">Supplier Name</label>
                    <input type="text" id="editSupplierName" name="supplierName" required />
                </div>
                <div>
                    <label for="editSupplierEmail">Supplier Email</label>
                    <input type="email" id="editSupplierEmail" name="supplierEmail" required />
                </div>
                <div>
                    <label for="editRequestDate">Request Date</label>
                    <input type="date" id="editRequestDate" name="requestDate" required />
                </div>
                <div>
                    <label for="editItem">Item</label>
                    <input type="text" id="editItem" name="item" required />
                </div>
                <div>
                    <label for="editQuantity">Quantity</label>
                    <input type="number" id="editQuantity" name="quantity" min="1" required />
                </div>
                <input type="hidden" id="editId" name="id" />
                <div>
                    <button type="submit" style="background-color: green; padding: 10px; color: white;" id="saveBtn">Save</button>
                    <button type="button" style="background-color: red; padding: 10px; color: white;" id="cancelEditBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-md shadow-lg w-1/3">
            <h3 class="text-xl font-semibold mb-4">Delete Supplier Request</h3>
            <p>Are you sure you want to delete this supplier request?</p>
            <div style="margin-top: 20px;">
                <button id="confirmDeleteBtn" style="background-color: red; padding: 10px; color: white;" class="text-red-500">Delete</button>
                <button id="cancelDeleteBtn" style="background-color: gray; padding: 10px; color: white;">Cancel</button>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("purchase-requests-btn");
            const submenu = document.getElementById("purchase-requests-menu");

            toggleBtn.addEventListener("click", function() {
                const expanded = toggleBtn.getAttribute("aria-expanded") === "true";
                toggleBtn.setAttribute("aria-expanded", !expanded);
                submenu.classList.toggle("hidden");
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Edit and Delete Button handlers
            const editButtons = document.querySelectorAll('.edit-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');

            // Open Edit Modal
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const rowId = this.getAttribute('data-id');
                    const row = document.getElementById('row-' + rowId);
                    const cells = row.querySelectorAll('.editable');

                    // Populate the fields in the Edit modal
                    document.getElementById('editSupplierName').value = cells[0].textContent.trim();
                    document.getElementById('editSupplierEmail').value = cells[1].textContent.trim();
                    document.getElementById('editRequestDate').value = cells[2].textContent.trim();
                    document.getElementById('editItem').value = cells[3].textContent.trim();
                    document.getElementById('editQuantity').value = cells[4].textContent.trim();
                    document.getElementById('editId').value = rowId;

                    // Show Edit Modal
                    editModal.classList.remove('hidden');
                    editModal.style.display = 'flex'; // Ensure the modal is shown
                });
            });

            // Open Delete Modal
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const rowId = this.getAttribute('data-id');

                    // Show Delete Modal
                    deleteModal.classList.remove('hidden');
                    deleteModal.style.display = 'flex'; // Ensure the modal is shown

                    // Handle Confirm Delete
                    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                    confirmDeleteBtn.onclick = function() {
                        window.location.href = "?delete=" + rowId; // Redirect to delete action
                    };
                });
            });

            // Handle Edit Form Submission (Save)
            const editForm = document.getElementById('editForm');
            editForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(editForm);
                formData.append('edit_supplier', true);

                fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    }).then(response => response.text())
                    .then(responseText => {
                        alert('Supplier request updated successfully!');
                        window.location.reload(); // Reload the page to show the updated record
                    }).catch(error => {
                        alert('Error updating supplier request.');
                    });
            });

            // Close Edit Modal on Cancel
            document.getElementById('cancelEditBtn').addEventListener('click', function() {
                editModal.classList.add('hidden');
                editModal.style.display = 'none'; // Hide the modal
            });

            // Close Delete Modal on Cancel
            document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                deleteModal.style.display = 'none'; // Hide the modal
            });
        });
    </script>

</body>

</html>