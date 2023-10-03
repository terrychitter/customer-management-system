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
                        <i class="bi bi-gear-fill fs-4"></i>
                    </div>
                </header>
            </main>
            <script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
    </body>

</html>