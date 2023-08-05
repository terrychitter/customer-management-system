// Remove status and status_details from the URL query parameters
function removeStatusParameters() {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("status")) {
    urlParams.delete("status");
  }

  if (urlParams.has("status_details")) {
    urlParams.delete("status_details");
  }

  // Replace the current URL without status and status_details parameters
  const newUrl = window.location.pathname + "?" + urlParams.toString();
  window.history.replaceState({}, document.title, newUrl);
}

// Call the function when the page is loaded
window.addEventListener("load", removeStatusParameters);
