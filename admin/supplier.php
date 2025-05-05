<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Online Shopping Admin - Suppliers</title>
    <style>
        /* Reset and base */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f6f9;
            color: #333;
            max-width: 960px;
            margin-left: auto;
            margin-right: auto;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1.25rem 2rem;
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            flex-shrink: 0;
            user-select: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .back-button {
            position: absolute;
            top: 20px;
            /* Distance from the top */
            left: 20px;
            /* Distance from the left */
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #084aec;
        }

        main {
            flex-grow: 1;
            padding: 1.5rem 2rem;
            overflow: auto;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 1rem 0;
        }

        h1 {
            margin: 0 0 1.5rem 0;
            font-size: 2rem;
            text-align: center;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        th,
        td {
            padding: 0.8rem 1rem;
            text-align: left;
            font-size: 1rem;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background: #e9f0ff;
        }

        /* Buttons */
        button {
            cursor: pointer;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.35rem;
            transition: background-color 0.3s ease;
            user-select: none;
            min-width: 65px;
        }

        button:focus {
            outline: 3px solid #0056b3;
            outline-offset: 2px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #cc9a06;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #a71d2a;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        /* Controls container */
        .controls {
            margin-bottom: 1.25rem;
            text-align: right;
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 2rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 0.6rem;
            width: 100%;
            max-width: 480px;
            max-height: 85%;
            overflow-y: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            padding: 2rem 2.5rem;
            display: flex;
            flex-direction: column;
        }

        .modal h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.7rem;
            color: #007bff;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.05rem;
        }

        input,
        textarea {
            font-size: 1rem;
            padding: 0.6rem 0.75rem;
            border: 1.5px solid #ccc;
            border-radius: 0.4rem;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            min-height: 90px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        /* Validation error messages */
        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 0.25rem;
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            body {
                max-width: 100vw;
                min-height: 100vh;
            }

            main {
                margin: 1rem;
                padding: 1rem;
                box-shadow: none;
                border-radius: 0;
            }

            .modal {
                max-width: 95vw;
                padding: 1.5rem 1.75rem;
                max-height: 90vh;
            }
        }
    </style>
</head>

<body>
    <header> Suppliers</header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <div class="controls">
            <button class="btn-primary" id="btnAddSupplier" aria-label="Add supplier">+ Add Supplier</button>
        </div>
        <table aria-label="Suppliers information table" role="grid" aria-describedby="tableSummary">
            <caption id="tableSummary"
                style="text-align:left; padding: 0 0 0.5rem 0; font-weight: 600; font-size: 1.1rem; color:#555;">List of
                suppliers with contact details</caption>
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
                <!-- Suppliers data goes here -->
            </tbody>
        </table>
    </main>

    <!-- Modal for add/edit supplier -->
    <div class="modal-overlay" id="modalOverlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle"
        tabindex="-1">
        <div class="modal" role="document">
            <h2 id="modalTitle">Add Supplier</h2>
            <form id="supplierForm" novalidate>
                <input type="hidden" id="supplierId" />
                <div class="form-group">
                    <label for="supplierName">Name <span aria-hidden="true" style="color:#dc3545;">*</span></label>
                    <input type="text" id="supplierName" name="supplierName" required maxlength="50" autocomplete="off" />
                    <span class="error-message" aria-live="polite">Please enter a name.</span>
                </div>
                <div class="form-group">
                    <label for="supplierContact">Contact Number <span aria-hidden="true" style="color:#dc3545;">*</span></label>
                    <input type="tel" id="supplierContact" name="supplierContact" required pattern="^[0-9+\-\s()]{6,20}$"
                        autocomplete="off" />
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

</body>

</html>