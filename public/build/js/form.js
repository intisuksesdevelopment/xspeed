function submitForm(formId, submitButtonId, statusCheckboxId = null,redirect = null) {
    document.getElementById(formId).addEventListener('submit', function(event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let submitButton = document.getElementById(submitButtonId);
        submitButton.disabled = true;

        if (statusCheckboxId) {
            const checkbox = document.getElementById(statusCheckboxId);
            checkbox.value = checkbox.checked ? 0 : 1;
            checkbox.addEventListener('change', function() { checkbox.value = this.checked ? 0 : 1; });
        }

        Swal.fire({
            title: "Processing...",
            text: "Please wait.",
            icon: "info",
            showConfirmButton: false,
            allowOutsideClick: false
        });

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            submitButton.disabled = false;
    
            const modalId = data.success ? 'success-alert-modal' : 'danger-alert-modal';
            const messageId = data.success ? 'success-message' : 'danger-message';
            let modalMessage = data.success ? data.message : 'Submission failed';
    
            // Handle nested error messages
            if (!data.success && data.message) {
                if (typeof data.message === 'object') {
                    modalMessage = Object.values(data.message).flat().join(', ');
                } else {
                    modalMessage = data.message;
                }
            }
    
            document.getElementById(messageId).textContent = modalMessage;
            new bootstrap.Modal(document.getElementById(modalId)).show();
    
            console.error(modalMessage, data.error);
    
            document.getElementsByName('cancel-button').forEach(button => button.click());
    
            if (data.success) {
                setTimeout(() => {
                    if (redirect) {
                        window.location.href = redirect;
                    } else {
                        window.location.reload();
                    }
                }, 2000);
            }
        })
        .catch(error => {
            Swal.close();
            submitButton.disabled = false;
            document.getElementById('error-message').textContent = error.message || 'An error occurred';
            new bootstrap.Modal(document.getElementById('danger-alert-modal')).show();
            console.error('Submission failed:', error);
        });
    });
}
function deleteData(routeName, id, csrfToken) {
    let url;
    
    if (routeName.includes(':id')) {
        url = routeName.replace(':id', id);
    } else if (routeName.includes(':uuid')) {
        url = routeName.replace(':uuid', id);
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, remove!",
        cancelButtonText: "Cancel",
        confirmButtonClass: "btn btn-primary",
        cancelButtonClass: "btn btn-danger ml-1",
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Processing...",
                text: "Please wait.",
                icon: "info",
                showConfirmButton: false,
                allowOutsideClick: false
            });
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Removed!",
                        text: "Data has been removed.",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false,
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed!",
                        text: data.message,
                        confirmButtonClass: "btn btn-danger",
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: "error",
                    title: "Failed!",
                    text: "An error occurred while deleting the data.",
                    confirmButtonClass: "btn btn-danger",
                });
            });
        }
    });
  
}
function formatRupiah(number) {
    // Ensure the number has two decimal places
    let formattedNumber = number.toFixed(2);

    // Replace the decimal point with a comma
    formattedNumber = formattedNumber.replace('.', ',');

    // Add thousands separators
    formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    return formattedNumber;
}
function clearDecimal(number) {
    // Convert the number to a string if it isn't already
    let numStr = number.toString();

    // Remove the decimal part, if any
    numStr = numStr.split('.')[0];

    // Add thousands separators
    let formattedNumber = numStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    return formattedNumber;
}
function showSuccess(message) {
    // Set default message if message is null or empty
    const successMessage = message || "Successfully.";

    Swal.fire({
        icon: "success",
        title: "Success",
        text: successMessage,
        confirmButtonClass: "btn btn-success",
    });
}
function showWarning(message) {
    const warningMessage = message || "Please check the input data and try again."
    Swal.fire({
        icon: "warning",
        title: "Warning",
        text: warningMessage,
        confirmButtonClass: "btn btn-warning",
    });
}
function showError(message) {
    // Set default message if message is null or empty
    const errorMessage = message || "An unexpected error occurred. Please try again.";

    Swal.fire({
        icon: "error",
        title: "Error",
        text: errorMessage,
        confirmButtonClass: "btn btn-danger",
    });
}