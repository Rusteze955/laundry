<?php
if (strtolower($rowLevel['level_name']) == 'leader') {
    header("location:home.php?access=denied");
    exit;
}
function tanggal($date)
{
    $waktu = strtotime($date);
    return date('d F Y', $waktu);
}

if (isset($_GET['detail'])) {
    $id_order = $_GET['detail'];
    $queryOrder = mysqli_query($config, "SELECT trans_order.*, customer.customer_name FROM trans_order LEFT JOIN customer ON trans_order.id_customer = customer.id WHERE trans_order.id = '$id_order'");
    $rowOrder = mysqli_fetch_assoc($queryOrder);

    $queryDetail = mysqli_query($config, "SELECT trans_order_detail.*, type_of_service.* FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id WHERE id_order = '$id_order' ORDER BY trans_order_detail.id DESC");
    $rowDetail = mysqli_fetch_all($queryDetail, MYSQLI_ASSOC);
}

if (isset($_POST['save'])) {
    $id_customer = $_POST['id_customer'];
    $order_code = $_POST['order_code'];
    $order_status = $_POST['order_status'];
    $order_date = $_POST['order_date'];
    $order_end_date = $_POST['order_end_date'];
    $grand_total = $_POST['grand_total'];

    $insert = mysqli_query($config, "INSERT INTO trans_order (id_customer, order_code, order_status, order_date, order_end_date, total) VALUES ('$id_customer', '$order_code', '$order_status', '$order_date', '$order_end_date', '$grand_total')");
    if ($insert) {
        $id_order = mysqli_insert_id($config);
        for ($i = 0; $i < count($_POST['id_service']); $i++) {
            $id_service = $_POST['id_service'][$i];
            $qty = $_POST['qty'][$i] * 1000;
            $queryService = mysqli_query($config, "SELECT * FROM type_of_service WHERE id = '$id_service'");
            $rowService = mysqli_fetch_assoc($queryService);
            $subtotal = $_POST['qty'][$i] * $rowService['price'];
            mysqli_query($config, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES('$id_order', '$id_service', '$qty', '$subtotal')");
        }
        header("location:?page=order&tambah=berhasil");
    }
}

if (isset($_POST['save2'])) {
    $id_order = $_GET['detail'];
    $id_customer = $rowOrder['id_customer'];
    $order_pay = $_POST['order_pay'];
    $total = $_POST['grand_total'];
    $order_change = $order_pay - $total;
    $now = date('Y-m-d H:i:s');
    $pickup_date = $now;
    $order_status = 1;

    $update = mysqli_query($config, "UPDATE trans_order SET order_status='$order_status', order_pay='$order_pay', order_change='$order_change', total='$total' WHERE id='$id_order'");
    if ($update) {
        mysqli_query($config, "INSERT INTO trans_laundry_pickup (id_order, id_customer, pickup_date) VALUES ('$id_order', '$id_customer', '$pickup_date')");
        header("location:?page=tambah-order&detail=" . $id_order . "&status-pickup");
    }
}

$queryNoTrans = mysqli_query($config, "SELECT MAX(id) AS id_trans FROM trans_order");
$rowNoTrans = mysqli_fetch_assoc($queryNoTrans);
$id_trans = $rowNoTrans['id_trans'];
$id_trans++;

$format_no = "TR";
$date = date("dmy");
$icrement_number = sprintf("%03s", $id_trans);
$orderCode = $format_no . "-" . $date . "-" . $icrement_number;

$queryCustomer = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL ORDER BY id DESC");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

if (isset($_GET['id_customer'])) {
    $id_customer = $_GET['id_customer'];
    $queryCustomers = mysqli_query($config, "SELECT * FROM customer WHERE id = '$id_customer'");
    $rowCustomers = mysqli_fetch_assoc($queryCustomers);
}

$queryServices = mysqli_query($config, "SELECT * FROM type_of_service ORDER BY id DESC");
$rowServices = mysqli_fetch_all($queryServices, MYSQLI_ASSOC);

?>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($_GET['detail'])): ?>
                        <h5 class="card-title">Detail Order</h5>
                        <div class="table-responsive mb-3">
                            <div class="mb-3" align="right">
                                <a href="?page=order" class="btn btn-secondary">Back</a>
                            </div>
                            <table class="table table-stripped">
                                <tr>
                                    <th>Code</th>
                                    <td>:</td>
                                    <td><?php echo $rowOrder['order_code']; ?></td>
                                    <th>Date</th>
                                    <td>:</td>
                                    <td><?php echo tanggal($rowOrder['order_date']); ?></td>
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
                                            <td><?php echo $data['qty'] / 1000; ?></td>
                                            <td><?php echo $data['price']; ?></td>
                                            <td><?php echo $data['qty'] / 1000 * $data['price'];
                                                $total += $data['qty'] / 1000 * $data['price']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td><?php echo $total; ?></td>
                                    </tr>
                                    <?php if (isset($_GET['detail'])) { ?>
                                        <?php if ($rowOrder['order_status'] == 1) { ?>

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
                        <?php if (isset($_GET['detail']) && !isset($_GET['print'])) { ?>
                            <?php if ($rowOrder['order_status'] == 0) { ?>
                                <div class="mb-3" align="center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Pay</button>
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
                                        <?php if (isset($_GET['id_customer'])) { ?>
                                            <input type="text" class="form-control" value="<?php echo $rowCustomers['customer_name'] ?>" readonly>
                                            <input type="hidden" name="id_customer" value="<?php echo $rowCustomers['id'] ?>">
                                        <?php } else { ?>
                                            <select name="id_customer" id="" class="form-control">
                                                <option value="">Select Customer</option>
                                                <?php foreach ($rowCustomer as $customer): ?>
                                                    <option <?php echo isset($_GET['edit']) ? ($customer['id'] == $row['id_customer'] ? 'selected' : '') : '' ?> value="<?php echo $customer['id'] ?>"><?php echo $customer['customer_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Name Service</label>
                                        <select name="id_service" id="id_service" class="form-control">
                                            <option value="">Select Service</option>
                                            <?php foreach ($rowServices as $service): ?>
                                                <option data-price="<?php echo $service['price'] ?>" value="<?php echo $service['id'] ?>"><?php echo $service['service_name'] ?></option>
                                            <?php endforeach ?>
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
                                        <input name="order_end_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_end_date'] : '' ?>">
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
                                        <th>Sub Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <br>
                            <p><strong>Total: Rp. <span id="grandTotal">0</span></strong></p>
                            <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pay Order Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input readonly type="text" id="total" class="form-control" value="<?php echo $rowOrder['total']; ?>">
                        <input type="hidden" name="grand_total" value="<?php echo $rowOrder['total']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pay" class="form-label">Pay</label>
                        <input type="number" step="any" min="<?php echo $rowOrder['total']; ?>" name="order_pay" id="pay" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="save2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // var, let, const
    // var : ketika nilainya tidak ada, maka tidak ada error
    // let : harus mempunyai nilai
    // const :isi nya tidak boleh berubah
    // const button = document.getElementById('addRow');
    // const button = document.getElementsByClassName('addRow');
    const button = document.querySelector('#addRow');
    const tbody = document.querySelector('#myTable tbody');
    const select = document.querySelector('#id_service');
    // button.textContent = "duar";
    // button.style.color = "red";
    const grandTotal = document.getElementById('grandTotal');
    const grandTotalInput = document.getElementById('grandTotalInput');

    let no = 1;
    button.addEventListener("click", function() {

        const selectedService = select.options[select.selectedIndex];
        const serviceValue = selectedService.value;
        if (!serviceValue) {
            alert('select service require');
            return;
        }
        const serviceName = selectedService.textContent;
        const servicePrice = selectedService.dataset.price;

        const tr = document.createElement('tr'); //<tr></tr>
        tr.innerHTML = `
        <td>${no}</td>
        <td><input type='hidden' name='id_service[]' class='id_services' value='${select.value}'>${serviceName}</td>
        <td>
            <input type='number' name='qty[]' value='1' class='qtys'>
            <input type='hidden' class='priceInput' name='price[]' value='${servicePrice}'>
        </td>
        <td><input type='hidden' name='total[]' class='totals' value='${servicePrice}'><span class='totalText'>${servicePrice}</span></td>
        <td><button class='btn btn-danger btn-sm removeRow' type='button'>Delete</button></td>`;

        tbody.appendChild(tr);
        updateGrandTotal();
        no++;

        select.value = "";


    });

    tbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest("tr").remove();
        }

        updateNumber();
        updateGrandTotal();

    });

    tbody.addEventListener('input', function(e) {
        if (e.target.classList.contains('qtys')) {
            const row = e.target.closest('tr');
            const qty = parseInt(e.target.value) || 0;
            const price = parseInt(row.querySelector('[name="price[]"]').value);

            row.querySelector('.totalText').textContent = price * qty;
            row.querySelector('.totals').value = price * qty;
            updateGrandTotal();

        }
    });

    function updateNumber() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(function(row, index) {
            row.cells[0].textContent = index + 1;
        });

        no = rows.length + 1;
    }

    function updateGrandTotal() {
        const totalCells = tbody.querySelectorAll('.totals');
        let grand = 0;
        totalCells.forEach(function(input) {
            grand += parseInt(input.value) || 0;
        });
        grandTotal.textContent = grand.toLocaleString('id-ID');
        grandTotalInput.value = grand;
    }
</script>