<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Customer</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="../global.css" />
    <link rel="stylesheet" href="customer.css" />
  </head>

  <?php
    include "../popup.php";
    // Getting database connection and starting the session
    require_once("../db_conn.php");

    // Intialising variables
    $customerActive = false;
    $customerID = '0';

    // Assigning variables
    if (isset($_GET['customer_id'])) {
      $customerActive = true;
      $customerID = $_GET['customer_id'];
    }

    // Getting customer data if a customer is selected
    if ($customerActive) {

    // Query the database to get the customer data
    $sql = "SELECT * FROM customers WHERE account_number = $customerID";

    // Execute the query and store the result in $result
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and fetch the customer data
    if ($result && mysqli_num_rows($result) > 0) {
          $customerData = mysqli_fetch_assoc($result);

          // Extract each field value and store them in variables
          $accountNumber = $customerData['account_number'];
          $title = $customerData['title'];
          $name = $customerData['name'];
          $surname = $customerData['surname'];
          $address = $customerData['address'];
          $suburb = $customerData['suburb'];
          $city = $customerData['city'];
          $postalCode = $customerData['postal_code'];
          $active = $customerData['active'];
          $email = $customerData['email'];
          $origin = $customerData['origin'];
          $frequency = $customerData['frequency'];
          $day = $customerData['day'];
          $monthlyRate = $customerData['monthly_rate'];
          $dateJoined = $customerData['date_joined'];
          $dateAdded = $customerData['date_added'];

          // Retrieve comments for the customer and store in an array
          $comments = array();
          $sql_comments = "SELECT * FROM comments WHERE customer_id = $customerID";
          $result_comments = mysqli_query($conn, $sql_comments);
          if ($result_comments) {
              while ($commentData = mysqli_fetch_assoc($result_comments)) {
                  $comments[] = $commentData;
              }
          }

          // Retrieve bins for the customer and store in an array
          $bins = array();
          $sql_bins = "SELECT * FROM bins WHERE customer_id = $customerID";
          $result_bins = mysqli_query($conn, $sql_bins);
          if ($result_bins) {
              while ($binData = mysqli_fetch_assoc($result_bins)) {
                  $bins[] = $binData;
              }
          }

          // Retrieve contacts for the customer and store in an array
          $contacts = array();
          $sql_contacts = "SELECT * FROM contacts WHERE customer_id = $customerID";
          $result_contacts = mysqli_query($conn, $sql_contacts);
          if ($result_contacts) {
              while ($contactData = mysqli_fetch_assoc($result_contacts)) {
                  $contacts[] = $contactData;
              }
          }

          // Retrieve payments for the customer and store in an array
          $payments = array();
          $sql_payments = "SELECT * FROM payments WHERE customer_id = $customerID";
          $result_payments = mysqli_query($conn, $sql_payments);
          if ($result_payments) {
              while ($paymentData = mysqli_fetch_assoc($result_payments)) {
                  $payments[] = $paymentData;
              }
          }

          // Retrieve invoices for the customer and store in an array
          $invoices = array();
          $sql_invoices = "SELECT * FROM invoices WHERE customer_id = $customerID";
          $result_invoices = mysqli_query($conn, $sql_invoices);
          if ($result_invoices) {
              while ($invoiceData = mysqli_fetch_assoc($result_invoices)) {
                  $invoices[] = $invoiceData;
              }
          }
      } else {

          // Customer could not be found
          header("Location: customer.php?status=1");
      }
          // Close the database connection
          mysqli_close($conn);
    }
?>
  <body class="container-fluid d-flex flex-column w-100 overflow-x-hidden">
    <div class="row h-100">
      <!-- Navigation Canvas -->
      <style>
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
          background: linear-gradient(
            338deg,
            rgba(226, 226, 226, 1) 45%,
            rgba(246, 246, 246, 1) 52%,
            rgba(255, 255, 255, 1) 60%
          );
        }
      </style>
      <div
        class="offcanvas offcanvas-start"
        tabindex="-1"
        id="navigation-canvas"
        aria-labelledby="navigation-canvas-label"
      >
        <!-- Canvas Head -->
        <div class="offcanvas-header">
          <h2>
            <div class="row" style="margin-left: -2.5rem">
              <img src="../images/logo_cropped.png" alt="Kleenbin CMS Logo" />
            </div>
          </h2>
          <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-labelledby="Close"
          ></button>
        </div>
        <!-- Canvas Body -->
        <div class="offcanvas-body">
          <ul class="list-group p-0">
            <li class="list-group-item active">
              <div class="nav-item-icon-container">
                <i class="bi bi-people"></i>
              </div>
              Customers
            </li>
            <li class="list-group-item">
              <div class="nav-item-icon-container">
                <i class="bi bi-cash-stack"></i>
              </div>
              Payments
            </li>
            <li class="list-group-item">
              <div class="nav-item-icon-container">
                <i class="bi bi-receipt"></i>
              </div>
              Invoices
            </li>
            <li class="list-group-item">
              <div class="nav-item-icon-container">
                <i class="bi bi-file-earmark-spreadsheet"></i>
              </div>
              Statements
            </li>
          </ul>
        </div>
        <!-- Wide Screen Toggle Button -->
        <button
          class="btn btn-primary canvas-button"
          type="button"
          id="offcanvas-toggle-button"
          draggable="true"
          data-bs-toggle="offcanvas"
          data-bs-target="#navigation-canvas"
          aria-controls="navigation-canvas"
        >
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
        <!-- Header Row -->
        <header
          class="custom-header row align-items-center bg-primary text-white py-2"
        >
          <div class="d-none d-sm-block col">
            <nav aria-label="breadcrumb mb-0 pb-0">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#" class="text-white">Dashboard</a>
                </li>
                <li
                  class="breadcrumb-item text-white active"
                  aria-current="page"
                >
                  Customers
                </li>
              </ol>
            </nav>
          </div>
          <div
            class="profile-settings col d-flex align-items-center justify-content-end"
            style="gap: 0.6rem"
          >
            <div class="account-name">Kleenbin Norwood</div>
            <div class="profile-icon-container">
              <i class="bi bi-person-fill fs-3"></i>
            </div>
            <i class="bi bi-gear-fill fs-4"></i>
          </div>
        </header>
        <div class="customer-buttons col p-0 pb-2 mt-3 text-end">
          <button class="btn btn-primary btn-sm">
           <i class="bi bi-people-fill fs-6"></i> View All
          </button>
          <button class="btn btn-primary btn-sm">
           <i class="bi bi-person-fill-add fs-6"></i> Add New Customer
          </button>
        </div>
        <!-- Search Customers Accordion -->
        <div
          class="search-customers col-12 accordion"
          id="search-customer-accordion"
        >
          <div class="accordion-item">
            <div class="accordion-header" id="search-customer-accordion-item">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapseOne"
                aria-expanded="true"
                aria-controls="panelsStayOpen-collapseOne"
              >
                <h2 class="fs-5 mb-0">Search</h2>
              </button>
            </div>
            <div
              id="panelsStayOpen-collapseOne"
              class="accordion-collapse collapse show"
              aria-labelledby="panelsStayOpen-headingOne"
            >
              <!-- Search Accordion Body -->
              <div class="accordion-body">
              <form class="search-functions row" id="search-customer-form">
                <!-- Search input field -->
                <div class="search-bar col-12 col-md-6 col-xl-5">
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      id="search-input"
                      placeholder="Search Customers"
                      aria-label="Search Customers"
                      aria-describedby="search-icon"
                    />
                    <span class="input-group-text" id="search-icon"
                      ><i class="bi bi-search"></i
                    ></span>
                  </div>
                </div>

                <!-- Search by select field -->
                <div class="search-by col">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="search-by-text"
                      >Search by</span
                    >
                    <select
                      class="form-select"
                      id="search-by-select"
                      aria-label="Search By"
                      aria-describedby="search-by-text"
                    >
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
                  <table class="table table-striped table-hover" id="search-results-table">
                    <tbody>
                    </tbody>
                  </table>
                  <div class="d-none" id="no-search-matches">
                    <div class="fs-6 text-secondary text-center" style="border: none; background: none; margin-top: -1rem;" onclick="exit();">No Matches Found</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Customer Details Accordion -->
        <div class="customer work-panel col-12 p-0 mb-3 accordion">
        <?php if (isset($_GET['customer_id'])) { ?>
               <span class="position-absolute badge rounded-pill bg-success" style="z-index: 999; top: -0.5rem; right: 0.5rem">
                  Account Active: <?php echo $surname.' '.mb_substr($name, 0, 1) ; ?>
                  <span class="visually-hidden">Active Account</span>
               </span>
            <?php } ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="customer-details-heading">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#customer-details-collapse"
                aria-expanded="false"
                aria-controls="customer-details-collapse"
              >
                <span class="fs-5">Customer Details</span>
              </button>
            </h2>
            <div
              id="customer-details-collapse"
              class="accordion-collapse collapse"
              aria-labelledby="customer-details-heading"
            >
              <div class="accordion-body">
                <!-- NO CUSTOMER SELECTED DIV -->
                <?php if (!$customerActive) { ?>
                  <div class="row">
                  <?php include "no-customer-selected.html"; ?>
                </div>
                <?php } else { ?>
                <!-- CUSTOMER SELECTED DIV -->
                <div class="row">
                  <!-- Profile Column -->
                  <div
                    class="profile-col col-12 col-md-4 col-lg-3 col-xl-2 text-center align-content-center justify-content-center"
                  >
                    <i class="bi bi-person-fill mb-0"></i>
                    <p class="customer-acc-num fs-1"><?php echo $accountNumber; ?></p>
                  </div>
                  <!-- Personal Details Column -->
                  <form class="details-col col-12 col-md col-xl-4 p-3 mb-0">
                    <div class="title row">
                      <div class="col-auto">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-select" aria-label="Title">
                          <option value="Mr" <?php echo ($title === 'Mr') ? 'selected' : ''; ?>>Mr</option>
                          <option value="Mrs" <?php echo ($title === 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
                          <option value="Ms" <?php echo ($title === 'Ms') ? 'selected' : ''; ?>>Ms</option>
                          <option value="Dr" <?php echo ($title === 'Dr') ? 'selected' : ''; ?>>Dr</option>
                          <option value="Prof" <?php echo ($title === 'Prof') ? 'selected' : ''; ?>>Prof</option>
                        </select>
                      </div>
                    </div>
                    <div class="name-surname row">
                      <div class="name col-sm-6">
                        <label for="name" class="form-label">Name</label>
                        <input
                          type="text"
                          name="name"
                          class="form-control"
                          placeholder="Name"
                          value="<?php echo $name; ?>"
                        />
                      </div>
                      <div class="surname col-sm-6">
                        <label for="surname" class="form-label">Surname</label>
                        <input
                          type="text"
                          name="surname"
                          class="form-control"
                          placeholder="Surname"
                          value="<?php echo $surname; ?>"
                        />
                      </div>
                    </div>
                    <div class="address row">
                      <div class="col">
                        <label for="address" class="form-label">Address</label>
                        <input
                          type="text"
                          name="address"
                          class="form-control"
                          placeholder="Address"
                          value="<?php echo $address;?>"
                        />
                      </div>
                    </div>
                    <div class="suburb-postal row">
                      <div class="suburb col">
                        <label for="suburb" class="form-label">Suburb</label>
                        <input
                          type="text"
                          name="suburb"
                          class="form-control"
                          placeholder="Suburb"
                          value="<?php echo $suburb; ?>"
                        />
                      </div>
                      <div class="postal col-4">
                        <label for="postal" class="form-label">Postal</label>
                        <input
                          type="text"
                          name="postal"
                          class="form-control"
                          placeholder="Postal"
                          value="<?php echo $postalCode; ?>"
                        />
                      </div>
                    </div>
                    <div class="email row">
                      <div class="col">
                        <label for="email" class="form-label"
                          >Email Address</label
                        >
                        <input
                          type="email"
                          name="email"
                          class="form-control"
                          placeholder="Email Address"
                          value="<?php echo $email; ?>"
                        />
                      </div>
                    </div>
                    <div class="contact row">
                      <div class="col-12">
                        <label for="contacts" class="form-label">
                          Contacts
                        </label>
                        <div
                          name="contacts"
                          class="contact-container overflow-auto rounded border p-2"
                        >
                        <?php if(!empty($contacts)) {
                          foreach ($contacts as $contact) {
                            $contactID = $contact['contact_id'];
                            $contactTitle = $contact['contact_title'];
                            $contactNumber = $contact['contact'];
                            $countryCode = $contact['country_code'];?>
                          <div class="contact-card card mb-2" data-contact-id="<?php echo $contactID; ?>">
                            <div class="card-body pb-1">
                              <div class="row p-0">
                                <div
                                  class="col-12 col-lg-4 col-xl-12 text-truncate"
                                >
                                  <?php echo $contactTitle ?>
                                </div>
                                <div class="col-10 col-md col-xl">
                                  <div class="badge bg-secondary"><?php echo $countryCode;?></div>
                                  <?php echo $contactNumber;?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php }} else { ?>
                            <div class="no-contacts text-secondary">
                              No Contacts to display
                            </div>
                            <?php } ?>
                        </div>
                      </div>
                      <div class="col mt-2 text-end">
                        <button class="btn btn-sm btn-primary">
                          Add Contact
                        </button>
                      </div>
                    </div>
                    <div class="origin-active row">
                      <div class="origin col-12">
                        <label for="origin" class="form-label mb-0"
                          >Origin</label
                        >
                        <input
                          type="text"
                          name="origin"
                          id="origin"
                          class="form-control"
                          placeholder="Origin"
                          value="<?php echo $origin; ?>"
                        />
                      </div>
                      <?php if($active) { ?>
                      <div class="active col">
                        <button
                          class="deactivate-customer-btn btn btn-sm btn-danger"
                          style="background-color: red"
                        >
                          Deactivate Customer
                        </button>
                      </div>
                      <?php }?>
                    </div>
                  </form>
                  <!-- Comments Column -->
                  <div class="comments-col p-3 mb-4 col-12 col-md-12 col-xl">
                    <label for="comments">Comments</label>
                    <div class="col">
                      <div
                        class="comments-container overflow-auto border rounded p-2"
                      >
                      <?php if (!empty($comments)) { 
                        foreach ($comments as $comment) {
                          $commentID = $comment['comment_id'];
                          $commentTitle = $comment['comment_title'];
                          $commentText = $comment['comment_text'];
                          $commentDatePosted = date('d/m/Y H:i', strtotime($comment['date_time_added']));?>
                        <div class="card" data-comment-id="<?php echo $commentID; ?>">
                          <div class="card-body">
                            <div class="col-12"><?php echo $commentTitle; ?></div>
                            <div class="col-12 fs-6 text-secondary">
                              <i><?php echo $commentText; ?></i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted: <?php echo $commentDatePosted; ?>
                            </div>
                          </div>
                        </div>
                        <?php }} else { ?>
                          <div class="no-comments text-secondary">
                            No comments to display
                          </div>
                          <?php } ?>
                      </div>
                      <div class="col text-end mt-2">
                        <button class="btn btn-primary btn-sm">
                          Add Comment
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="sanitize-finance col-12">
          <div class="row" style="padding-inline: 0.7rem; gap: 1rem">
            <!-- Sanitizing Details Accordion -->
            <div
              class="sanitizing-details col-12 col-lg-6 accordion p-0"
              id="sanitizing-details-accordion"
            >
            <?php if (isset($_GET['customer_id'])) { ?>
               <span class="position-absolute badge rounded-pill bg-success" style="z-index: 999; top: -0.5rem; right: 0.5rem">
                  Account Active: <?php echo $surname.' '.mb_substr($name, 0, 1) ; ?>
                  <span class="visually-hidden">Active Account</span>
               </span>
            <?php } ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="sanitizing-details-heading">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#sanitizing-details-collapse"
                    aria-expanded="false"
                    aria-controls="sanitizing-details-collapse"
                  >
                    <span class="fs-5">Sanitizing Details</span>
                  </button>
                </h2>
                <div
                  id="sanitizing-details-collapse"
                  class="accordion-collapse collapse"
                  aria-labelledby="sanitizing-details-heading"
                >
                  <!-- Sanitizing Details Body -->
                  <div class="accordion-body p-3">
                    <!-- CUSTOMER NOT SELECTED -->
                    <?php if (!$customerActive) {
                    include "no-customer-selected.html";
                    } else { ?>
                    <!-- CUSTOMER SELECTED -->
                    <form action="" class="bin-details row p-0">
                      <!-- Frequency -->
                      <div class="col-12 col-sm-4 col-lg-12 col-xxl-3">
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="frequency-label"
                            >Frequency</span
                          >
                          <input
                            type="number"
                            class="form-control"
                            min="1"
                            max="4"
                            aria-label="Frequency"
                            aria-describedby="frequency-label"
                            value="<?php echo $frequency;?>"
                          />
                        </div>
                      </div>
                      <!-- Sanitizing Day -->
                      <div class="col-12 col-sm col-lg-12 col-xxl">
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="sanitizing-day"
                            >Day</span
                          >
                          <select id="day-select" class="form-select" aria-label="Sanitizing Day" aria-describedby="sanitizing-day">
                            <option value="Monday" <?php echo (ucfirst($day) === 'Monday') ? 'selected' : ''; ?>>Monday</option>
                            <option value="Tuesday" <?php echo (ucfirst($day) === 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                            <option value="Wednesday" <?php echo (ucfirst($day) === 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                            <option value="Thursday" <?php echo (ucfirst($day) === 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                            <option value="Friday" <?php echo (ucfirst($day) === 'Friday') ? 'selected' : ''; ?>>Friday</option>
                          </select>
                        </div>
                      </div>
                      <!-- Monthly Fee -->
                      <div class="col-12">
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="monthly-fee-label"
                            >Monthly Fee</span
                          >
                          <span class="input-group-text" id="currency-label"
                            >R</span
                          >
                          <input
                            type="number"
                            class="form-control"
                            aria-label="Rand"
                            step="10"
                            min="1"
                            aria-describedby="monthly-fee-label"
                            value="<?php echo $monthlyRate; ?>"
                          />
                        </div>
                      </div>
                    </form>
                    <div class="dustbins row gx-0">
                      <div class="col-12">Dustbins</div>
                      <!-- Dustbins container -->
                      <div class="dustbins-container col-12 overflow-auto border rounded p-2">
                        <!-- Dustbin card -->
                        <?php if (!empty($bins)) {
                          foreach ($bins as $bin) {
                            $binSerialNum = $bin['serial_number']?>
                        <div class="card" data-bin-id="<?php echo  $binSerialNum; ?>">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-2">
                                <!-- iCon by oNlineWebFonts.Com -->
                                <img
                                  src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gU3ZnIFZlY3RvciBJY29ucyA6IGh0dHA6Ly93d3cub25saW5ld2ViZm9udHMuY29tL2ljb24gLS0+DQo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMjU2IDI1NiIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjU2IDI1NiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8bWV0YWRhdGE+IFN2ZyBWZWN0b3IgSWNvbnMgOiBodHRwOi8vd3d3Lm9ubGluZXdlYmZvbnRzLmNvbS9pY29uIDwvbWV0YWRhdGE+DQo8Zz48Zz48Zz48cGF0aCBmaWxsPSIjMDAwMDAwIiBkPSJNODUuMiwxMC4zYy0yLjcsMC42LTMuOSwxLjEtNi4xLDIuN2MtMi40LDEuOC00LjcsNS41LTUsOC40Yy0wLjMsMi4xLTAuNCwyLjItMiwyLjRjLTUuOCwwLjktMTAuMSwyLjctMTMuNCw1LjdjLTIsMS43LTQuMSw1LTQuOCw3LjNMNTMuNSwzOGg1OS44aDU5LjhsMS4xLDEuMmMyLDEuOSwxLjMsNC44LTEuMyw1LjhjLTAuOCwwLjMtMjEuNiwwLjUtNjMuNywwLjVINDYuNnY1LjV2NS41aDMuOWgzLjlsMC4zLDEuOWMwLjEsMS4xLDQuNCw0My42LDkuNSw5NC40YzUuMSw1MC44LDkuNCw5Mi42LDkuNSw5Mi44YzAuMywwLjUsNjcuMSwwLjYsNjcuMSwwLjFjMC0wLjEtMS0xLjQtMi4zLTIuOGMtMi42LTIuOC01LjItNy44LTYuMi0xMS45Yy0wLjktMy41LTAuOS0xMC4yLDAtMTRjMS44LTcuNCw3LjgtMTUuMiwxNC4zLTE4LjVjNS43LTMsNy42LTMuNCwxNC40LTMuNGM0LjYsMCw2LjEtMC4xLDYuMS0wLjZjMC0yLjQsMTItMTE5LjgsMTIuMy0xMjBjMC4yLTAuMiw2LjUtNS4yLDE0LTExLjJjMTAuMS04LDEzLjktMTEuMywxNC43LTEyLjdjMS41LTIuNiwxLjgtNi4yLDAuOC05LjNjLTAuNy0yLjItMS42LTMuMy03LjYtOS4yYy02LjEtNi4xLTctNi44LTkuMi03LjVjLTIuMi0wLjYtNi44LTAuNy0zOC43LTAuN2gtMzYuMXYtMS42YzAtMC45LTAuNi0yLjktMS41LTQuNWMtMS42LTMuMS00LjYtNS44LTcuNi02LjlDMTA2LDEwLjEsODgsOS43LDg1LjIsMTAuM3ogTTEwNS40LDE5LjdjMS42LDAuNiwyLjUsMS45LDIuNSwzLjJjMCwwLjYtMS41LDAuNy0xMi41LDAuN2MtMTEuNiwwLTEyLjUsMC0xMi41LTAuOGMwLTEuMSwxLjQtMi43LDIuOC0zLjNDODcuNywxOC44LDEwMy42LDE4LjksMTA1LjQsMTkuN3ogTTIwMC43LDQxLjRjNC4yLDIuMiwyLjMsOC41LTIuNSw4LjVjLTAuNiwwLTEuOC0wLjYtMi43LTEuM2MtMS4yLTEuMS0xLjUtMS43LTEuNS0zLjNjMC0xLjYsMC4zLTIuMiwxLjUtMy4zQzE5Ny4yLDQwLjYsMTk4LjcsNDAuNCwyMDAuNyw0MS40eiBNMTI0LDY4YzEuMywxLjIsMS40LDMuMSwwLjIsNC42bC0wLjksMS4xbC0xMy43LDAuMWMtMTEuOSwwLjEtMTMuOCwwLTE0LjktMC42Yy0xLjQtMS0yLTIuNC0xLjQtMy45YzAuOC0yLjMsMS0yLjMsMTUuOC0yLjNDMTIyLjYsNjcsMTIyLjksNjcsMTI0LDY4eiIvPjxwYXRoIGZpbGw9IiMwMDAwMDAiIGQ9Ik0xNTUuNiwyMDIuOGMtNy43LDEuOS0xNCw4LjEtMTYsMTUuN2MtMS45LDcuMywwLDE0LjYsNS40LDIwLjNjMTEuNiwxMi40LDMyLjMsNy4xLDM2LjgtOS41YzAuOC0zLjEsMC42LTguNi0wLjQtMTEuOUMxNzgsMjA2LjcsMTY2LjYsMjAwLjIsMTU1LjYsMjAyLjh6IE0xNjMuOCwyMTcuNWMyLjgsMS40LDQuMiwzLjYsNC4yLDYuNWMwLDcuMy05LDEwLTEzLjUsMy45Yy0yLjQtMy4yLTAuOS04LjQsMi45LTEwLjRDMTU5LjgsMjE2LjIsMTYxLjIsMjE2LjIsMTYzLjgsMjE3LjV6Ii8+PC9nPjwvZz48L2c+DQo8L3N2Zz4="
                                  width="40rem"
                                  height="40rem"
                                />
                              </div>
                              <div class="col">
                                <span class="fs-5 font-monospace"
                                  ><?php echo  $binSerialNum; ?></span
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }} else { ?>
                          <div class="no-dustbins text-secondary">
                            No dustbins to display
                          </div>
                          <?php } ?>
                      </div>
                      <div class="col p-0 mt-2 text-end">
                        <button class="btn btn-primary btn-sm">Add Bin</button>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Finance Panel Accordion -->
            <div
              class="finance col-12 col-lg accordion p-0"
              id="finance-accordion"
            >
            <?php if (isset($_GET['customer_id'])) { ?>
               <span class="position-absolute badge rounded-pill bg-success" style="z-index: 999; top: -0.5rem; right: 0.5rem">
                  Account Active: <?php echo $surname.' '.mb_substr($name, 0, 1) ; ?>
                  <span class="visually-hidden">Active Account</span>
               </span>
            <?php } ?>
              <div class="accordion-item">
                <h2 class="accordion-header" id="finance-heading">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#finance-collapse"
                    aria-expanded="false"
                    aria-controls="finance-collapse"
                  >
                    <span class="fs-5">Finance</span>
                  </button>
                </h2>
                <div
                  id="finance-collapse"
                  class="accordion-collapse collapse"
                  aria-labelledby="finance-heading"
                >
                  <!-- Finance Panel Body -->
                  <div class="accordion-body">
                    <?php if (!$customerActive) {
                    include "no-customer-selected.html";
                    } else { ?>
                    <!-- Payments Col -->
                    <div class="payments col">
                      <div class="row mb-3">
                        <h3 class="col-12 fs-6 col-sm-6 col-lg-12 col-xxl-6">
                          <b>Payments</b>
                        </h3>
                        <div
                          class="col-12 col-sm text-sm-end col-lg-12 text-lg-start col-xxl text-xxl-end"
                        >
                          Current Balance
                          <span class="fs-6 badge bg-secondary">R20</span>
                        </div>
                      </div>
                      <div
                        class="payments-container overflow-auto border rounded p-2"
                      >
                        <!-- Payment Card -->
                        <?php if(!empty($payments)) {
                          foreach($payments as $payment) {
                            $paymentID = $payment['payment_id'];
                            $paymentDate = date('F d, Y', strtotime($payment['payment_date']));
                            $paymentAmount = $payment['payment_amount'];
                            $paymentType = $payment['payment_type'];?>
                        <div class="card" data-payment-id="<?php echo $paymentID; ?>">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #<?php echo $paymentID; ?>
                            </div>
                            <div class="row">
                              <div class="col"><?php echo $paymentDate; ?></div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                <?php echo $paymentType;?>
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R <?php echo $paymentAmount;?>
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }} else {?>
                          <div class="no-payments text-secondary">
                            No Payments to display
                          </div>
                          <?php }?>
                      </div>
                    </div>
                    <!-- Invoices Col -->
                    <div class="invoices col mt-3">
                      <div class="col-12 mb-3"><b>Invoices</b></div>
                      <div
                        class="invoices-container col-12 border rounded p-2 overflow-auto"
                      >
                        <!-- Invoice Card -->
                        <?php if(!empty($invoices)) {
                          foreach($invoices as $invoice) {
                            $invoiceID = $invoice['invoice_id'];
                            $invoiceAmount = $invoice['invoice_amount'];
                            $invoiceDate = date('F d, Y', strtotime($invoice['invoice_date']));?>
                        <div class="card" data-invoice-id="<?php echo $invoiceID; ?>">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #<?php echo $invoiceID;?>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col"><?php echo $invoiceDate;?></div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R <?php echo $invoiceAmount ?>
                              </div>
                              <div
                                class="pdf-icon col col-12 col-sm col-lg-12 col-xxl text-end"
                              >
                                <a href="" class="link-success">
                                  <i class="bi bi-file-earmark-pdf-fill"></i>
                                  PDF</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php }} else { ?>
                          <div class="no-invoices text-secondary">
                            No Invoices to display
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="search.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Function to get URL parameter by name
      function getURLParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
      }

      // Function to apply the success border color to all accordion elements
      function colorAccordions() {
        const customer_id = getURLParameter('customer_id');

        if (customer_id) {
          // Get all accordion elements
          const accordions = document.querySelectorAll('.accordion:not(.search-customers)');

          // Loop through the accordion elements and apply the success border color
          accordions.forEach((accordion) => {
            // Add the success border color to the .accordion-item class
            const accordionItems = accordion.querySelectorAll('.accordion-item');
            accordionItems.forEach((item) => {
              item.classList.add('border-3');
            });
          });

          // Collapse the .search-customers accordion
          const searchCustomersAccordion = document.querySelector('.search-customers');
          if (searchCustomersAccordion) {
            // Get the accordion header button
            const headerButton = searchCustomersAccordion.querySelector('.accordion-header > button');
            if (headerButton) {
              // Add the collapsed class and set aria-expanded to false
              headerButton.classList.add('collapsed');
              headerButton.setAttribute('aria-expanded', 'false');
            }

            // Collapse the .search-customers accordion content
            const accordionCollapse = searchCustomersAccordion.querySelector('.accordion-collapse');
            if (accordionCollapse) {
              // Remove the show class and add the collapse class
              accordionCollapse.classList.remove('show');
              accordionCollapse.classList.add('collapse');
            }
          }
        }
      }

      // Call the function to color the accordions on document load
      document.addEventListener('DOMContentLoaded', colorAccordions);
    </script>
  </body>
</html>
