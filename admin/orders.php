<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Customer Orders Management</title>
    <link rel="stylesheet" href="assets/css/orders.css">
</head>

<body>
    <header>
        <h1>ShopAdmin</h1>
    </header>
    <button class="back-button" onclick="window.location.href='admin.php';">Back</button>
    <main>
        <div class="container">
            <h2>Customer Orders</h2>
            <table id="orders-table" aria-label="Customer orders management table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Product Ordered</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </main>
</body>

</html>