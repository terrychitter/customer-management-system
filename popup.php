<?php
if (empty(session_id()) && !headers_sent()) {
  session_start();
}

if (isset($_GET['status'])) {
  // Get the status
  $status = $_GET['status'];

  // Popup variables
  $popupText = '';
  $popupColour = '';

  // Customer not found
  switch ($status) {
    case '1':
      $popupText = "Customer could not be found. Please try again!";
      $popupColour = "danger";
      break;
    case '2':
      // Get the field name
      if (isset($_GET['status_details'])) {
        $fieldTooLongName = $_GET['status_details'];
        $popupText = "$fieldTooLongName field is too long (max 255 characters). Please try again!";
      } else {
        $popupText = "An unexpected error occured and one of your fields were too long. Please try again!";
      }
      $popupColour = "danger";
      break;
    case '3':
      $popupText = "Invalid Email for customer. Please try again!";
      $popupColour = "danger";
      break;
    case '4':
      $popupText = "Frequency cannot be higher than 4. Please try again!";
      $popupColour = "danger";
      break;
    case '5':
      $popupText = "Monthly fee cannot be zero or less. Please try again!";
      $popupColour = "danger";
      break;
    case '6':
      $popupText = "There was an error while updating the customer's details. Please try again! (6)";
      $popupColour = "danger";
      break;
    case '7':
      $popupText = "Successfully updated customer details!";
      $popupColour = "success";
      break;
    case '8':
      $popupText = "There was an error while updating the customer's details. Please try again! (8)";
      $popupColour = "danger";
      break;
    case '9':
      $popupText = "There was an error while updating the customer's sanitizing details. Please try again! (9)";
      $popupColour = "danger";
      break;
    case '10':
      $popupText = "Successfully updated customer sanitizing details!";
      $popupColour = "success";
      break;
    case '11':
      $popupText = "There was an error while updating the customer's sanitizing details. Please try again! (11)";
      $popupColour = "danger";
      break;
    case '12':
      $popupText = "There was an error while adding the customer's contact. Please try again! (12)";
      $popupColour = "danger";
      break;
    case '13':
      $popupText = "Successfully added customer contact!";
      $popupColour = "success";
      break;
    case '14':
      $popupText = "There was an error while updating the customer's contact. Please try again! (14)";
      $popupColour = "danger";
      break;
    case '15':
      $popupText = "Successfully updated customer contact!";
      $popupColour = "success";
      break;
    case '16':
      $popupText = "An unexpected error occured while adding/updating the customer's contact. Please try again! (16)";
      $popupColour = "danger";
      break;
    case '17':
      $popupText = "There was an error while adding the customer's comment. Please try again! (17)";
      $popupColour = "danger";
      break;
    case '18':
      $popupText = "Successfully added customer comment!";
      $popupColour = "success";
      break;
    case '19':
      $popupText = "There was an error while updating the customer's comment. Please try again! (19)";
      $popupColour = "danger";
      break;
    case '20':
      $popupText = "Successfully updated customer comment!";
      $popupColour = "success";
      break;
    case '21':
      $popupText = "An unexpected error occured while adding/updating the customer's comment. Please try again! (21)";
      $popupColour = "danger";
      break;
    case '22':
      $popupText = "There was an error while adding the customer's dustbin. Please try again! (22)";
      $popupColour = "danger";
      break;
    case '23':
      $popupText = "Successfully added customer dustbin!";
      $popupColour = "success";
      break;
    case '24':
      $popupText = "There was an error while updating the customer's bin. Please try again! (24)";
      $popupColour = "danger";
      break;
    case '25':
      $popupText = "Successfully updated customer bin!";
      $popupColour = "success";
      break;
    case '26':
      $popupText = "An unexpected error occured while adding/updating the customer's bin. Please try again! (26)";
      $popupColour = "danger";
      break;
    case '27':
      $popupText = "An unexpected error occured while removing the customer's contact. Please try again! (27)";
      $popupColour = "danger";
      break;
    case '28':
      $popupText = "Successfully removed customer contact!";
      $popupColour = "success";
      break;
    case '29':
      $popupText = "There was an error while removing the customer's contact. Please try again! (29)";
      $popupColour = "danger";
      break;
    case '30':
      $popupText = "An unexpected error occured while removing the customer's comment. Please try again! (30)";
      $popupColour = "danger";
      break;
    case '31':
      $popupText = "Successfully removed customer comment!";
      $popupColour = "success";
      break;
    case '32':
      $popupText = "There was an error while removing the customer's comment. Please try again! (32)";
      $popupColour = "danger";
      break;
    case '33':
      $popupText = "An unexpected error occured while removing the customer's bin. Please try again! (33)";
      $popupColour = "danger";
      break;
    case '34':
      $popupText = "Successfully removed customer bin!";
      $popupColour = "success";
      break;
    case '35':
      $popupText = "There was an error while removing the customer's bin. Please try again! (35)";
      $popupColour = "danger";
      break;
    case '36':
      $popupText = "Something went wrong while adding the customer. Please try again! (36)";
      $popupColour = "danger";
      break;
    case '37':
      $popupText = "Successfully added customer!";
      $popupColour = "success";
      break;
    case '38':
      $popupText = "There was an error while adding the customer. Please try again! (38)";
      $popupColour = "danger";
      break;
    case '39':
      $popupText = "Something went wrong while deactivating the customer. Please try again! (39)";
      $popupColour = "danger";
      break;
    case '40':
      $popupText = "Customer has been successfully deactivated!";
      $popupColour = "success";
      break;
    case '41':
      $popupText = "There was an error while deactivating the customer. Please try again! (41)";
      $popupColour = "danger";
      break;
    case '42':
      $popupText = "Something went wrong while reactivating the customer. Please try again! (42)";
      $popupColour = "danger";
      break;
    case '43':
      $popupText = "Customer has been successfully reactivated!";
      $popupColour = "success";
      break;
    case '44':
      $popupText = "There was an error while reactivating the customer. Please try again! (44)";
      $popupColour = "danger";
      break;
    case '45':
      $popupText = "Customer's prefered banking details have been successfully updated!";
      $popupColour = "success";
      break;
    case '46':
      $popupText = "There was an error while updating the customer's preferred banking details. Please try again (46)";
      $popupColour = "danger";
      break;
    case '47':
      $popupText = "An unexpected error occured while updating the customer's preffered banking details. Please try again! (47)";
      $popupColour = "danger";
      break;
    case '48':
      $popupText = "Successfully Added Payment!";
      $popupColour = "success";
      break;
    case '49':
      $popupText = "There was an error while updating the customer's balance. The payment has been rolled back. (49)";
      $popupColour = "danger";
      break;
    case '50':
      $popupText = "There was an error while adding the customer's payment. The payment has been rolled back. (50)";
      $popupColour = "danger";
      break;
    case '51':
      $popupText = "Please provide a payment amount";
      $popupColour = "danger";
      break;
    case '52':
      $popupText = "Successfully reversed the customer's payment!";
      $popupColour = "success";
      break;
    case '53':
      $popupText = "There was an error while trying to reverse the customer's payment. Please try again! (53)";
      $popupColour = "danger";
      break;
    case '54':
      $popupText = "There was an error while trying to reverse the customer's payment. Please try again! (54)";
      $popupColour = "danger";
      break;
  }
  ?>
  <div class="d-flex justify-content-center" style="z-index: 999;">
    <div class="toast align-items-center bg-white" role="alert" aria-live="assertive" aria-atomic="true" id="status-toast"
      style="position: fixed; top: 1rem; left: 50%; transform: translateX(-50%);">
      <div class="d-flex">
        <div class="toast-body d-flex align-items-center text-<?php echo $popupColour; ?>" style="gap: 0.7rem">
          <i class="bi bi-info-circle-fill fs-5"></i>
          <?php echo $popupText ?>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Get the toast element by ID
      const toastElement = document.getElementById("status-toast");

      // Show the toast using Bootstrap's toast() method
      const toast = new bootstrap.Toast(toastElement);
      toast.show();
    });
  </script>
<?php } ?>