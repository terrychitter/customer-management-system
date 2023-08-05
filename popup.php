<?php 
session_start();
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
}
?>
  <div class="d-flex justify-content-center">
    <div class="toast align-items-center bg-white" role="alert" aria-live="assertive" aria-atomic="true" id="status-toast" style="position: fixed; top: 1rem; left: 50%; transform: translateX(-50%);">
      <div class="d-flex">
        <div class="toast-body d-flex align-items-center text-<?php echo $popupColour;?>" style="gap: 0.7rem">
          <i class="bi bi-info-circle-fill fs-5"></i><?php echo $popupText ?>
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
