<?php
include 'config/koneksi.php';
session_start();
$id_order = $_GET['id'];
$id_level = isset($_SESSION['ID_LEVEL']) ? $_SESSION['ID_LEVEL'] : '';
$querySetting = mysqli_query($config, "SELECT * FROM setting");
$rowSetting = mysqli_fetch_assoc($querySetting);

$query = mysqli_query($config, "SELECT trans_order_detail.*, trans_order.*, customer.customer_name, type_of_Service.* FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id LEFT JOIN trans_order ON trans_order_detail.id_order = trans_order.id LEFT JOIN customer ON trans_order.id_customer = customer.id WHERE trans_order.id = '$id_order'");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

$queryLevel = mysqli_query($config, "SELECT * FROM level WHERE id='$id_level'");
$rowLevel = mysqli_fetch_assoc($queryLevel);

$tanggal = $row[0]['created_at'];
$jam = explode(" ", $tanggal)[1];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA|Laundry Abdullah</title>
    <style>
        body {
            font-family: 'Courier New';
            width: 80mm;
            margin: auto;
            padding: 10px;
        }

        .struk {
            text-align: center;
        }

        .line {
            margin: 5px 0;
            border-top: 1px dashed black;
        }

        .info {
            text-align: center;
        }

        .service,
        .summary {
            text-align: left;
        }

        .service .item {
            margin-bottom: 5px;

        }

        .service .item-qty {
            display: flex;
            justify-content: space-between;
        }

        .info .row,
        .summary .row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }

        footer {
            text-align: center;
            font-size: 13px;
            margin-top: 10px;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="struk-header">
            <div class="info text-center">
                <h3>
                    <p><?php echo $rowSetting['name'] ?></p>
                </h3>
                <p><?php echo $rowSetting['email'] ?></p>
                <p><?php echo $rowSetting['address'] ?></p>
                <p><?php echo $rowSetting['phone'] ?></p>
            </div>
        </div>
        <div class="line"></div>
        <div class="info">
            <div class="row">
                <span><?php echo $row[0]['order_date'] ?></span>
                <span><?php echo $jam ?></span>
            </div>
            <div class="row">
                <span><?php echo $rowLevel['level_name'] ?></span>
                <span><?php echo $_SESSION['NAME'] ?></span>
            </div>
            <div class="row">
                <span>Order Id: </span>
                <span><?php echo $row[0]['order_code'] ?></span>
            </div>
            <div class="row">
                <span>Name Customer: </span>
                <span><?php echo $row[0]['customer_name'] ?></span>
            </div>
        </div>
        <div class="line"></div>
        <?php foreach ($row as $key => $r) { ?>
            <div class="service">
                <div class="item">
                    <strong><?php echo $r['service_name'] ?></strong>
                    <div class="item-qty">
                        <span><?php echo $r['qty'] / 1000 ?> kg X @ <?php echo $r['price'] ?></span>
                        <span><?php echo $r['subtotal'] ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="line"></div>
        <div class="summary">
            <div class="row">
                <span>Total</span>
                <span>Rp. <?php echo $row[0]['total'] ?></span>
            </div>
        </div>
        <div class="line"></div>
        <div class="footer" class="text-center">
            Terima Kasih!!
        </div>
        <script>
            window.print();
        </script>
</body>

</html>