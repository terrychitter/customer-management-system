<?php
// Include the database connection file and excel
require "../db_conn.php";
require_once '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;


// Get variables
$month = DateTime::createFromFormat('m', '03')->format('F');
$year = '2023';
$bfDate = date('2023-10-10');
$feeDate = date('2023-10-10');
$issueDate = date('2023-10-10');

// Array to store customer data
$customerDataArray = array();

// Populate the customerIds array
$customerIds = array(1, 2, 3, 4); // Populated with 1, 2, 3, and 4

// Loop through the customerIds array
foreach ($customerIds as $customerId) {
    // Prepare and execute the query to fetch customer information
    $customerQuery = "SELECT monthly_rate, title, name, surname, address, suburb, postal_code, bank_account 
                      FROM customers 
                      WHERE account_number = $customerId";

    $customerResult = mysqli_query($conn, $customerQuery);

    // Fetch the customer data
    $customer = mysqli_fetch_assoc($customerResult);

    // Create the required fields
    $monthlyFee = $customer['monthly_rate'];
    $name = $customer['title'] . ' ' . substr($customer['name'], 0, 1) . '. ' . $customer['surname'];
    $surname = $customer['surname'];
    $address = $customer['address'];
    $suburb = $customer['suburb'];
    $postal = $customer['postal_code'];
    $bankAccountId = $customer['bank_account'];

    // Generate the invoice number
    $currentYear = date('y');
    $currentMonth = date('m');
    $currentDay = date('d');
    $invoiceNumber = "INV" . $currentYear . $currentMonth . $currentDay . $customerId;

    // Prepare and execute the query to fetch BBF amount
    $bbfQuery = "SELECT balance_amount
                 FROM balances
                 WHERE customer_id = $customerId
                 ORDER BY balance_date DESC
                 LIMIT 1";

    $bbfResult = mysqli_query($conn, $bbfQuery);
    $bbfData = mysqli_fetch_assoc($bbfResult);
    $bbfAmount = $bbfData['balance_amount'];

    // Store the customer information in an array
    $customerDataArray[] = array(
        'monthlyFee' => $monthlyFee,
        'name' => $name,
        'surname' => $surname,
        'address' => $address,
        'suburb' => $suburb,
        'postal' => $postal,
        'invoiceNumber' => $invoiceNumber,
        'bfAmount' => $bbfAmount,
        'id' => $customerId,
        'bfDate' => $bfDate,
        'feeDate' => $feeDate,
        'issueDate' => $issueDate,
        'bankAccountId' => $bankAccountId
    );
}

// Fetch all bank accounts
$bankAccountsQuery = "SELECT id, name, branch, bank, type, account_number, branch_code FROM bank_accounts";
$bankAccountsResult = mysqli_query($conn, $bankAccountsQuery);

// Store bank accounts in an array
$bankAccountsArray = array();
while ($bankAccount = mysqli_fetch_assoc($bankAccountsResult)) {
    $bankAccountsArray[] = $bankAccount;
}

// Display the customer data for verification
foreach ($customerDataArray as $customerData) {
    echo "Monthly Fee: " . $customerData['monthlyFee'] . "<br>";
    echo "Name: " . $customerData['name'] . "<br>";
    echo "Surname: " . $customerData['surname'] . '<br>';
    echo "Address: " . $customerData['address'] . "<br>";
    echo "Suburb: " . $customerData['suburb'] . "<br>";
    echo "Postal: " . $customerData['postal'] . "<br>";
    echo "Invoice Number: " . $customerData['invoiceNumber'] . "<br>";
    echo "BF Amount: " . $customerData['bfAmount'] . "<br>";
    echo "Customer ID: " . $customerData['id'] . "<br>";
    echo "Bank Account ID: " . $customerData['bankAccountId'] . "<br><br>";
}

// Function to generate spreadsheet invoice
function GeneratePDFInvoice($customerDataArray, $month, $year, $bfDate, $feeDate, $issueDate, $bankAccountsArray)
{
    foreach ($customerDataArray as $customer) {
        // Load the template spreadsheet
        $spreadsheet = IOFactory::load('invoice_template.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        // Update the spreadsheet with customer data
        $sheet->getCell('D3')->setValue($month . '–' . $year);
        $sheet->getCell('B4')->setValue('Acc no: ' . $customer['id']);
        $sheet->getCell('F8')->setValue($customer['bfAmount']);
        $sheet->getCell('D8')->setValue($bfDate);
        $sheet->getCell('F9')->setValue($customer['monthlyFee']);
        $sheet->getCell('G4')->setValue($issueDate);
        $sheet->getCell('D9')->setValue($feeDate);
        $sheet->getCell('B6')->setValue($customer['name']);
        $sheet->getCell('B7')->setValue($customer['address']);
        $sheet->getCell('B8')->setValue($customer['suburb']);
        $sheet->getCell('B9')->setValue($customer['postal']);
        $sheet->getCell('E4')->setValue($customer['invoiceNumber']);

        // Find the bank account for the customer
        $bankAccount = array_values(array_filter($bankAccountsArray, function ($account) use ($customer) {
            return $account['id'] === $customer['bankAccountId'];
        }))[0];

        // Get the first three letters of the surname
        $surnameInitials = substr($customer['surname'], 0, 3);

        // Update the spreadsheet with the bank account details
        $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

        // Create the first line
        $payToText = $richText->createTextRun("Make all payments to:\n");
        $payToText->getFont()->setName($sheet->getStyle('B18')->getFont()->getName());
        $payToText->getFont()->setSize($sheet->getStyle('B18')->getFont()->getSize());
        $payToText->getFont()->setColor($sheet->getStyle('B18')->getFont()->getColor());
        $payToText->getFont()->setBold(true);

        // Create the rest of the text
        $bankDetailsText = $richText->createTextRun(
            "Bank: " . $bankAccount['bank'] . "\n" .
            "Branch: " . $bankAccount['branch'] . "\n" .
            "Type: " . $bankAccount['type'] . "\n" .
            "Acc Name: " . $bankAccount['name'] . "\n" .
            "Acc Number: " . $bankAccount['account_number'] . "\n" .
            "Branch Code: " . $bankAccount['branch_code'] . "\n" .
            "Reference: " . $customer['id'] . "-" . $surnameInitials
        );
        $bankDetailsText->getFont()->setName($sheet->getStyle('B18')->getFont()->getName());
        $bankDetailsText->getFont()->setSize($sheet->getStyle('B18')->getFont()->getSize());
        $bankDetailsText->getFont()->setColor($sheet->getStyle('B18')->getFont()->getColor());

        $sheet->getCell('B18')->setValue($richText);
        $sheet->getCell('B18')->getStyle()->getAlignment()->setWrapText(true);

        // Save the spreadsheet as an XLSX file
        $xlsxFileName = 'invoices/' . $customer['invoiceNumber'] . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsxFileName);
    }
}

// Call the GeneratePDFInvoice function
GeneratePDFInvoice($customerDataArray, $month, $year, $bfDate, $feeDate, $issueDate, $bankAccountsArray);
?>