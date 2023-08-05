document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("[data-smart-form]");
  forms.forEach(function (form) {
    const fields = form.querySelectorAll("input, select");
    fields.forEach(function (field) {
      field.setAttribute("data-original-value", field.value);
      field.addEventListener("input", handleFieldInput);
    });
  });

  document.addEventListener("click", function (event) {
    const target = event.target;

    if (target.matches(".smart-form-save-btn")) {
      // Code here handles the save button click.
      const form = target.closest("[data-smart-form]");
      const unsavedFields = form.querySelectorAll("[data-original-value]");

      unsavedFields.forEach(function (field) {
        field.value = field.getAttribute("data-original-value");
        field.removeAttribute("data-original-value");
        field.classList.remove("border-warning"); // Remove the warning border class
      });

      const btnContainer = form.querySelector(".smart-form-btn-container");
      if (btnContainer) {
        btnContainer.remove();
      }

      const formId = form.getAttribute("data-smart-form");
      if (
        formId &&
        window.smartFormHandlers &&
        window.smartFormHandlers[formId]
      ) {
        window.smartFormHandlers[formId].saveHandler(form);
      }
    }

    if (target.matches(".smart-form-cancel-btn")) {
      event.preventDefault(); // Prevent the default form submission
      const form = target.closest("[data-smart-form]");
      const btnContainer = form.querySelector(".smart-form-btn-container");
      if (btnContainer) {
        btnContainer.remove();
      }
    }
  });
});

let currentChangedField = null;

function handleFieldInput(event) {
  const field = event.target;

  const allFields = field
    .closest("[data-smart-form]")
    .querySelectorAll("input, select");
  let anyFieldChanged = false;

  allFields.forEach(function (field) {
    if (field.value !== field.getAttribute("data-original-value")) {
      anyFieldChanged = true;
      field.classList.add("border-warning"); // Add class to changed fields
      return;
    } else {
      field.classList.remove("border-warning"); // Remove class from unchanged fields
    }
  });

  if (currentChangedField !== field) {
    if (currentChangedField) {
      toggleButtonsContainer(currentChangedField, false);
    }
    currentChangedField = field;
  }

  toggleButtonsContainer(field, anyFieldChanged);
}

function toggleButtonsContainer(field, show) {
  let btnContainer = field.nextElementSibling;

  if (btnContainer) {
    btnContainer.remove();
  }

  if (show) {
    const saveBtn = document.createElement("button");
    saveBtn.className = "smart-form-save-btn";
    saveBtn.style.cursor = "pointer";
    saveBtn.innerHTML =
      '<i class="bi bi-check2 fs-1 fs-xl-2 text-success"></i>';

    const cancelBtn = document.createElement("button");
    cancelBtn.className = "smart-form-cancel-btn";
    cancelBtn.style.cursor = "pointer";
    cancelBtn.innerHTML = '<i class="bi bi-x-lg fs-3 text-danger"></i>';

    // Add event listener to the cancel button
    cancelBtn.addEventListener("click", function (event) {
      event.preventDefault(); // Prevents the default form submission
      btnContainer.remove();

      // Restore original values for all fields
      const form = field.closest("[data-smart-form]");
      const fields = form.querySelectorAll("input, select");
      fields.forEach(function (field) {
        const originalValue = field.getAttribute("data-original-value");
        field.value = originalValue;
        field.classList.remove("border-warning"); // Remove the warning border class
      });
    });

    btnContainer = document.createElement("div");
    btnContainer.className =
      "smart-form-btn-container d-flex align-items-center justify-content-end";
    btnContainer.appendChild(saveBtn);
    btnContainer.appendChild(cancelBtn);

    const fieldContainer = field.parentElement;
    fieldContainer.appendChild(btnContainer);
  }
}
