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
    session_start();

    $customerActive = false;
    $customerID = '0';

    if (isset($_GET['customer_id'])) {
      $customerActive = true;
      $customerID = $_GET['customer_id'];
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
                <div class="search-functions row">
                  <div class="search-bar col-12 col-md-6 col-xl-5">
                    <div class="input-group mb-3">
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Search Customers"
                        aria-label="Search Customers"
                        aria-describedby="search-icon"
                      />
                      <span class="input-group-text" id="search-icon"
                        ><i class="bi bi-search"></i
                      ></span>
                    </div>
                  </div>
                  <div class="search-by col">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="search-by-text"
                        >Search by</span
                      >
                      <select
                        class="form-select"
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
                </div>
                <div class="row search-results gx-0">
                  <h3 style="font-size: 0.9rem; margin-bottom: 0;">Search Results</h3>
                  <table class="table table-striped table-hover">
                    <tbody>
                      <tr>
                        <th scope="row">901</th>
                        <td>Doe J.</td>
                        <td>22 Cactus Lane</td>
                      </tr>
                      <tr>
                        <th scope="row">901</th>
                        <td>Doe J.</td>
                        <td>22 Cactus Lane</td>
                      </tr>
                      <tr>
                        <th scope="row">901</th>
                        <td>Doe J.</td>
                        <td>22 Cactus Lane</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Customer Details Accordion -->
        <div class="customer work-panel col-12 p-0 mb-3 accordion">
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
                    <p class="customer-acc-num fs-1">901</p>
                  </div>
                  <!-- Personal Details Column -->
                  <form class="details-col col-12 col-md col-xl-4 p-3 mb-0">
                    <div class="title row">
                      <div class="col-auto">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-select" aria-label="Title">
                          <option value="Mr">Mr</option>
                          <option value="Mrs">Ms</option>
                          <option value="Ms">Ms</option>
                          <option value="Dr">Dr</option>
                          <option value="Prof">Prof</option>
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
                        />
                      </div>
                      <div class="surname col-sm-6">
                        <label for="surname" class="form-label">Surname</label>
                        <input
                          type="text"
                          name="surname"
                          class="form-control"
                          placeholder="Surname"
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
                        />
                      </div>
                      <div class="postal col-4">
                        <label for="postal" class="form-label">Postal</label>
                        <input
                          type="text"
                          name="postal"
                          class="form-control"
                          placeholder="Postal"
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
                          <div class="contact-card card mb-2">
                            <div class="card-body pb-1">
                              <div class="row p-0">
                                <div
                                  class="col-12 col-lg-4 col-xl-12 text-truncate"
                                >
                                  Home Number
                                </div>
                                <div class="col-10 col-md col-xl">
                                  <div class="badge bg-secondary">+27</div>
                                  763220935
                                </div>
                              </div>
                            </div>
                          </div>
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
                        />
                      </div>
                      <div class="active col">
                        <button
                          class="deactivate-customer-btn btn btn-sm btn-danger"
                          style="background-color: red"
                        >
                          Deactivate Customer
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- Comments Column -->
                  <div class="comments-col p-3 mb-4 col-12 col-md-12 col-xl">
                    <label for="comments">Comments</label>
                    <div class="col h-100">
                      <div
                        class="comments-container overflow-auto border rounded p-2 h-100"
                      >
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <div class="col-12">Comment Title</div>
                            <div class="col-12 fs-6 text-secondary">
                              <i
                                >Lorem ipsum dolor, sit amet consectetur
                                adipisicing elit. Dolorem soluta unde ratione
                                provident cum debitis laboriosam consequatur,
                                autem assumenda commodi consequuntur eos
                                blanditiis ullam quo quae incidunt? Fuga, a
                                sit!</i
                              >
                            </div>
                            <div
                              class="col-12 text-secondary text-end"
                              style="font-size: 0.7rem"
                            >
                              Posted:23/07/12 19:36
                            </div>
                          </div>
                        </div>
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
                          />
                        </div>
                      </div>
                      <!-- Sanitizing Day -->
                      <div class="col-12 col-sm col-lg-12 col-xxl">
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="sanitizing-day"
                            >Day</span
                          >
                          <select
                            class="form-select"
                            aria-label="Sanitizing Day"
                            aria-describedby="sanitizing-day"
                          >
                            <option value="monday" selected>Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
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
                          />
                        </div>
                      </div>
                    </form>
                    <div class="dustbins row gx-0">
                      <div class="col-12">Dustbins</div>
                      <!-- Dustbins container -->
                      <div
                        class="dustbins-container col-12 overflow-auto border rounded p-2"
                      >
                        <!-- Dustbin card -->
                        <div class="card">
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
                                  >3808101019</span
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Dustbin card -->
                        <div class="card">
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
                                  >3808101019</span
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Dustbin card -->
                        <div class="card">
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
                                  >3808101019</span
                                >
                              </div>
                            </div>
                          </div>
                        </div>
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
                        <div class="card">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #221208CA901
                            </div>
                            <div class="row">
                              <div class="col">2022/12/08</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                CASH
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R22.00
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Payment Card -->
                        <div class="card">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #221208CA901
                            </div>
                            <div class="row">
                              <div class="col">2022/12/08</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                CASH
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R22.00
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Payment Card -->
                        <div class="card">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #221208CA901
                            </div>
                            <div class="row">
                              <div class="col">2022/12/08</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                CASH
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R22.00
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Payment Card -->
                        <div class="card">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #221208CA901
                            </div>
                            <div class="row">
                              <div class="col">2022/12/08</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                CASH
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R22.00
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Payment Card -->
                        <div class="card">
                          <div class="card-body p-2">
                            <div class="col-12" style="font-size: 0.7rem">
                              #221208CA901
                            </div>
                            <div class="row">
                              <div class="col">2022/12/08</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                CASH
                              </div>
                              <div
                                class="col-12 col-sm col-lg-12 col-xxl text-end text-success"
                              >
                                + R22.00
                                <i class="bi bi-cash-coin ms-1"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Invoices Col -->
                    <div class="invoices col mt-3">
                      <div class="col-12 mb-3"><b>Invoices</b></div>
                      <div
                        class="invoices-container col-12 border rounded p-2 overflow-auto"
                      >
                        <!-- Invoice Card -->
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col" style="font-size: 0.7rem">
                                #2201901
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">March, 01, 2022</div>
                              <div
                                class="col text-end text-sm-center text-lg-end text-xxl-center"
                              >
                                R 180.00
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
