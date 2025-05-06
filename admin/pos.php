<?php
include '../connection/database.php';

$stmt = $conn->prepare("SELECT sales_number, products, payment, amount, status, created_at FROM tbl_sales WHERE status = 'completed'");
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
$highest = 0;
$lowest = null;
$count = count($sales);

foreach ($sales as $sale) {
  $amount = floatval($sale['amount']);
  $total += $amount;
  if ($amount > $highest) $highest = $amount;
  if ($lowest === null || $amount < $lowest) $lowest = $amount;
}

$average = $count > 0 ? $total / $count : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Online Shop Admin Dashboard</title>
  <link rel="stylesheet" href="assets/css/sales.css">
</head>

<body>

  <header>Sales Overview</header>
  <button class="back-button" onclick="window.location.href='admin.html';">Back</button>

  <main>
    <div class="dashboard">
      <section class="stats" aria-label="Sales Statistics Summary">
        <h2>Sales Statistics</h2>
        <div class="stat-item">
          <span>Total Sales:</span> <span id="totalSales" class="stat-value">₱<?= number_format($total, 2) ?></span>
        </div>
        <div class="stat-item">
          <span>Highest Sale:</span> <span id="highestSale" class="stat-value">₱<?= number_format($highest, 2) ?></span>
        </div>
        <div class="stat-item">
          <span>Lowest Sale:</span> <span id="lowestSale" class="stat-value">₱<?= number_format($lowest, 2) ?></span>
        </div>
        <div class="stat-item">
          <span>Average Sale:</span> <span id="averageSale" class="stat-value">₱<?= number_format($average, 2) ?></span>
        </div>
        <div class="stat-item">
          <span>Number of Sales:</span> <span id="numSales" class="stat-value"><?= $count ?></span>
        </div>
      </section>

      <section class="sales-table-container" aria-label="Sales Table">
        <h2>Sales Detail</h2>
        <table id="salesTable" aria-describedby="salesTableDesc">
          <thead>
            <tr>
              <th>Sale ID</th>
              <th>Product</th>
              <th>Payment</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($count > 0): ?>
              <?php foreach ($sales as $sale): ?>
                <tr>
                  <td><?= htmlspecialchars($sale['sales_number']) ?></td>
                  <td><?= htmlspecialchars($sale['products']) ?></td>
                  <td><?= htmlspecialchars($sale['payment']) ?></td>
                  <td>₱<?= number_format($sale['amount'], 2) ?></td>
                  <td><?= htmlspecialchars(date('Y-m-d', strtotime($sale['created_at']))) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5">No sales data available.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </section>
    </div>
  </main>

</body>

</html>