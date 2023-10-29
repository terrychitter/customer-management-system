var searchResults = [];
var selectedCustomers = [];
var allResults = [];

function removeItem(item, list) {
    let index = list.findIndex((customer) => customer.account_number === item.account_number);
    if (index !== -1) {
        list.splice(index, 1);
    }
}

function appendList(item, list) {
    if (!list.some((customer) => customer.account_number === item.account_number)) {
        list.push(item);
    }
}

// Function to check if a record exists in the selectedCustomers list based on the account number
function isCustomerSelected(customer, selectedCustomers) {
    for (let i = 0; i < selectedCustomers.length; i++) {
        if (selectedCustomers[i].account_number === customer.account_number) {
            return true;
        }
    }
    return false;
}

// Function to send AJAX request to search customers
function searchCustomers(searchTerm, searchBy, flitersRadio, filtersCheck) {
    // Show the spinner while waiting for results
    const spinnerElement = document.getElementById("search-results-spinner");
    spinnerElement.style.display = "inline-block";

    // Create a data object to hold the search data
    const searchData = {
        searchTerm: searchTerm,
        searchBy: searchBy,
        filtersRadio: flitersRadio,
        filtersCheck: filtersCheck
    };

    // Send AJAX request to PHP script
    fetch("search_customers_invoice.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the correct Content-Type
            },
            body: new URLSearchParams(searchData).toString(), // Serialize the data
        })
        .then((response) => response.json())
        .then((data) => {
            searchResults = data;
            allResults = JSON.parse(JSON.stringify(data));
            updateSearchResultsTable();
            updateSelectedCustomersTable();
            toggleEmptyTable(data.length === 0, 'no-search-matches'); // Check if there are no search results
            toggleMoveRemoveButtons();
            spinnerElement.style.display = "none"; // Hide the spinner
        })
        .catch((error) => console.error("Error:", error));
    spinnerElement.style.display = "none"; // Hide the spinner
}

// Function to toggle the visibility of "No Matches" message
function toggleEmptyTable(noMatches, table) {
    const noSearchMatchesElement = document.getElementById(table);
    if (noMatches) {
        noSearchMatchesElement.classList.remove("d-none");
        noSearchMatchesElement.classList.add("d-block");
    } else {
        noSearchMatchesElement.classList.remove("d-block");
        noSearchMatchesElement.classList.add("d-none");
    }
}

// Function to update the table with the search results
function updateSearchResultsTable() {
    // Get the table body element
    const tableBody = document.querySelector("#search-results-table tbody");

    // Clear the current table content
    tableBody.innerHTML = "";

    // Loop through the results and create table rows
    allResults.forEach((customer) => {

        const row = document.createElement("tr");

        // Add data-id attribute with the customer's account number
        row.setAttribute("data-id", customer.account_number);

        // Add onclick event to the table row
        row.onclick = function() {
            // Add Customer to selected customers table and remove it from search table IF IT IS NOT IN THE SELECTED CUSTOMERS LIST
            if (!isCustomerSelected(customer, selectedCustomers)) {
                appendList(customer, selectedCustomers);
                removeItem(customer, searchResults);
                updateSelectedCustomersTable();
                updateSearchResultsTable();
            } else {
                // Add Customer to the search results list and remove it from the selected customers table
                appendList(customer, searchResults);
                removeItem(customer, selectedCustomers);
                updateSelectedCustomersTable();
                updateSearchResultsTable();
            }
        };

        // Create and add table data cells
        const accountNumberCell = document.createElement("td");
        accountNumberCell.textContent = customer.account_number;
        row.appendChild(accountNumberCell);

        const nameSurnameCell = document.createElement("td");
        nameSurnameCell.textContent = `${customer.surname} ${customer.name.charAt(
                0
            )}.`;
        row.appendChild(nameSurnameCell);

        const addressCell = document.createElement("td");
        addressCell.textContent = customer.address;
        row.appendChild(addressCell);

        const addToListCell = document.createElement("td");

        if (!isCustomerSelected(customer, selectedCustomers)) {
            addToListCell.innerHTML = "<i class=\"bi bi-plus-circle-fill fs-4 text-success\"></i>";
        } else {
            addToListCell.innerHTML = "<i class=\"bi bi-dash-circle-fill fs-4 text-danger\"></i>";
        }
        row.appendChild(addToListCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });

    toggleMoveRemoveButtons();
}

// Function to update the table with the selected customers
function updateSelectedCustomersTable() {
    // Get the table body element
    const tableBody = document.querySelector("#selected_customers_table");

    // Clear the current table content
    tableBody.innerHTML = "<tbody></tbody>";

    // Loop through the results and create table rows
    selectedCustomers.forEach((customer) => {

        const row = document.createElement("tr");

        // Add data-id attribute with the customer's account number
        row.setAttribute("data-id", customer.account_number);

        // Add onclick event to the table row
        row.onclick = function() {
            // Remove the customer from the selected customers list
                removeItem(customer, selectedCustomers);
                appendList(customer, searchResults);
                updateSelectedCustomersTable();
                updateSearchResultsTable();
        };

        // Create and add table data cells
        const accountNumberCell = document.createElement("td");
        accountNumberCell.textContent = customer.account_number;
        row.appendChild(accountNumberCell);

        const nameSurnameCell = document.createElement("td");
        nameSurnameCell.textContent = `${customer.surname} ${customer.name.charAt(
                0
            )}.`;
        row.appendChild(nameSurnameCell);

        const addressCell = document.createElement("td");
        addressCell.textContent = customer.address;
        row.appendChild(addressCell);

        const addToListCell = document.createElement("td");
        addToListCell.innerHTML = "<i class=\"bi bi-dash-circle-fill fs-4 text-danger\"></i>";
        row.appendChild(addToListCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });

    toggleEmptyTable(selectedCustomers.length === 0, 'no-selected-customers');
    toggleMoveRemoveButtons();
}

// Debounce function to delay the search after the input changes
function debounce(func, delay) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

// Function to handle search input changes and perform search
function handleSearch() {
    const searchTerm = document.querySelector("#search-input").value;
    const searchBy = document.querySelector("#search-by-select").value;
    var filtersCheckDiv = document.getElementById('inactive-filter');
    
    if (filtersCheckDiv.checked) {
        filtersCheck = true
    } else {
        filtersCheck = false;
    }

    var radioButtons = document.getElementsByName('search-filter-radio');

    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            var flitersRadio = radioButtons[i].value;
            break;
        }
    }

    // Debounce the search to wait 2 seconds after the input changes
    // Show the spinner
    const spinnerElement = document.getElementById("search-results-spinner");
    // Get the table body element
    const tableBody = document.querySelector("#search-results-table tbody");
    tableBody.innerHTML = "";

    // Show the spinner
    spinnerElement.style.display = "inline-block";

    // Clear the current table content
    debounce(searchCustomers, 1000)(searchTerm, searchBy, flitersRadio, filtersCheck);
}

function moveAllToSelected() {
    for (let i = 0; i < searchResults.length; i++) {
        if (!isCustomerSelected(searchResults[i], selectedCustomers)) {
            appendList(searchResults[i], selectedCustomers);
        }
    }
    searchResults = [];
    updateSelectedCustomersTable();
    updateSearchResultsTable();
}

function moveAllToSearchResults() {
    for (let i = 0; i < selectedCustomers.length; i++) {
        if (!isCustomerSelected(selectedCustomers[i], searchResults)) {
            appendList(selectedCustomers[i], searchResults);
        }
    }
    selectedCustomers = [];
    updateSelectedCustomersTable();
    updateSearchResultsTable();
}

var moveAllButton = document.getElementById("move-all-selected-button");
var removeAllButton = document.getElementById("move-all-search-button");

moveAllButton.addEventListener('click', moveAllToSelected);
removeAllButton.addEventListener('click', moveAllToSearchResults);

function toggleMoveRemoveButtons() {
    if (allResults.length > 0 || cu) {
        moveAllButton.classList.add('d-block');
        moveAllButton.classList.remove('d-none');
    } else {
        moveAllButton.classList.add('d-none');
        moveAllButton.classList.remove('d-block');
    }

    if (selectedCustomers.length > 0) {
        removeAllButton.classList.add('d-block');
        removeAllButton.classList.remove('d-none');
    } else {
        removeAllButton.classList.add('d-none');
        removeAllButton.classList.remove('d-block');
    }

}

// Add event listener to the search input
document.querySelector("#search-input").addEventListener("input", handleSearch);

// Add event listener to the search select
document
    .querySelector("#search-by-select")
    .addEventListener("change", handleSearch);

// Get all radio buttons by name
var radioButtons = document.getElementsByName('search-filter-radio');

// Add event listener to each radio button
radioButtons.forEach(function(radio) {
    radio.addEventListener('change', handleSearch);
});

// Add event listener to check button
var filtersCheckDiv = document.getElementById('inactive-filter');
filtersCheckDiv.addEventListener('change', handleSearch);

handleSearch();

function handleEventUpdates(event) {
    console.log(event.data);
  }
  
  document.getElementById("generate-invoices-button").addEventListener("click", function () {
    const month = document.getElementsByName("month")[0].value;
    const year = document.getElementsByName("year")[0].value;
    const bfDate = document.getElementsByName("bf-date")[0].value;
    const feeDate = document.getElementsByName("fee-date")[0].value;
    const issueDate = document.getElementsByName("issue-date")[0].value;
    // Convert the customersArray to send an array
    const customersArray = selectedCustomers.map(customer => customer.account_number);
  
    const requestData = {
      month: month,
      year: year,
      "bf-date": bfDate,
      "fee-date": feeDate,
      "issue-date": issueDate,
      customers: customersArray
    };
  
    // Sending the fetch request
    fetch("../invoice_generation/generate_invoices.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams(requestData)
    })
      .then(response => {
        if (response.ok) {
          // If the response is successful, start listening to the server-sent events
          console.log('Processed all invoices');
        } else {
          console.error("Network response was not ok");
        }
      })
      .catch(error => {
        console.error("Error:", error);
      });
  });




