<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard – Payments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../global.css" />
</head>

<body class="container-fluid d-flex flex-column w-100 overflow-x-hidden">
    <?php
    require_once("load_customer_details.php");
    require_once("../popup.php");
    include("modals/duplicate_payment.html");
    ?>
    <div class="row h-100">
        <!-- Navigation Canvas -->
        <style>
        ul a {
            text-decoration: none;
        }

        .canvas-button {
            position: absolute;
            top: 50%;
            right: -2.5rem;
            visibility: visible;
            color: white;
            border: none;
            padding-block: 2rem;
            border-radius: 0 10px 10px 0;
        }

        .list-group-item {
            border: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-radius: 5px;
            margin-bottom: 1.3rem;
            font-size: 1.3rem;
            cursor: pointer;
        }

        .nav-item-icon-container {
            background-color: white;
            color: #4169e1;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-content: center;
            border-radius: 5px;
            box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
            -webkit-box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
            -moz-box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
        }

        .nav-item-icon-container i {
            font-size: 1.5rem;
        }

        .nav-item-icon-container.active {
            box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
            -webkit-box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
            -moz-box-shadow: 0px 6px 10px 3px rgba(135, 135, 135, 0.2);
        }

        .profile-icon-container {
            width: 2rem;
            height: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(77, 77, 77);
            border-radius: 50%;
            background: rgb(226, 226, 226);
            background: linear-gradient(338deg,
                    rgba(226, 226, 226, 1) 45%,
                    rgba(246, 246, 246, 1) 52%,
                    rgba(255, 255, 255, 1) 60%);
        }

        .search-results {
            cursor: pointer;
        }
        </style>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="navigation-canvas"
            aria-labelledby="navigation-canvas-label">
            <!-- Canvas Head -->
            <div class="offcanvas-header">
                <h2>
                    <div class="row" style="margin-left: -2.5rem">
                        <img src="../images/logo_cropped.png" alt="Kleenbin CMS Logo" />
                    </div>
                </h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-labelledby="Close"></button>
            </div>
            <!-- Canvas Body -->
            <div class="offcanvas-body">
                <ul class="list-group p-0">
                    <a href="customer.php">
                        <li class="list-group-item">
                            <div class="nav-item-icon-container">
                                <i class="bi bi-people"></i>
                            </div>
                            Customers
                        </li>
                    </a>
                    <a href="payments.php">
                        <li class="list-group-item active">
                            <div class="nav-item-icon-container">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            Payments
                        </li>
                    </a>
                    <a href="invoices.php">
                        <li class="list-group-item">
                            <div class="nav-item-icon-container">
                                <i class="bi bi-receipt"></i>
                            </div>
                            Invoices
                        </li>
                    </a>
                    <a href="statements.php">
                        <li class="list-group-item">
                            <div class="nav-item-icon-container">
                                <i class="bi bi-file-earmark-spreadsheet"></i>
                            </div>
                            Statements
                        </li>
                    </a>
                </ul>
            </div>
            <!-- Wide Screen Toggle Button -->
            <button class="btn btn-primary canvas-button" type="button" id="offcanvas-toggle-button" draggable="true"
                data-bs-toggle="offcanvas" data-bs-target="#navigation-canvas" aria-controls="navigation-canvas">
                <i class="bi bi-three-dots-vertical"></i>
                <!-- Dragging script -->
                <script>
                const draggableElement = document.getElementById('offcanvas-toggle-button');
                let isDragging = false;
                let startY;
                let initialTop;
                const topBoundaryOffset = 64; // 4rem = 64px
                const bottomBoundaryOffset = 16; // 1rem = 16px

                // Function to handle the touch start event
                function handleTouchStart(event) {
                    const touch = event.touches[0];
                    startY = touch.clientY;
                    initialTop = parseInt(window.getComputedStyle(draggableElement).top);
                    isDragging = false; // Initialize as click, not drag
                }

                // Function to handle the touch move event and update the element position along the Y-axis
                function handleTouchMove(event) {
                    const touch = event.touches[0];
                    const deltaY = touch.clientY - startY;

                    // Check if the user has moved enough to be considered a drag
                    if (!isDragging && Math.abs(deltaY) > 5) {
                        isDragging = true;
                    }

                    // If dragging, limit the element's position within the boundaries
                    if (isDragging) {
                        const minTop = topBoundaryOffset;
                        const maxTop = window.innerHeight - draggableElement.clientHeight - bottomBoundaryOffset;
                        let newTop = Math.max(minTop, Math.min(initialTop + deltaY, maxTop));
                        draggableElement.style.top = newTop + 'px';

                        // Save the element's vertical position to localStorage
                        localStorage.setItem('draggableElementTop', newTop);
                    }
                }

                // Function to handle the touch end event
                function handleTouchEnd(event) {
                    isDragging = false;
                }

                // Retrieve the stored position from localStorage
                const storedTop = localStorage.getItem('draggableElementTop');
                if (storedTop) {
                    draggableElement.style.top = storedTop + 'px';
                }

                // Add touch event listeners for dragging
                draggableElement.addEventListener('touchstart', handleTouchStart);
                draggableElement.addEventListener('touchmove', handleTouchMove);
                draggableElement.addEventListener('touchend', handleTouchEnd);
                </script>
            </button>
        </div>
        <main class="overflow-auto col-12 col-md px-md-3 pb-3">
            <header class="custom-header row align-items-center bg-primary text-white py-2">
                <div class="d-none d-sm-block col">
                    <nav aria-label="breadcrumb mb-0 pb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white" id="offcanvas-toggle-button" data-bs-toggle="offcanvas"
                                    data-bs-target="#navigation-canvas" aria-controls="navigation-canvas">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-white active" aria-current="page">
                                Payments
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="profile-settings col d-flex align-items-center justify-content-end" style="gap: 0.6rem">
                    <div class="account-name">Kleenbin Norwood</div>
                    <div class="profile-icon-container">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <i class="bi bi-gear-fill fs-4"></i>
                </div>
            </header>
            <div class="row py-3">
                <!-- Search Customers Section -->
                <div class="search-customers-section col-12">
                    <div class="search-customers col-12 accordion" id="search-customer-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" id="search-customer-accordion-item">
                                <button class="accordion-button <?php if ($customerActive) {
                                    echo "collapsed";
                                } ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    <h2 class="fs-5 mb-0">Search</h2>
                                </button>
                            </div>
                            <div id="panelsStayOpen-collapseOne"
                                class="accordion-collapse <?php echo ($customerActive) ? "collapse" : "show"; ?>"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <!-- Search Accordion Body -->
                                <div class="accordion-body">
                                    <form class="search-functions row" id="search-customer-form">
                                        <!-- Search input field -->
                                        <div class="search-bar col-12 col-md-6 col-xl-5">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="search-input"
                                                    placeholder="Search Customers" aria-label="Search Customers"
                                                    aria-describedby="search-icon" />
                                                <span class="input-group-text" id="search-icon"><i
                                                        class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        <!-- Search by select field -->
                                        <div class="search-by col">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="search-by-text">Search by</span>
                                                <select class="form-select" id="search-by-select" aria-label="Search By"
                                                    aria-describedby="search-by-text">
                                                    <option value="account-number" selected>
                                                        Account Number
                                                    </option>
                                                    <option value="surname">Surname</option>
                                                    <option value="street-name">Street Name</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row search-results gx-0" style="max-height:300px">
                                        <h3 style="font-size: 0.9rem; margin-bottom: 0;">Search Results</h3>
                                        <div class="overflow-y-auto" style="max-height: 260px">
                                            <table class="table table-striped table-hover" id="search-results-table">
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="lds-ripple m-auto" id="search-results-spinner">
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <div class="d-none" id="no-search-matches">
                                            <div class="fs-6 text-secondary text-center"
                                                style="border: none; background: none; margin-top: -1rem;"
                                                onclick="exit();">No
                                                Matches Found</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-payments-section col-12 col-md-6 mt-3">
                    <!-- Add Payments Section -->
                    <div class="add-payment col-12 accordion" id="add-payment-accordion">
                        <?php if (isset($_GET['customer_id'])) { ?>
                        <span class="position-absolute badge rounded-pill bg-success"
                            style="z-index: 999; top: -0.5rem; right: 0.5rem">
                            Account Active:
                            <?php echo $surname . ' ' . mb_substr($name, 0, 1); ?>
                            <span class="visually-hidden">Active Account</span>
                        </span>
                        <?php } ?>
                        <div class="accordion-item">
                            <div class="accordion-header" id="add-payment-accordion-item">
                                <button class="accordion-button <?php if (!$customerActive) {
                                    echo "collapsed";
                                } ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#add-payments-panel-stay-open" aria-expanded="true"
                                    aria-controls="add-payments-panel-stay-open">
                                    <h2 class="fs-5 mb-0">Add Payment</h2>
                                </button>
                            </div>
                            <div id="add-payments-panel-stay-open"
                                class="accordion-collapse <?php echo ($customerActive) ? "show" : "collapse"; ?>"
                                aria-labelledby="">
                                <!-- Add Payment Accordion Body -->
                                <div class="accordion-body">
                                    <!-- NO CUSTOMER SELECTED DIV -->
                                    <?php if (!$customerActive) { ?>
                                    <div class="row">
                                        <?php include "no-customer-selected.html"; ?>
                                    </div>
                                    <?php } else { ?>
                                    <form id="add-payment-form"
                                        action="add_payment.php?customer_id=<?php echo $accountNumber ?>" method="POST">
                                        <label for="payment-date" class="form-label">Date</label>
                                        <input type="date" id="payment-date-id" name="payment-date"
                                            class="form-control mb-2" required>
                                        <script>
                                        document.getElementById('payment-date-id').valueAsDate = new Date();
                                        </script>
                                        <label for="payment-amount" class="form-label">Amount</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend"><span class="input-group-text"
                                                    style="border-top-right-radius: 0; border-bottom-right-radius: 0;">R</span>
                                            </div>
                                            <input type="number" name="payment-amount" step=1 class="form-control"
                                                required>
                                        </div>
                                        <label for="payment-type" class="form-label">Type</label>
                                        <select name="payment-type" class="form-select mb-2" required>
                                            <option value="EFT" selected>EFT</option>
                                            <option value="CASH">CASH</option>
                                        </select>
                                        <div class="col text-end">
                                            <button type="submit" id="add-payment-button" class="btn btn-primary">Add
                                                Payment</button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-history-section col-12 col-md-6 mt-3">
                    <!-- Payment History Section -->
                    <div class="payment-history col-12 accordion" id="payment-history-accordion">
                        <?php if (isset($_GET['customer_id'])) { ?>
                        <span class="position-absolute badge rounded-pill bg-success"
                            style="z-index: 999; top: -0.5rem; right: 0.5rem">
                            Account Active:
                            <?php echo $surname . ' ' . mb_substr($name, 0, 1); ?>
                            <span class="visually-hidden">Active Account</span>
                        </span>
                        <?php } ?>
                        <div class="accordion-item">
                            <div class="accordion-header" id="payment-history-accordion-item">
                                <button class="accordion-button <?php if (!$customerActive) {
                                    echo "collapsed";
                                } ?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#payment-history-panel-stay-open" aria-expanded="true"
                                    aria-controls="payment-history-panel-stay-open">
                                    <h2 class="fs-5 mb-0">Payment History</h2>
                                </button>
                            </div>
                            <div id="payment-history-panel-stay-open"
                                class="accordion-collapse <?php echo ($customerActive) ? "show" : "collapse" ?>"
                                aria-labelledby="">
                                <!-- Payment History Accordion Body -->
                                <div class="accordion-body">
                                    <!-- NO CUSTOMER SELECTED DIV -->
                                    <?php if (!$customerActive) { ?>
                                    <div class="row">
                                        <?php include "no-customer-selected.html"; ?>
                                    </div>
                                    <?php } else { ?>
                                    <div class="payments-history-container overflow-auto border rounded p-2"
                                        style="max-height: 550px;">
                                        <!-- Payment Card -->
                                        <?php if (!empty($payments)) {
                                                $mostRecentPayment = array_key_first($payments);
                                                foreach ($payments as $key => $payment) {
                                                    $paymentID = $payment['payment_id'];
                                                    $paymentDate = date('F d, Y', strtotime($payment['payment_date']));
                                                    $paymentAmount = $payment['payment_amount'];
                                                    $paymentType = $payment['payment_type'];
                                                    $paymentBalance = $payment['balance_after_payment'] ?>
                                        <div class="card mb-2" data-payment-id="<?php echo $paymentID; ?>">
                                            <div class="card-body p-2">
                                                <div class="row mb-1 align-items-center">
                                                    <div class="col-6" style="font-size: 0.7rem">
                                                        #
                                                        <?php echo $paymentID; ?>
                                                    </div>
                                                    <div class="col-6 text-end text-danger align-content-center">
                                                        <?php if ($key === $mostRecentPayment) {
                                                                        $mostRecentPaymentID = $paymentID; ?>
                                                        <b><i id="reverse-payment-button" type="button"
                                                                class="bi bi-arrow-counterclockwise fs-4"
                                                                style="cursor:pointer;"></i></b>
                                                        <!-- Confirm reverse modal -->
                                                        <form method="post" class="text-start text-black"
                                                            action="reverse_payment.php?payment_id=<?php echo $mostRecentPaymentID; ?>">
                                                            <div class="modal fade" id="confirm-reverse-payment-modal">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">
                                                                                <i class="bi bi-exclamation-triangle-fill fs-3"
                                                                                    style="color: red"></i>
                                                                                Reverse Payment
                                                                            </h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to reverse this
                                                                            payment?
                                                                            <?php echo $mostRecentPaymentID; ?>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal"
                                                                                style="background-color: red; border: none">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                id="continue-duplicate-payment-button"
                                                                                class="btn btn-secondary">
                                                                                Reverse
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php echo $paymentDate; ?>
                                                    </div>
                                                    <div class="col-12">
                                                        <?php echo $paymentType; ?>
                                                    </div>
                                                    <div class="col-12 text-success">
                                                        + R
                                                        <?php echo $paymentAmount; ?>
                                                        <i class="bi bi-cash-coin ms-1"></i>
                                                    </div>
                                                    <div class="col-12 mt-n2">
                                                        <hr>
                                                    </div>
                                                    <div class="col-12 text-end">
                                                        <b>Balance:
                                                            <?php echo $paymentBalance; ?>
                                                        </b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                            } else { ?>
                                        <div class="no-payments text-secondary">
                                            No Payments to display
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../remove_paramters.js"></script>
        <script src="search.js"></script>
        <script>
        $(document).ready(function() {
            $("#add-payment-button").click(function() {
                // Prevent the form from submitting
                event.preventDefault();

                // Gather form data
                var paymentDate = $("#payment-date-id").val();
                var paymentAmount = $("input[name='payment-amount']").val();
                var paymentType = $("select[name='payment-type']").val();

                // Prepare the data to be sent
                var searchData = {
                    paymentDate: paymentDate,
                    paymentAmount: paymentAmount,
                    paymentType: paymentType,
                };

                // Send a request to the server
                fetch("duplicate_payment.php?customer_id=<?php echo $accountNumber ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: new URLSearchParams(searchData).toString(),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        // Check the response
                        if (data.status === false) {
                            // If the value returned is false, submit the form
                            $("#add-payment-form").submit();
                        } else {
                            // If the value is not false, show the modal
                            $("#duplicate-payment-modal").modal('show');
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });

            // If the continue button in the modal is clicked, submit the form
            $("#continue-duplicate-payment-button").click(function() {
                $("#add-payment-form").submit();
            });
        });


        // Reversing payments
        $("#reverse-payment-button").click(function() {
            $("#confirm-reverse-payment-modal").modal('show');
        })
        </script>
</body>

</html>