<?php
require './api/auth.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Transactions | ArtGallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900">
    <link rel="stylesheet" href="./assets/css/ready.css">
    <link rel="stylesheet" href="./assets/css/demo.css">
</head>

<body>
    <div class="wrapper">
        <?php include('components/header.php'); ?>
        <?php include('components/sidebar.php'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h4 class="page-title">Transactions</h4>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <?php
                            $headers = ['Title', 'Buyer', 'Artist', 'Amount (₦)', 'Status', 'Date'];
                            $tableID = 'transactionsTable';
                            include 'components/table.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('components/scripts.html'); ?>

    <script>
    document.addEventListener("DOMContentLoaded", async () => {
        const tbody = document.getElementById("transactionRows");
        const totalCols = document.querySelectorAll("#transactionsTable th").length;

        // Initial loading row
        tbody.innerHTML = `<tr><td colspan="${totalCols}" class="text-center text-muted">Loading...</td></tr>`;

        try {
            const res = await fetch("api/transactions/list.php");
            const data = await res.json();

            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="${totalCols}" class="text-center text-muted">No transactions found.</td></tr>`;
                return;
            }

            tbody.innerHTML = "";
            data.forEach(tx => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${tx.artwork_title}</td>
                    <td>${tx.buyer_name}</td>
                    <td>${tx.artist_name}</td>
                    <td>₦${Number(tx.amount).toLocaleString()}</td>
                    <td>
                        <span class="badge ${
                            tx.payment_status === 'completed' ? 'badge-success' :
                            tx.payment_status === 'pending' ? 'badge-warning' : 'badge-danger'
                        }">${tx.payment_status}</span>
                    </td>
                    <td>${new Date(tx.created_at).toLocaleDateString()}</td>
                `;
                tbody.appendChild(row);
            });

        } catch (error) {
            console.error("Fetch error:", error);
            tbody.innerHTML = `<tr><td colspan="${totalCols}" class="text-center text-danger">Failed to load data.</td></tr>`;
        }
    });
</script>

</body>

</html>
