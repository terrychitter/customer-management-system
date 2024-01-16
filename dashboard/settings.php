<?php include "../session_check.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard – Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../global.css" />
</head>

<body class="container-fluid d-flex flex-column w-100 overflow-x-hidden">
    <?php include "load_settings.inc.php";
    include "modals/delete_bank_account_confirm.html";
    include "modals/delete_default_bank_account_confirm.html";
    include "../popup.php";
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
                        <li class="list-group-item">
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
                                Settings
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
            <section class="settings-section pt-3 container-md">
                <h2 class="fs-2">General</h2>
                <div class="section-box rounded border p-2 bg-light">
                    <p>General settings will go here.</p>
                </div>
            </section>
            <section class="settings-section pt-3 container-md">
                <h2 class="fs-2" name="finance-heading">Finance</h2>
                <div class="section-box rounded border p-2 bg-light">
                    <label for="finance-heading" class="form-label">Current Banking Accounts <i
                            class="bi bi-info-circle-fill text-secondary" data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            data-bs-title="Bank accounts are used during invoice generation. Each bank account can be linked with multiple customers. The linked bank account's details will be displayed on the customer's invoice."></i>
                    </label>
                    <!-- Bank accounts container -->
                    <div class="bank-accounts-container col-12 overflow-auto border rounded p-2">
                        <!-- Bank accounts card -->
                        <?php if (!empty($bank_accounts)) {
                            foreach ($bank_accounts as $bankAccount) {
                                $bankAccountId = $bankAccount['id'];
                                $bankAccountName = $bankAccount['private_name'];
                                $bankAccountBankName = $bankAccount['bank'];
                                $bankAccountType = $bankAccount['type'];
                                $bankAccountAccountHolder = $bankAccount['name'];
                                $bankAccountAccNum = $bankAccount['account_number'];
                                $bankAccountBranchName = $bankAccount['branch'];
                                $bankAccountBranchCode = $bankAccount['branch_code'];
                                $bankAccountIsDefault = $bankAccount['is_default']; ?>
                        <div class="card bank-account-card mb-1" data-bank-account-id="<?php echo $bankAccountId; ?>"
                            data-bank-account-name="<?php echo $bankAccountName; ?>"
                            data-bank-account-bank-name="<?php echo $bankAccountBankName ?>"
                            data-bank-account-type="<?php echo $bankAccountType; ?>"
                            data-bank-account-holder-name="<?php echo $bankAccountAccountHolder ?>"
                            data-bank-account-account-number="<?php echo $bankAccountAccNum; ?>"
                            data-bank-account-branch-name="<?php echo $bankAccountBranchName ?>"
                            data-bank-account-branch-code="<?php echo $bankAccountBranchCode ?>"
                            data-bank-account-is-default="<?php echo $bankAccountIsDefault ?>" data-bs-toggle="modal"
                            data-bs-target="#add-bank-account-modal">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <i class="fs-1 bi bi-credit-card"></i>
                                    </div>
                                    <div class="col text-truncate">
                                        <span class="fs-5">
                                            <?php echo $bankAccountName; ?> –
                                            <?php echo $bankAccountAccNum; ?>
                                            <span class="text-primary font-weight-bold">
                                                <?php echo ($bankAccountIsDefault) ? "(DEFAULT)" : ""; ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col-2 text-end">
                                        <i class="bi bi-trash-fill fs-4 text-danger" data-bs-toggle="modal" <?php if ($bankAccountIsDefault) {
                                                    echo 'data-bs-target="#default-bank-account-confirm-delete-modal"';
                                                } else {
                                                    echo 'data-bs-target="#bank-account-confirm-delete-modal"';
                                                }
                                                ?>></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }
                        } else { ?>
                        <div class="no-bank-accounts text-secondary">
                            No Bank Accounts to display
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col text-end mt-2">
                        <button id="add-bank-account-button" class="btn btn-primary btn-sm" data-clear-form
                            data-bs-toggle="modal" data-bs-target="#add-bank-account-modal"
                            onclick="event.preventDefault();">
                            Add Bank Account
                        </button>
                    </div>
                </div>
            </section>
            <?php include "modals/add_bank_account.html"; ?>
        </main>
        <script src="clear_form.js"></script>
        <script src="/remove_paramters.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        </script>
</body>