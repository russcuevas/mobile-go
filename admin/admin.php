<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}

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
                        <button aria-controls="dashboard-menu" aria-expanded="true" class="flex items-center w-full text-[#a0b8d6] hover:text-white hover:bg-[#0a1a2e] rounded px-3 py-2" id="dashboard-btn" type="button">
                            <i class="fas fa-tachometer-alt mr-3 text-[#f0a500]"></i>
                            Dashboard
                        </button>
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
            <!-- Top Navbar -->
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
            <!-- Dashboard content placeholder -->
            <main class="p-4 md:p-6 space-y-6 bg-[#f8f9fa] flex-1 overflow-auto" id="main-content">
                <h1 class="text-xl font-semibold text-[#222] mb-3">Dashboard</h1>
                <p class="text-gray-600">Welcome to the MOBILE HUB Admin dashboard. Use the sidebar to navigate through the system.</p>
            </main>
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

</body>

</html>