<?php
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if(isset($_GET['account_number'])) {
    // Sanitize the account number
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $commentId = filter_var($_POST['modal-comment-id'], FILTER_SANITIZE_NUMBER_INT);
        $commentTitle = filter_var($_POST['modal-comment-title'], FILTER_SANITIZE_STRING);
        $commentText = filter_var($_POST['modal-comment-text'], FILTER_SANITIZE_STRING);

        // Check if comment ID is empty for adding new comment
        if ($commentId === "") {
            // Prepare and execute the insert query for adding a new comment
            $stmt = $conn->prepare("INSERT INTO comments (customer_id, comment_title, comment_text)
                                    VALUES (?, ?, ?)");
            
            $stmt->bind_param("iss", $accountNumber, $commentTitle, $commentText);

            if ($stmt->execute()) {
                // Successfully added new comment, redirect with status 18
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=18");
                exit();
            } else {
                // Failed to add new comment, redirect with status 12
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=17");
                exit();
            }
        } else {
            // Prepare and execute the update query for updating an existing comment
            $stmt = $conn->prepare("UPDATE comments SET 
                                    comment_title = ?, 
                                    comment_text = ?
                                    WHERE comment_id = ? AND customer_id = ?");
            
            $stmt->bind_param("ssii", $commentTitle, $commentText, $commentId, $accountNumber);

            if ($stmt->execute()) {
                // Successfully updated contact, redirect with status 15
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=20");
                exit();
            } else {
                // Failed to update contact, redirect with status 14
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=19");
                exit();
            }
        }
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=21");
    exit();
}
?>