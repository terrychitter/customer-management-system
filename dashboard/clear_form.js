document.addEventListener("DOMContentLoaded", function () {
  // Get all elements with the "data-clear-form" attribute
  const elementsWithClearForm = document.querySelectorAll("[data-clear-form]");

  // Function to clear the form fields inside the given modal
  function clearModalForm(modal) {
    const form = modal.closest("form");
    if (form) {
      form.reset();
    }
  }

  // Function to update the modal title based on the data value
  function updateModalTitle(modal) {
    const modalTitle = modal.querySelector(".modal-title p[data-type]");
    if (modalTitle) {
      const dataValue = modalTitle.getAttribute("data-type");
      modalTitle.textContent = "Add " + dataValue;
    }
  }

  // Add click event listener to each element with "data-clear-form" attribute
  elementsWithClearForm.forEach((element) => {
    element.addEventListener("click", function () {
      const targetModalId = this.dataset.bsTarget; // Get the target modal ID directly
      const modal = document.querySelector(targetModalId); // Find the modal using the target ID

      if (modal) {
        clearModalForm(modal);
        updateModalTitle(modal);
      }
    });
  });
});
