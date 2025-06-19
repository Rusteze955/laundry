<?php
    function tanggal($date) {
        $waktu = strtotime($date);
        return date('d F Y', $waktu);
    }

    if (isset($_GET['details'])){
        $id_order = $_GET['detail'];
        $queryOrder2 = mysqli_query($config, "SELECT trans_order.*, customer.customer_name FROM trans_order LEFT JOIN customer ON trans_order.id_customer = customer.id WHERE trans_order.id = '$id_order'");
        $rowOrder2 = mysqli_fetch_assoc($queryOrder2);

        $queryDetail = mysqli_query($config, "SELECT trans_order_detail.*, type_of_service.* FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id WHERE id_order = '$id_order' ORDER BY trans_order_detail.id DESC");
        $rowDetail = mysqli_fetch_all($queryDetail, MYSQLI_ASSOC);
    }

    if (isset($_POST['save'])) {
        $id_customer = $_POST['id_customer'];
        $order_code = $_POST['order_code'];
        $order_status = $_POST['order_status'];
        $order_date = $_POST['order_date'];
        $order_end_date = $_POST['order_end_date'];

        $insert = mysqli_query($config, "INSERT INTO trans_order (id_customer, order_code, order_status, order_date, order_end_date) VALUES ('$id_customer', '$order_code', '$order_status', '$order_date', '$order_end_date')");
        if ($insert) {
            $id_order = mysqli_insert_id($config);
            for ($i=0; $i < count($_POST['id_service']); $i++){
                $id_service = $_POST['id_service'][$i];
                $qty = $_POST['qty'][$i] * 1000;
                $queryService = mysqli_query($config, "SELECT * FROM type_of_service WHERE id = '$id_service'");
                $rowService = mysqli_fetch_assoc($queryService, MYSQLI_ASSOC);
                $subtotal = $_POST['qty'][$i] = $rowService['price'];
                mysqli_query($config, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES('$id_order', '$id_service', '$qty', '$subtotal')");
            }
            header("location:?page=order&tambah=berhasil");
        }
    }
 
    if (isset($_POST['save2'])) {
        $id_order = $_GET['detail'];
        $id_customer = $_rowOrder['id_customer'];
        $order_pay = $_POST['order_pay'];
        $total = $_POST['total'];
        $order_change = $order_pay - $total;
        $now = date('Y-m-d H:i:s');
        $pickup_date = $now;
        $order_status = 1;
        
        $update = mysqli_query($config, "UPDATE trans_order SET order_status='$order_status', order_pay='$order_pay', order_change='$order_change', total='$total' WHERE id='$id_order'");
        if ($update) {
            mysqli_query($config, "INSERT INTO trans_laundry_pickup (id_order, id_customer, pickup_date) VALUES ('$id_order', '$id_customer', '$pickup_date')");
            header("location:?page=tambah-order&detail" . $id_order . "&status-pickup");
        }
    }

$queryOrder = mysqli_query($config, "SELECT * FROM trans_order ORDER BY id DESC");
if (mysqli_num_rows($queryOrder) == 0) {
    $orderCode = "#1";
} else {
    $rowOrder = mysqli_fetch_assoc($queryOrder);
    $orderCode = "#" . $rowOrder['id'] + 1;
}

$queryCustomer = mysqli_query($config, "SELECT * FROM customer ORDER BY id DESC");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);


?>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if(isset($_GET['detail'])): ?>
                        <h5 class="card-title">Detail Order</h5>
                        <div class="table-responsive mb-3">
                            <div class="mb-3" align="right">
                                <a href="?page=order" calss="btn btn-secondary">Back</a>
                            </div>
                            <table class="table table-stripped">
                                <tr>
                                    <th>Code</th>
                                    <td>:</td>
                                    <td><?php echo $rowOrder['order_code']; ?></td>
                                    <th>Date</th>
                                    <td>:</td>
                                    <th><?php echo tanggal($rowOrder['order_date']); ?></th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>:</td>
                                    <td><?php echo $rowOrder['customer_name']; ?></td>
                                    <th>End Date</th>
                                    <td>:</td>
                                    <td><?php echo tanggal($rowOrder['order_end_date']); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:</td>
                                    <td><?php echo $rowOrder['order_status'] == 0 ? 'Process' : 'Picked' ?></td>
                                </tr>
                            </table>
                            <br><br>
    
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Type of Service</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($rowDetail as $key => $data) { ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $data['service_name']; ?></td>
                                            <td><?php echo $data['qty']/1000; ?></td>
                                            <td><?php echo $data['price']; ?></td>
                                            <td><?php echo $data['qty']/1000 * $data['price']; $total += $data['qty']/1000 *$data['price']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td><?php echo $total; ?></td>
                                    </tr>
                                    <?php if(isset($_GET['detail'])) {?>
                                        <?php if ($rowOrder['order_status']==1) { ?>
    
                                            <tr>
                                                <td colspan="4">Pay</td>
                                                <td><?php echo $rowOrder['order_pay']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Change</td>
                                                <td><?php echo $rowOrder['order_change']; ?></td>
                                            </tr>
                                        <?php } ?>
                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (isset($_GET['detail']) && !isset($_GET['print'])) {?>
                            <?php if($rowOrder['order_status']==0) { ?>
                                <div class="mb-3" align="center">
                                    <!-- Button trigger modal -->
                                     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy</button>
                                </div>
                           <?php } ?>
                       <?php } ?>

                        <?php else: ?>   
                        <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Order</h5>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Code</label>
                                        <input readonly name="order_code" type="text" class="form-control" value="<?php echo $orderCode ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name</label>
                                        <select name="id_customer" id="" class="form-control">
                                            <option value="">Select Customer</option>
                                            <?php foreach ($rowCustomer as $customer): ?>
                                                <option <?php echo isset($_GET['edit']) ? ($customer['id'] == $row['id_customer'] ? 'selected' : '') : '' ?> value="<?php echo $customer['id'] ?>"><?php echo $customer['customer_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Order Status</label>
                                        <select name="order_status" id="" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="0">Process</option>
                                            <option value="1">Pick Up</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Order Date</label>
                                        <input name="order_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_date'] : '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">End Date</label>
                                        <input name="order_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_date'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                            </div>
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Service</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="mb-3">
                                <button name="save" type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
//ambil data service di php
const services = <?= json_encode($rowService) ?>;

//ambil input si addrow 

function numberRow() {
    const rows = document.querySelectorAll('#myTable tbody tr');
    rows.forEach((row, index) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = index + 1;
        }
    });
}

document.getElementById('addRow').addEventListener('click', function() {
    const tbody = document.querySelector('#myTable tbody');
    const row = document.createElement('tr');

    let serviceOptions = '<option value="">-- Pilih Service --</option>';
    services.forEach(service => {
        serviceOptions += `<option value="${service.id}" data-price="${service.price}">
                ${service.service_name}
            </option>`;
    });

    row.innerHTML = `
        <td class="row-number"></td>
        <td>
            <select name="id_service[]" class="form-control service-select" required>
                ${serviceOptions}
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1"></td>
        <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
        <td><input type="number" name="total[]" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">X</button></td>
    `;

    tbody.appendChild(row);
    newRow(row); // <-- Kirim baris yang baru ditambahkan
    numberRow(row); //nambah si No 
});

function hitungTotal() {
    const totalFields = document.querySelectorAll('.total');
    let grand = 0;
    totalFields.forEach(field => {
        grand += parseFloat(field.value || 0);
    });
    document.getElementById('grandTotal').innerText = grand.toLocaleString();
}

function newRow(row) {
    const select = row.querySelector('.service-select');
    const qty = row.querySelector('.qty');
    const harga = row.querySelector('.harga');
    const total = row.querySelector('.total');
    const deleteBtn = row.querySelector('.deleteRow');


    select.addEventListener('change', function() {
        const price = this.options[this.selectedIndex].getAttribute('data-price');
        harga.value = price || 0;
        total.value = (qty.value || 0) * (price || 0)
        y
        hitungTotal();
    });

    qty.addEventListener('input', function() {
        const price = parseFloat(harga.value) || 0;
        const quantity = parseFloat(qty.value) || 0;
        total.value = quantity * price;
        hitungTotal();
    });

    deleteBtn.addEventListener('click', function() {
        row.remove();
        hitungTotal();
        numberRow(); // hapus si no yang ditambah lewat numberRow()
    });
}
</script>