<?php
require "data.php";
require "functions.php";

if (isset($_GET['status'])) {
    // var_dump($_GET['status']);
    $listOfInvoices = getInvoicesByStatus($_GET['status']);
} else {
    $listOfInvoices = getInvoices();
}

if (isset($_POST['invoice_number'])) {
    deleteInvoice($_POST['invoice_number']);

    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $queryString = '?status=' . urlencode($status);
        $redirectUrl = 'index.php' . $queryString;
        header("Location: " . $redirectUrl);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    $columnWidths = array(
        'Number' => '15%',
        'Amount' => '15%',
        'Client' => '20%',
        'Email' => '25%',
        'Status' => '10%',
        '' => '5%',
        '' => '5%',
        '' => '5%'
    );
    ?>
    <?php require "nav.php" ?>
    <div class="container text-center">
        <h2>Invoice Manager</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <?php
                    // Iterate over the column widths and create the table headers
                    foreach ($columnWidths as $columnName => $columnWidth): ?>
                        <th style="width: <?php echo $columnWidth; ?>"><?php echo $columnName; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listOfInvoices as $invoice) : ?>
                    <tr>
                        <td><?php echo '#' . $invoice['number']; ?></td>
                        <td><?php echo '$ ' . $invoice['amount']; ?></td>
                        <td><?php echo $invoice['client']; ?></td>
                        <td><?php echo $invoice['email']; ?></td>
                        <td><?php echo $invoice['status']; ?></td>
                        <?php if (file_exists("invoices/" . $invoice['number'] . ".pdf")) : ?>
                            <?php $pdfUrl = "invoices/" . $invoice['number'] . ".pdf"; ?>
                            <td><a href="<?php echo $pdfUrl; ?>" target="_blank">view</a></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
                        <td><a href="update.php?number=<?php echo $invoice['number']; ?>">edit</a></td>
                        <td>
                            <form class="form" method="post">
                                <input type="hidden" name="invoice_number" value="<?php echo $invoice['number']; ?>">
                                <button type="submit" class="btn btn-danger custom-width">delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</body>

</html>