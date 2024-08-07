import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    const addressInput = document.getElementById("address");
    const suggestionsContainer = document.getElementById("suggestions");
    let timeout;
    let submitButton = document.getElementById("submit");

    if (submitButton) {
        addressInput.addEventListener("input", function () {
            let query = this.value;

            if (query.length === 0) {
                // Disable submit button if address input is empty
                submitButton.disabled = true;
            }

            if (timeout) clearTimeout(timeout);

            if (query.length >= 4) {
                timeout = setTimeout(function () {
                    axios
                        .get("/api/autocomplete", {
                            params: {
                                query: query,
                            },
                        })
                        .then(function (response) {
                            suggestionsContainer.innerHTML = "";
                            response.data.forEach(function (item) {
                                let suggestion = document.createElement("a");
                                suggestion.href = "#";
                                suggestion.classList.add(
                                    "list-group-item",
                                    "list-group-item-action",
                                    "suggestion-item"
                                );
                                suggestion.textContent = item.address;
                                suggestionsContainer.appendChild(suggestion);

                                suggestion.addEventListener(
                                    "click",
                                    function (event) {
                                        event.preventDefault();
                                        addressInput.value = item.address;
                                        suggestionsContainer.innerHTML = "";
                                        submitButton.disabled = false;
                                    }
                                );

                                // Disable submit button if the query is not in suggestions
                                if (!response.data.some(data => data.address === query)) {
                                    console.log("error");
                                    submitButton.disabled = true;
                                }
                            });
                        })
                        .catch(function (error) {
                            console.error("Error during search:", error);
                        });
                }, 500);
            } else {
                suggestionsContainer.innerHTML = "";
            }
        });
    }

    // Show modal and set the action to be deleted
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        const form = document.getElementById('deleteForm');
        form.setAttribute('action', action);
    });

    // Handle deletion
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('deleteForm');
        form.submit();
    });

    if (dropdown) {
        dropdown.addEventListener('mouseenter', function () {
            dropdownMenu.classList.add('show');
            dropdownToggle.setAttribute('aria-expanded', 'true');
        });

        dropdown.addEventListener('mouseleave', function () {
            dropdownMenu.classList.remove('show');
            dropdownToggle.setAttribute('aria-expanded', 'false');
        });
    }

});
