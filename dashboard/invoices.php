<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard – Invoices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../global.css" />
</head>

<body class="container-fluid d-flex flex-column">

    <?php
    include "modals/modal_duplicate_invoices.html";
    ?>

    <body class="container-fluid d-flex flex-column w-100 overflow-x-hidden">
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
                            <li class="list-group-item active">
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
                <button class="btn btn-primary canvas-button" type="button" id="offcanvas-toggle-button"
                    draggable="true" data-bs-toggle="offcanvas" data-bs-target="#navigation-canvas"
                    aria-controls="navigation-canvas">
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
                                        data-bs-target="#navigation-canvas"
                                        aria-controls="navigation-canvas">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item text-white active" aria-current="page">
                                    Invoices
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="profile-settings col d-flex align-items-center justify-content-end" style="gap: 0.6rem">
                        <div class="account-name">Kleenbin Norwood</div>
                        <div class="profile-icon-container">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>
                        <a href="settings.php" class="text-white">
                            <i href="settings.php" class="bi bi-gear-fill fs-4"></i>
                        </a>
                    </div>
                </header>
                <div class="row p-0 m-0">
                    <!-- SearchCustomers Accordion -->
                    <div class="search-customers col-12 col-lg-6 accordion mt-3 p-0" id="search-customer-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" id="search-customer-accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    <h2 class="fs-5 mb-0">Search</h2>
                                </button>
                            </div>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
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
                                        <div class="text-end">
                                            <button type="button" class="btn btn-small btn-secondary btn-sm"
                                                id="show-hide-filters"><i class="bi bi-funnel-fill"></i>
                                                <span id="show-hide-filter-button-text">View
                                                    Filters</span></button>
                                        </div>
                                        <div class="mb-3 d-none" id="filters" data-is-hidden="true">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="search-filter-radio"
                                                    id="search-filter-radio1" value="all" checked>
                                                <label class="form-check-label" for="search-filter-radio1">
                                                    All
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="search-filter-radio"
                                                    id="search-filter-radio2" value="pending">
                                                <label class="form-check-label" for="search-filter-radio2">
                                                    Pending Invoices
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="inactive-filter">
                                                <label class="form-check-label" for="inactive-filter">
                                                    Inactive Accounts
                                                </label>
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
                                    <button type="button" class="d-none btn btn-primary btn-sm"
                                        id="move-all-selected-button">Add
                                        All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Selected Customers Accordion -->
                    <div class="selected-customers col-12 col-lg-6 accordion mt-3 p-0 px-lg-3"
                        id="selected-customers-accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" id="selected-customers-accordion-item">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#selected-customers-accordion-collapse" aria-expanded="true"
                                    aria-controls="selected-customers-accordion-collapse">
                                    <h2 class="fs-5 mb-0">Selected Customers</h2>
                                </button>
                            </div>
                            <div id="selected-customers-accordion-collapse" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <!-- Search Accordion Body -->
                                <div class="accordion-body">
                                    <p style="font-size: 0.9rem;">All customers who will have their invoices generated
                                        are
                                        displayed here. Use the
                                        search panel above to add customers to the list or remove customers from the
                                        list
                                        below.</p>
                                    <div class="overflow-y-auto" style="max-height: 260px">
                                        <table class="table table-striped table-hover" id="selected_customers_table">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="d-none btn btn-primary btn-sm"
                                        id="move-all-search-button">Remove
                                        All</button>
                                    <div id="no-selected-customers">
                                        <div class="fs-6 text-secondary text-center"
                                            style="border: none; background: none; margin-top: -1rem;"
                                            onclick="exit();">No Customers Selected</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invoices Details & Generation -->
                <div class="invoice-d&g col-12 accordion mt-3 col-lg-6" id="invoice-d&g-accordion">
                    <div class="accordion-item">
                        <div class="accordion-header" id="invoice-d&g-accordion-heading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#invoice-d&g-accordion-collapse" aria-expanded="true"
                                aria-controls="invoice-d&g-accordion-collapse">
                                <h2 class="fs-5 mb-0">Invoices Details & Generation</h2>
                            </button>
                        </div>
                        <div id="invoice-d&g-accordion-collapse" class="accordion-collapse collapse show"
                            aria-labelledby="invoice-d&g-accordion-heading">
                            <!-- Search Accordion Body -->
                            <div class="accordion-body">
                                <p style="font-size:0.9rem;">Use this panel to edit the dates to be shown on the
                                    invoices. This will affect all invoices.</p>
                                <form action="">
                                    <label for="invoice-for-group" class="form-label">For:</label>
                                    <div class="row mb-3 p-2">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Month</span>
                                            <select class="form-select" name="month" id="month">
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">Year</span>
                                            <input class="form-control" type="number" name="year" id="year" min="2000"
                                                max="9999" step="1">
                                        </div>
                                    </div>
                                    <label for="bf-date" class="form-label">B/F Date <i
                                            class="bi bi-info-circle-fill text-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="right"
                                            data-bs-title="This is the Brought Forward Date to be shown on the customer's invoice. By default this is set to the first day of the current month."></i>
                                    </label>
                                    <input class="form-control mb-3" type="date" name="bf-date" id="bf-date">
                                    <label for="fee-date" class="form-label">Fee Date <i
                                            class="bi bi-info-circle-fill text-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="right"
                                            data-bs-title="The fee date indicates the day the customer's account was charged with their monthly feel. By default this is set to the current date."></i>
                                    </label>
                                    <input class="form-control mb-3" type="date" name="fee-date" id="fee-date">
                                    <label for="issue-date" class="form-label">Issue Date <i
                                            class="bi bi-info-circle-fill text-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="right"
                                            data-bs-title="The issue date indicated the date the invoice will be sent out. By default this is set to the current date."></i>
                                    </label>
                                    <input class="form-control" type="date" name="issue-date" id="issue-date">
                                    <div class="col text-end">
                                        <button class="btn btn-primary mt-3" type="button"
                                            id="generate-invoices-button">Generate
                                            Invoices</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="download-invoices col-12 col-lg-6 accordion mt-3 p-0 px-lg-3"
                    id="download-invoices-accordion">
                    <div class="accordion-item">
                        <div class="accordion-header" id="download-invoices-accordion-item">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#download-invoices-accordion-collapse" aria-expanded="false"
                                aria-controls="download-invoices-accordion-collapse">
                                <h2 class="fs-5 mb-0"><i class="bi bi-download fs-3"></i> Download Invoices
                                </h2>
                            </button>
                        </div>
                        <div id="download-invoices-accordion-collapse" class="accordion-collapse collapse collapse"
                            aria-labelledby="panelsStayOpen-headingOne">
                            <!-- Search Accordion Body -->
                            <div class="accordion-body">
                                <p>Download invoices by each month. Scroll to see more months/years.</p>
                                <?php include "load_invoices.inc.php"; ?>
                                <div class="container">
                                    <ul class="nav nav-pills flex-nowrap mb-3" id="pills-tab" role="tablist"
                                        style="overflow-x: auto;">
                                        <?php foreach ($uniqueMonthsYears as $umy) { ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?php echo ($umy['id'] == "1") ? "active" : ""; ?>"
                                                    id="pills-<?php echo $umy['id'] ?>-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-<?php echo $umy['id']; ?>" type="button"
                                                    role="tab" aria-controls="pills-<?php echo $umy['id']; ?>"
                                                    aria-selected="true">
                                                    <?php echo $umy['title']; ?>
                                                </button>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <?php foreach ($uniqueMonthsYears as $umy) { ?>
                                            <div class="tab-pane fade show <?php echo ($umy['id'] == "1") ? "active" : ""; ?>"
                                                id="pills-<?php echo $umy['id'] ?>" role="tabpanel"
                                                aria-labelledby="pills-<?php echo $umy['id']; ?>-tab">
                                                <ul class="bg-light border rounded py-3">
                                                    <?php foreach ($umy['invoices'] as $invoiceData) { ?>
                                                        <li class="fs-6 mx-0">
                                                            <?php echo $invoiceData['invoice_id'] ?>&nbsp; &nbsp;
                                                            <?php echo $invoiceData['customer_name'] ?>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-sm-block"><button class="btn btn-primary"><i
                                            class="bi bi-download fs-4"></i> Download
                                        Invoices</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="invoice-status-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img class="rounded me-2">
                            <strong class="me-auto" id="invoice-status-toast-header">Toast header</strong>
                            <small></small>
                            <button type="button" id="toast-close-button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <div id="invoice-status-toast-body" class="mb-3">Some Text</div>
                            <div id="invoice-status-progress-bar" class="progress bg-primary " role="progressbar"
                                style="height: 20px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </ma in>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="handle_search_and_selected.js"></script>
                <script>
                    // Enabling all the tool tips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })

                    // Get the first day of the current month
                    var today = new Date();
                    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                    var dd = String(firstDay.getDate()).padStart(2, '0');
                    var mm = String(firstDay.getMonth() + 1).padStart(2, '0');
                    var yyyy = firstDay.getFullYear();

                    var formattedDate = yyyy + '-' + mm + '-' + dd;
                    document.getElementById('bf-date').value = formattedDate;

                    // Provide fee and issue date with today's date
                    var today = new Date().toISOString().slice(0, 10);
                    document.getElementById('fee-date').value = today;
                    document.getElementById('issue-date').value = today;

                    // S electing correct month based on the date
                    var today = new Date();
                    var currentMonth = today.getMonth() + 1;
                    var monthSelect = document.getElementById('month');
                    var options = monthSelect.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value == ('0' + currentMonth).slice(-2)) {
                            options[i].selected = true;
                            break;
                        }
                    }

                    // Displaying correct year based on the date
                    var today = new Date();
                    var currentYear = today.getFullYear();
                    document.getElementById('year').value = currentYear;

                    // Showi ng and hiding filters
                    var show HideFiltersButton = document.getElementById("show-hide-filters");
                    var filt erButtonText = document.getElementById("show-hide-filter-button-text");
                    var filt ersGroup = document.getElementById("filters");

                showHide FiltersButton.addEventListener("click", function () {
                        var isHidden = filtersGroup.getAttribute('data-is-hidden');

                        if (isHidden === 'true') {
                            filtersGroup.classList.add('d-block');
                            filtersGroup.classList.remove('d-none');
                            filtersGroup.setAttribute('data-is-hidden', 'false');
                            filterButtonText.innerText = "Hide Filters";
                        } else {
                            filtersGroup.classList.add('d-none');
                            filtersGroup.classList.remove('d-block');
                            filtersGroup.setAttribute('data-is-hidden', 'true');
                            filterButtonText.innerText = "Show Filters";
                        }
                    });
                </script>
    </body>

</html>