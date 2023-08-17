<?php
require "data.php";
require "functions.php";

if (isset($_GET['number'])) {
    $invoice_init = getInvoice($_GET['number']);
    $num = $_GET['number'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $invoice = sanitize($_POST);
    $errors= validate($invoice);

    if (count($errors) == 0) {

        updateInvoice($invoice, $num);    
        header("Location: index.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .custom-width {
            width: 600px;
        }
    </style>
    <title>Edit Invoice</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="height: 50vh;">
        <div class="text-center">
            <h2>Edit Invoice</h2>
            <br>
            <form class="form" method="post" enctype="multipart/form-data">
                
                <div class="form-group mb-3">
                    <input type="text" class="form-control custom-width" name="client" placeholder="Client Name" value="<?php if (!isset($invoice)) {
                                                                                                                                    echo $invoice_init['client'];
                                                                                                                                } else {
                                                                                                                                    echo $invoice['client'];
                                                                                                                                } ?>">
                    <div class="text-start text-danger">
                        <?php echo $errors['client'] ?? ''; ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control custom-width" name="email" placeholder="Client Email" value="<?php if (!isset($invoice)) {
                                                                                                                                    echo $invoice_init['email'];
                                                                                                                                } else {
                                                                                                                                    echo $invoice['email'];
                                                                                                                                } ?>">
                    <div class="text-start text-danger">
                        <?php echo $errors['email'] ?? ''; ?>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control custom-width" name="amount" placeholder="Invoice Amount" value="<?php if (!isset($invoice)) {
                                                                                                                                        echo $invoice_init['amount'];
                                                                                                                                    } else {
                                                                                                                                        echo $invoice['amount'];
                                                                                                                                    } ?>">
                    <div class="text-start text-danger">
                        <?php echo $errors['amount'] ?? ''; ?>
                    </div>
                </div>
                <div class="form-group custom-width mb-4">
                    <select class="form-select" name="status">
                        <option value="">Select a Status</option>
                        <?php foreach ($statuses as $status) : ?>
                            <option value="<?php echo $status; ?>" <?php
                                                                    if (!isset($invoice) && ($status === $invoice_init['status'])) {
                                                                        echo "selected";
                                                                    } else if (isset($invoice) && ($status === $invoice['status'])) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>
                                    <?php echo $status; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="text-start text-danger">
                        <?php echo $errors['status'] ?? ''; ?>
                    </div>
                </div>
                <input type="file" class="form-control" name="invoice" accept=".pdf">
                    <br/>
                <button type="submit" class="btn btn-primary custom-width">Update Invoice</button>

            </form>
        </div>
    </div>
</body>

</html>