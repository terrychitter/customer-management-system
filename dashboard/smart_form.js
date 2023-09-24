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

window.smartFormHandlers = {};

window.smartFormHandlers["customer-details-form"] = {
  saveHandler: function (form) {
    // Validate the form fields
    const nameInput = form.querySelector('input[name="name"]');
    const surnameInput = form.querySelector('input[name="surname"]');
    const addressInput = form.querySelector('input[name="address"]');
    const suburbInput = form.querySelector('input[name="suburb"]');
    const emailInput = form.querySelector('input[name="email"]');
    const originInput = form.querySelector('input[name="origin"]');

    const validName = validateField(nameInput, 255, "Name");
    const validSurname = validateField(surnameInput, 255, "Surname");
    const validAddress = validateField(addressInput, 255, "Address");
    const validSuburb = validateField(suburbInput, 255, "Suburb");
    const validEmail = validateEmail(emailInput);
    const validOrigin = validateField(originInput, 255, "Origin");

    if (
      !validName ||
      !validSurname ||
      !validAddress ||
      !validSuburb ||
      !validEmail ||
      !validOrigin
    ) {
      let status = 2;
      let statusDetails = "";
      if (!validName) statusDetails += "name,";
      if (!validSurname) statusDetails += "surname,";
      if (!validAddress) statusDetails += "address,";
      if (!validSuburb) statusDetails += "suburb,";
      if (!validOrigin) statusDetails += "origin,";

      if (validEmail) {
        window.location.href =
          window.location.href +
          "&status=" +
          status +
          "&status_details=" +
          statusDetails;
      } else {
        window.location.href = window.location.href + "&status=3";
      }
      return;
    }

    // If all fields are valid, submit the form
    form.submit();
  },
};

function validateField(input, maxLength, fieldName) {
  const value = input.value.trim();
  if (value.length > maxLength) {
    return false;
  }
  return true;
}

function validateEmail(input) {
  const value = input.value.trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(value);
}

window.smartFormHandlers["sanitizing-details-form"] = {
  saveHandler: function (form) {
    // Validate the form fields
    const frequencyInput = form.querySelector('input[type="number"]');
    const monthlyFeeInput = form.querySelector(
      'input[type="number"][step="10"]'
    );

    const validFrequency = validateField(frequencyInput, 1, 4, 4);
    const validMonthlyFee = validateField(monthlyFeeInput, 1, null, 5);

    if (!validFrequency || !validMonthlyFee) {
      let status = "";
      if (!validFrequency) {
        status = "4";
      } else if (!validMonthlyFee) {
        status = "5";
      }
      window.location.href = window.location.href + "?status=" + status;
      return;
    }

    // If all fields are valid, submit the form
    form.submit();
  },
};

function validateField(input, minValue, maxValue, status) {
  const value = input.value.trim();
  const numValue = parseFloat(value);

  if (
    isNaN(numValue) ||
    numValue < minValue ||
    (maxValue !== null && numValue > maxValue)
  ) {
    return false;
  }
  return true;
}

window.smartFormHandlers["banking-details-form"] = {
  saveHandler: function(form) {
    // Validate the select
    const accountNumber = form.querySelector("input");
    const bankingDetailsSelectValue = form.querySelector("#banking-details-select").value
    ;
    form.submit();
  }
}