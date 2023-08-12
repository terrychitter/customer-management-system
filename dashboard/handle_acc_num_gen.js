var statusElement = document.getElementById("modal-account-number-status");
var accountNumberInput = document.getElementById("modal-add-customer-acc-num");

document
  .getElementById("add-customer-modal-toggle")
  .addEventListener("click", getNextAccountNum);
document
  .getElementById("modal-add-customer-refresh")
  .addEventListener("click", getNextAccountNum);

accountNumberInput.addEventListener("input", function () {
  var accountNumber = this.value; // Get the entered account number

  if (!accountNumber.trim()) {
    statusElement.textContent = "Please enter an account number";
    statusElement.classList.remove("text-success", "text-danger");
    statusElement.classList.add("text-muted");
    statusElement.classList.remove("d-none");
    accountNumberInput.dataset.available = "false";
    return;
  }

  // Create an AJAX request to check account number availability
  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "acc_num_available.php?account_number=" + accountNumber,
    true
  );

  // Define the callback function to handle the response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var available = xhr.responseText === "true";

        if (available) {
          statusElement.textContent =
            "This account number is available for use!";
          statusElement.classList.remove("text-danger");
          statusElement.classList.add("text-success");
          accountNumberInput.dataset.available = "true";
        } else {
          statusElement.textContent = "This account number is already in use!";
          statusElement.classList.remove("text-success");
          statusElement.classList.add("text-danger");
          accountNumberInput.dataset.available = "false";
        }

        statusElement.classList.remove("text-muted");
        statusElement.classList.remove("d-none");
      } else {
        console.error("Error checking account number: " + xhr.status);
      }
    }
  };

  // Send the AJAX request
  xhr.send();
});

function getNextAccountNum() {
  // Create an AJAX request
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_next_acc_num.php", true);

  // Define the callback function to handle the response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Parse the response from the server (assuming it's a JSON object)
        var response = JSON.parse(xhr.responseText);

        // Update the input field with the obtained account number
        accountNumberInput.value = response.nextAccountNumber;
        accountNumberInput.dataset.available = "true";
        statusElement.classList.add("d-none");
      } else {
        console.error("Error fetching account number: " + xhr.status);
      }
    }
  };

  // Send the AJAX request
  xhr.send();
}
