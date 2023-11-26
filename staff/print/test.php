<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: 'Helvetica', sans-serif;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .receipt-container {
        max-width: 250px;
        margin: 20px auto;
        border: 1px solid #000;
        padding: 10px;
    }

    .header {
        font-size: 16px;
        font-weight: bold;
    }

    .address {
        font-size: 11px;
        margin-top: 5px;
    }

    .contact {
        font-size: 11px;
        margin-top: 3px;
    }

    .cashier {
        font-size: 11px;
        margin-top: 5px;
    }

    .order-details {
        font-size: 11px;
        margin-top: 5px;
    }

    .item {
        font-size: 11px;
    }

    .total {
        font-size: 15px;
        font-weight: bold;
        margin-top: 5px;
    }

    .payment-details {
        font-size: 11px;
        margin-top: 5px;
    }

    .thank-you {
        font-size: 11px;
        margin-top: 2px;
    }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="header">Tom's Chicken House</div>
        <div class="address">
            Icon one bldg, Sanchez st.,<br>
            San Jose City<br>
            Nueva Ecija
        </div>
        <div class="contact">Contact: 09655628076</div>

        <div class="cashier">
            Cashier: Jamaica Sambrano<br>
            -----------------------------------------------------
        </div>

        <div class="order-details">
            <?php echo $order['order_method']; ?><br>
            -----------------------------------------------------
        </div>

        <div class="items">
            <?php
            while($order_item = $result->fetch_assoc()){
                echo $order_item['item_name'] . ' - P' . number_format($order_item['item_total'], 2) . '<br>';
                echo $order_item['quantity'] . ' x P' . number_format($order_item['price'], 2) . '<br>';
            }
            ?>
        </div>

        <div class="total">Total: P<?php echo number_format($order['total'], 2); ?></div>

        <div class="payment-details">
            Cash: P<?php echo number_format($order['cash'], 2); ?><br>
            Change: P<?php echo number_format($order['change_amount'], 2); ?><br>
            -----------------------------------------------------
        </div>

        <div class="thank-you">Thank you and Come again!</div>

        <div class="social-media">
            Like us on facebook & instagram:<br>
            Tom's Chicken House
        </div>

        <div class="official-receipt">*** OFFICIAL RECEIPT ***</div>
    </div>
</body>

</html>