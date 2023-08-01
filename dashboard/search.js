// Function to send AJAX request to search customers
function searchCustomers(searchTerm, searchBy) {
  // Show the spinner while waiting for results
  const spinnerElement = document.getElementById("search-results-spinner");
  spinnerElement.style.display = "inline-block";

  // Create a data object to hold the search data
  const searchData = {
    searchTerm: searchTerm,
    searchBy: searchBy,
  };

  // Send AJAX request to PHP script
  fetch("search_customers.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded", // Set the correct Content-Type
    },
    body: new URLSearchParams(searchData).toString(), // Serialize the data
  })
    .then((response) => response.json())
    .then((data) => {
      updateTable(data);
      toggleNoSearchMatches(data.length === 0); // Check if there are no search results
      spinnerElement.style.display = "none"; // Hide the spinner
    })
    .catch((error) => console.error("Error:", error));
  spinnerElement.style.display = "none"; // Hide the spinner
}

// Function to toggle the visibility of "No Matches" message
function toggleNoSearchMatches(noMatches) {
  const noSearchMatchesElement = document.getElementById("no-search-matches");
  if (noMatches) {
    noSearchMatchesElement.classList.remove("d-none");
    noSearchMatchesElement.classList.add("d-block");
  } else {
    noSearchMatchesElement.classList.remove("d-block");
    noSearchMatchesElement.classList.add("d-none");
  }
}

// Function to update the table with the search results
function updateTable(results) {
  // Get the table body element
  const tableBody = document.querySelector("#search-results-table tbody");

  // Clear the current table content
  tableBody.innerHTML = "";

  // Loop through the results and create table rows
  results.forEach((customer) => {
    const row = document.createElement("tr");

    // Add data-id attribute with the customer's account number
    row.setAttribute("data-id", customer.account_number);

    // Add onclick event to the table row
    row.onclick = function () {
      // Update the URL to include customer_id parameter
      window.location.href = `customer.php?customer_id=${customer.account_number}`;
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

    // Append the row to the table body
    tableBody.appendChild(row);
  });
}

// Debounce function to delay the search after the input changes
function debounce(func, delay) {
  let timer;
  return function (...args) {
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

  // Debounce the search to wait 2 seconds after the input changes
  // Show the spinner
  const spinnerElement = document.getElementById("search-results-spinner");
  // Get the table body element
  const tableBody = document.querySelector("#search-results-table tbody");
  tableBody.innerHTML = "";

  // Show the spinner
  spinnerElement.style.display = "inline-block";

  // Clear the current table content
  debounce(searchCustomers, 1000)(searchTerm, searchBy);
}

// Add event listener to the search input
document.querySelector("#search-input").addEventListener("input", handleSearch);

// Add event listener to the search select
document
  .querySelector("#search-by-select")
  .addEventListener("change", handleSearch);

handleSearch();
