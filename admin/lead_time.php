<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Admin - Lead Time Purchase Requests</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            height: 100vh;
            max-height: 600px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #3f51b5;
            color: #fff;
            padding: 1rem 1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        main {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 1rem 1.5rem;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 1rem;
            font-weight: 600;
            font-size: 1.25rem;
            color: #2c3e50;
        }

        form {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            margin-bottom: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }

        form label {
            font-size: 0.9rem;
            color: #555;
            flex: 1 1 45%;
            min-width: 120px;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            padding: 0.5rem;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus {
            border-color: #3f51b5;
            outline: none;
        }

        button {
            padding: 0.6rem 1.2rem;
            background: #3f51b5;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            flex: 1 1 100%;
            max-width: 150px;
            align-self: center;
        }

        button:hover {
            background: #303f9f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            font-size: 0.95rem;
        }

        thead {
            background: #3f51b5;
            color: #fff;
        }

        th,
        td {
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: #f0f4ff;
        }

        td input {
            font-size: 0.9rem;
            border: 1px solid transparent;
            padding: 4px 6px;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        td input:focus {
            border-color: #3f51b5;
            outline: none;
        }

        /* Desktop styles */
        @media screen and (min-width: 768px) {
            body {
                max-height: none;
                height: auto;
                background-color: #e9ecf5;
                display: flex;
                justify-content: center;
                padding: 2rem 0;
            }

            main {
                width: 95%;
                height: auto;
                max-height: 80vh;
                overflow-y: auto;
                padding: 2rem 3rem;
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 16px 40px rgba(31, 38, 135, 0.37);
                display: flex;
                flex-direction: column;
            }

            header {
                width: 95%;
                border-radius: 12px 12px 0 0;
                box-shadow: 0 16px 40px rgba(31, 38, 135, 0.37);
                font-size: 2rem;
                padding: 1.5rem 3rem;
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

            h2 {
                font-size: 1.5rem;
                margin-bottom: 2rem;
            }

            form {
                padding: 1.5rem 2rem;
                gap: 2rem;
                flex-wrap: nowrap;
                align-items: center;
            }

            form label {
                flex: 1 1 auto;
                min-width: auto;
            }

            input[type="text"],
            input[type="date"],
            input[type="number"] {
                font-size: 1.1rem;
                padding: 0.75rem;
            }

            button {
                max-width: 180px;
                font-size: 1.1rem;
                flex: none;
                padding: 0.75rem 1.8rem;
                align-self: auto;
            }

            table {
                font-size: 1rem;
            }

            th,
            td {
                padding: 1rem 1.5rem;
            }

            td input {
                font-size: 1rem;
                padding: 6px 8px;
            }
        }
    </style>
</head>

<body>
    <header>
        Lead Time Purchase Request
    </header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <h2>Add New Purchase Request</h2>
        <form id="addRequestForm" autocomplete="off">
            <label>
                Supplier Name
                <input type="text" id="supplierName" placeholder="Enter supplier name" required />
            </label>
            <label>
                Request Date
                <input type="date" id="requestDate" required />
            </label>
            <label>
                Lead Time (days)
                <input type="number" id="leadTime" placeholder="Enter days" min="0" required />
            </label>
            <label>
                Expected Delivery
                <input type="date" id="expectedDelivery" readonly />
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
                <!-- Entries will be inserted here -->
            </tbody>
        </table>
    </main>

    <script>
        const form = document.getElementById('addRequestForm');
        const supplierNameInput = document.getElementById('supplierName');
        const requestDateInput = document.getElementById('requestDate');
        const leadTimeInput = document.getElementById('leadTime');
        const expectedDeliveryInput = document.getElementById('expectedDelivery');
        const tableBody = document.querySelector('#requestsTable tbody');

        // Calculate expected delivery date when lead time or request date changes
        function calculateExpectedDelivery() {
            const requestDate = requestDateInput.value;
            const leadTime = parseInt(leadTimeInput.value, 10);

            if (requestDate && !isNaN(leadTime) && leadTime >= 0) {
                const reqDateObj = new Date(requestDate);
                reqDateObj.setDate(reqDateObj.getDate() + leadTime);
                const yyyy = reqDateObj.getFullYear();
                const mm = String(reqDateObj.getMonth() + 1).padStart(2, '0');
                const dd = String(reqDateObj.getDate()).padStart(2, '0');
                expectedDeliveryInput.value = `${yyyy}-${mm}-${dd}`;
            } else {
                expectedDeliveryInput.value = '';
            }
        }

        requestDateInput.addEventListener('change', calculateExpectedDelivery);
        leadTimeInput.addEventListener('input', calculateExpectedDelivery);

        // Function to create a table row for a request
        function createTableRow(request) {
            const tr = document.createElement('tr');

            // Supplier name cell
            const supplierTd = document.createElement('td');
            supplierTd.textContent = request.supplier;
            tr.appendChild(supplierTd);

            // Request date cell
            const reqDateTd = document.createElement('td');
            reqDateTd.textContent = request.requestDate;
            tr.appendChild(reqDateTd);

            // Lead time cell with editable input
            const leadTimeTd = document.createElement('td');
            const leadInput = document.createElement('input');
            leadInput.type = 'number';
            leadInput.min = 0;
            leadInput.value = request.leadTime;
            leadInput.style.width = '60px';
            leadInput.addEventListener('change', () => {
                if (leadInput.value < 0) {
                    leadInput.value = 0;
                }
                request.leadTime = parseInt(leadInput.value, 10);
                updateExpectedDelivery();
            });
            leadTimeTd.appendChild(leadInput);
            tr.appendChild(leadTimeTd);

            // Expected delivery cell (auto-calculated)
            const expectedTd = document.createElement('td');
            expectedTd.textContent = request.expectedDelivery;
            tr.appendChild(expectedTd);

            function updateExpectedDelivery() {
                const reqDate = new Date(request.requestDate);
                reqDate.setDate(reqDate.getDate() + request.leadTime);
                const yyyy = reqDate.getFullYear();
                const mm = String(reqDate.getMonth() + 1).padStart(2, '0');
                const dd = String(reqDate.getDate()).padStart(2, '0');
                request.expectedDelivery = `${yyyy}-${mm}-${dd}`;
                expectedTd.textContent = request.expectedDelivery;
            }

            // Actions cell with delete button
            const actionsTd = document.createElement('td');
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Delete';
            deleteBtn.style.backgroundColor = '#e74c3c';
            deleteBtn.style.border = 'none';
            deleteBtn.style.color = 'white';
            deleteBtn.style.padding = '6px 12px';
            deleteBtn.style.borderRadius = '4px';
            deleteBtn.style.cursor = 'pointer';
            deleteBtn.addEventListener('click', () => {
                tr.remove();
            });
            actionsTd.appendChild(deleteBtn);
            tr.appendChild(actionsTd);

            return tr;
        }

        // Handle form submission to add new request
        form.addEventListener('submit', event => {
            event.preventDefault();
            const supplier = supplierNameInput.value.trim();
            const requestDate = requestDateInput.value;
            const leadTime = parseInt(leadTimeInput.value, 10);
            const expectedDelivery = expectedDeliveryInput.value;

            if (!supplier || !requestDate || isNaN(leadTime) || leadTime < 0 || !expectedDelivery) {
                alert('Please complete all fields correctly.');
                return;
            }

            const newRequest = {
                supplier,
                requestDate,
                leadTime,
                expectedDelivery
            };

            const newRow = createTableRow(newRequest);
            tableBody.appendChild(newRow);

            // Reset form
            form.reset();
            expectedDeliveryInput.value = '';
        });
    </script>
</body>

</html>