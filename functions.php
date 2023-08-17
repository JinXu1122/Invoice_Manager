<?php
function sanitize($data) {
    return array_map(function ($value) {
      return htmlspecialchars(stripslashes(trim($value)));
    }, $data);
  }

function validate($invoice) {
    $fields = ['client', 'email', 'amount', 'status'];
    $errors = array();

    foreach ($fields as $field) {
        switch ($field) {
            case 'client':
                if (empty($invoice[$field])) {
                    $errors[$field] = "A name is required.";
                } else {
                    if (!preg_match('/^[a-zA-Z\s]{1,255}$/', $invoice[$field])) {
                        $errors[$field] = "Name must contain only letters and spaces and cannot be more than 255 characters.";
                    }
                }
                break;
            case 'email':
                if (empty($invoice[$field])) {
                    $errors[$field] = "An email is required.";
                } else {
                    if (!filter_var($invoice[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = "Email must be a properly formatted email address.";
                    }
                }
                break;
            case 'amount':
                if (empty($invoice[$field])) {
                    $errors[$field] = "An amount is required.";
                } else {
                    if (!preg_match('/^\d+$/', $invoice[$field])) {
                        $errors[$field] = "Amount must be an integer.";
                    }
                }
                break;
            case 'status':     
                if (!preg_match('/^(draft|pending|paid)$/i', $invoice[$field])) {
                    $errors[$field] = "Status must be either draft, pending or paid.";
                }
                break;
        }
    }

    return $errors;
}

  //saveInvoice
  //process uploaded pdf file for invoice
  function saveInvoice($invoice_num) {
    //file data $_FILES['invoice']
    $invoice = $_FILES['invoice'];

    if ($invoice['error'] === UPLOAD_ERR_OK) {
      //get file extension
      $ext = pathinfo($invoice['name'], PATHINFO_EXTENSION);
      $filename = $invoice_num . '.' . $ext;

      if (!file_exists('invoices/')) {
        mkdir('invoices/');
      }

      $dest = 'invoices/' . $filename;

      if (file_exists($dest)) {
        unlink($filename);
      }

      return move_uploaded_file($invoice['tmp_name'], $dest);
    }

    return false;
  }

function getInvoices () {
    global $db;
    
    $sql = "SELECT * FROM invoices
    JOIN statuses ON invoices.status_id = statuses.id";
    $result = $db->query($sql);
    $invoices = $result->fetchAll();

    return $invoices;
  }

function getInvoicesByStatus ($status_id) {
    global $db;
    
    $sql = "SELECT * FROM invoices
    JOIN statuses ON invoices.status_id = statuses.id where status_id = :id";
    $result = $db->prepare($sql);
    $result->execute([':id' => $status_id]);
    $invoices = $result->fetchAll();

    return $invoices;
}

function getInvoice ($invoice_num) {
    global $db;

    $sql = "SELECT * FROM invoices
    JOIN statuses ON invoices.status_id = statuses.id where number = :number";
    $result = $db->prepare($sql);
    $result->execute([':number' => $invoice_num]);
    $invoice = $result->fetch();
    return $invoice;
}

function deleteInvoice($invoice_num) {
    global $db;

    $sql = "DELETE FROM invoices where number = :number";
    $result = $db->prepare($sql);
    $result->execute([':number' => $invoice_num]);
}

function updateInvoice($invoice, $num) {
    global $db;
    global $statuses;

    $status_id = array_search($invoice['status'], $statuses) + 1;

    $sql = "UPDATE invoices SET amount = :amount, status_id = :status_id, client = :client, email = :email
            WHERE number = :number";
    $result = $db->prepare($sql);
    $result->execute([
          ':amount' => $invoice['amount'], 
          ':status_id' => $status_id,   
          ':client' => $invoice['client'],
          ':email' => $invoice['email'],
          ':number' => $num         
    ]);

    saveInvoice($num);

}

function addInvoice ($invoice) {
    global $db;
    global $statuses;

    $invoice_num = getInvoiceNumber();
    $status_id = array_search($invoice['status'],$statuses) + 1;

    $sql = "INSERT INTO invoices (number, amount, status_id, client, email)
            VALUES (:number, :amount, :status_id, :client, :email)";
    $result = $db->prepare($sql);
    $result->execute([
          ':number' => $invoice_num,
          ':amount' => $invoice['amount'], 
          ':status_id' => $status_id,   
          ':client' => $invoice['client'],
          ':email' => $invoice['email']            
    ]);

    saveInvoice($invoice_num);
    
  }

  function getInvoiceNumber($length = 5)
{
    $number = [];
    $letters = range('A', 'Z');

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, count($letters) - 1);
        array_push($number, $letters[$randomIndex]);
    }

    return implode($number);
}

?>