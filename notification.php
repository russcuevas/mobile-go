<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/notification.css">
    <title>Order Notification</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Order Notification</h1>
            <h2>Thank you for your purchase!</h2>
        </header>

        <section id="order-notification">
            <h2>Your Order Details:</h2>
            <div id="cart-items"></div> <!-- Cart items will be injected here -->
            <div id="order-total"></div> <!-- Total amount will be injected here -->
            <button onclick="goToHome()">Go to Home</button>
        </section>
    </div>
    <script src="not.js"></script>
</body>

</html>