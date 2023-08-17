<?php
require "data.php";
require "functions.php";

$invoice = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice = sanitize($_POST);
    $errors = validate($invoice);

    if (count($errors) === 0) {
        addInvoice($invoice);

        header("Location: index.php");
        //exit();
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
    <title>New Invoice</title>
</head>

<body>
    <div class="container d-flex justify-content-center" style="height: 50vh;">
        <div class="text-center">
            <h2>New Invoice</h2>
            <br>
            <form class="form" method="post" enctype="multipart/form-data">
                <div>
                    <div class="mb-3">
                        <input type="text" class="form-control custom-width" name="client" placeholder="Client Name" value="<?php echo $invoice['client'] ?? ''; ?>">
                        <div class="text-start text-danger">
                            <?php echo $errors['client'] ?? ''; ?>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control custom-width" name="email" placeholder="Client Email" value="<?php echo $invoice['email'] ?? ''; ?>">
                        <div class="text-start text-danger">
                            <?php echo $errors['email'] ?? ''; ?>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control custom-width" name="amount" placeholder="Invoice Amount" value="<?php echo $invoice['amount'] ?? ''; ?>">
                        <div class="text-start text-danger">
                            <?php echo $errors['amount'] ?? ''; ?>
                        </div>
                    </div>
                    <div class="form-group custom-width mb-4">
                        <select class="form-select" name="status">
                            <option value="">Select a Status</option>
                            <?php foreach ($statuses as $status) : ?>
                                <option value="<?php echo $status; ?>" <?php if (isset($invoice['status']) && $status === $invoice['status']) : ?> selected <?php endif; ?>>
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
                </div>
                <button type="submit" class="btn btn-primary custom-width">Add Invoice</button>
            </form>
        </div>
    </div>
</body>

</html>