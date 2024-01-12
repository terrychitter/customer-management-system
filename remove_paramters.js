// Remove status and status_details from the URL query parameters
function removeStatusParameters() {
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("status")) {
    urlParams.delete("status");
  }

  if (urlParams.has("status_details")) {
    urlParams.delete("status_details");
  }

  // Construct the new URL only if there are remaining parameters
  const queryString = urlParams.toString();
  const newUrl = queryString ? window.location.pathname + "?" + queryString : window.location.pathname;
  
  // Replace the current URL without status and status_details parameters
  window.history.replaceState({}, document.title, newUrl);
}

// Call the function when the page is loaded
window.addEventListener("load", removeStatusParameters);
