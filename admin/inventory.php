<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inventory Management</title>
    <link rel="stylesheet" href="assets/css/inventory.css">
</head>

<body>
    <header>Inventory Management</header>
    <button aria-label="Logout" onclick="window.location.href='admin.php'" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2">
        <i class="fas fa-sign-out-alt mr-3 text-[#f0a500]"></i>
        Back
    </button>
    <main>
        <div class="tabs" role="tablist" aria-label="Inventory Sections">
            <button class="tab active" role="tab" aria-selected="true" aria-controls="receiving" id="tab-receiving">Receiving Items</button>
            <button class="tab" role="tab" aria-selected="false" aria-controls="backorder" id="tab-backorder">Back Order</button>
            <button class="tab" role="tab" aria-selected="false" aria-controls="critical" id="tab-critical">Critical Levels</button>
            <button class="tab" role="tab" aria-selected="false" aria-controls="sales" id="tab-sales">Sales</button>
            <button class="tab" role="tab" aria-selected="false" aria-controls="damage" id="tab-damage">Damage</button>
            <button class="tab" role="tab" aria-selected="false" aria-controls="obsolete" id="tab-obsolete">Obsolete Items</button>
        </div>

        <section id="receiving" class="tab-content" role="tabpanel" aria-labelledby="tab-receiving">
            <h2>Receiving Items</h2>
            <form id="receiveForm" aria-label="Form to receive new items into inventory">
                <div>
                    <label for="receive-name">Item Name</label>
                    <input type="text" id="receive-name" name="name" required autocomplete="off" />
                </div>
                <div>
                    <label for="receive-qty">Quantity</label>
                    <input type="number" id="receive-qty" name="quantity" min="1" required />
                </div>
                <div>
                    <label for="receive-critical">Critical Level</label>
                    <input type="number" id="receive-critical" name="critical" min="0" value="5" required />
                </div>
                <div>
                    <label for="receive-backorder">Back Order?</label>
                    <select id="receive-backorder" name="backorder">
                        <option value="false" selected>No</option>
                        <option value="true">Yes</option>
                    </select>
                </div>
                <button type="submit">Add / Update Item</button>
            </form>
            <div class="message" id="receiveMessage"></div>
        </section>

        <section id="backorder" class="tab-content" role="tabpanel" aria-labelledby="tab-backorder" hidden>
            <h2>Back Order Items</h2>
            <table aria-label="List of items on backorder" id="backorderTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Mark Received</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- backorder list -->
                </tbody>
            </table>
        </section>

        <section id="critical" class="tab-content" role="tabpanel" aria-labelledby="tab-critical" hidden>
            <h2>Critical Levels</h2>
            <table aria-label="List of items below critical level" id="criticalTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Current Quantity</th>
                        <th>Critical Level</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- critical items -->
                </tbody>
            </table>
        </section>

        <section id="sales" class="tab-content" role="tabpanel" aria-labelledby="tab-sales" hidden>
            <h2>Sales</h2>
            <form id="salesForm" aria-label="Form to log sales">
                <div>
                    <label for="sales-item">Select Item</label>
                    <select id="sales-item" name="item" required>
                        <!-- Options dynamically populated -->
                    </select>
                </div>
                <div>
                    <label for="sales-qty">Quantity Sold</label>
                    <input type="number" id="sales-qty" name="quantity" min="1" required />
                </div>
                <button type="submit">Log Sale</button>
            </form>
            <div class="message" id="salesMessage"></div>
        </section>

        <section id="damage" class="tab-content" role="tabpanel" aria-labelledby="tab-damage" hidden>
            <h2>Damage</h2>
            <form id="damageForm" aria-label="Form to log damaged items">
                <div>
                    <label for="damage-item">Select Item</label>
                    <select id="damage-item" name="item" required>
                        <!-- Options dynamically populated -->
                    </select>
                </div>
                <div>
                    <label for="damage-qty">Quantity Damaged</label>
                    <input type="number" id="damage-qty" name="quantity" min="1" required />
                </div>
                <div>
                    <label for="damage-reason">Reason</label>
                    <input type="text" id="damage-reason" name="reason" placeholder="Brief description" autocomplete="off" />
                </div>
                <button type="submit">Log Damage</button>
            </form>
            <div class="message" id="damageMessage"></div>
            <h3>Damage Log</h3>
            <table aria-label="List of damaged items" id="damageLogTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity Damaged</th>
                        <th>Reason</th>
                        <th>Timestamp</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- damage log -->
                </tbody>
            </table>
        </section>

        <section id="obsolete" class="tab-content" role="tabpanel" aria-labelledby="tab-obsolete" hidden>
            <h2>Obsolete Items</h2>
            <form id="obsoleteForm" aria-label="Form to mark items as obsolete">
                <div>
                    <label for="obsolete-item">Select Item</label>
                    <select id="obsolete-item" name="item" required>
                        <!-- Options dynamically populated -->
                    </select>
                </div>
                <button type="submit">Mark as Obsolete</button>
            </form>
            <div class="message" id="obsoleteMessage"></div>
            <h3>Obsolete Items List</h3>
            <table aria-label="List of obsolete items" id="obsoleteTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Marked On</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- obsolete items -->
                </tbody>
            </table>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active state from all tabs
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.hidden = true;
                    });

                    // Activate clicked tab
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');

                    // Show corresponding tab content
                    const tabId = tab.getAttribute('aria-controls');
                    const contentToShow = document.getElementById(tabId);
                    if (contentToShow) {
                        contentToShow.hidden = false;
                    }
                });
            });
        });
    </script>


</body>

</html>