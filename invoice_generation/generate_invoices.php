<?php
require "../db_conn.php";
require __DIR__ . "/../config/keys.php";
require_once '../vendor/autoload.php';
use \ConvertApi\ConvertApi;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ConvertApi::setApiSecret($convertAPIKey);

// Get post variables
$numericMonth = $_POST['month'];
$month = DateTime::createFromFormat('m', $numericMonth)->format('F');
$year = $_POST['year'];
$bfDate = $_POST['bf-date'];
$feeDate = $_POST['fee-date'];
$issueDate = $_POST['issue-date'];
$customerIds = explode(",", $_POST['customers']);

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

// Function to generate spreadsheet invoice
function GeneratePDFInvoice($conn, $customerDataArray, $month, $year, $bfDate, $feeDate, $issueDate, $bankAccountsArray)
{
    foreach ($customerDataArray as $customer) {

        // Load the template spreadsheet
        $spreadsheet = IOFactory::load('invoice_template.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        // Update the spreadsheet with customer data
        $sheet->getCell('D3')->setValue($month . ' – ' . $year);
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


        // Calculate invoice amount
        $invoiceAmount = $customer['bfAmount'] + $customer['monthlyFee'];


        // Add record for the payment
        $invoiceNumber = $customer['invoiceNumber'];
        $customerId = $customer['id'];
        $sql = "INSERT INTO invoices (invoice_id, customer_id, invoice_amount, invoice_date) VALUES ('$invoiceNumber', '$customerId', '$invoiceAmount', '$issueDate')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully PAYMENT";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Add record for the balance
        //Get current balance
        $sql = "INSERT INTO balances (customer_id, balance_date, balance_amount, invoice_id) VALUES ('$customerId', '$issueDate', '$invoiceAmount', '$invoiceNumber')";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully BALANCE";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Save the spreadsheet as an XLSX file
        $xlsxFileName = $customer['invoiceNumber'] . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsxFileName);

        // Converting the xlsx file to a pdf
        convertToPDF($xlsxFileName, $customer['invoiceNumber']);

    }
}

function convertToPDF($file, $fileName)
{
    echo "File: " . $file;
    $result = ConvertApi::convert(
        'pdf',
        [
            'File' => $file,
        ],
        'xlsx'
    );
    $result->saveFiles('output');
}

// Call the GeneratePDFInvoice function
GeneratePDFInvoice($conn, $customerDataArray, $month, $year, $bfDate, $feeDate, $issueDate, $bankAccountsArray);
?>