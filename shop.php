<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/shop.css">
    <title>Document</title>
</head>

<body>

    <body>
        <div class="container">
            <div class="nav-bar">
                <ul class="menu">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="shop.php" class="active">PRODUCT</a></li>
                    <li><a href="notification.php">NOTIFICATION</a></li>
                    <li><a href="login.php">ACCOUNT</a></li>
                </ul>
            </div>

        </div>

        <section class="sec">
            <div class="products">
                <div class="card">
                    <div class="img/"><img src="https://inbox.ph/wp-content/uploads/2022/10/Screen-Protector-CLear-for-iphone-14-1.jpg" alt=""></div>
                    <div class="title">Screen Protector</div>
                    <div class="box">
                        <div class="price">php 99</div>
                        <button class="btn" onclick="addToCart('Screen Protector', 99)">Add to cart</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cart Icon (Click to show the cart) -->
        <div class="icon-cart" id="iconCart">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1" />
            </svg>
        </div>
        <header>
            <div class="icon-cart" id="iconCart"></div>
        </header>
        <div class="listProduct">
        </div>
        <div class="cartTab hidden">
            <div class="cart-header">
                <h1>Order Details</h1>
            </div>
            <div class="cart-content">
                <table id="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cart items will be dynamically added here -->
                    </tbody>
                </table>
            </div>
            <div class="cart-footer">
                <div id="total-amount">Total: php 0</div>
                <div class="cart-actions">
                    <button class="close"><a href="shop.php">CLOSE</a></button>
                    <button class="checkOut"><a href="notification.php">Check Out</a></button>
                </div>
            </div>
        </div>
        <script src="assets/js/cart.js"></script>

    </body>

</html>