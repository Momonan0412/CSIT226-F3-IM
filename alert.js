

function showConfirmation() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    return swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "Please review your selections before proceeding:\n\n" +
            "Room Type: " + roomType + "\n" +
            "Beds: " + beds + "\n" +
            "Quality: " + quality + "\n" +
            "Capacity: " + capacity + "\n" +
            "Bathrooms: " + bathrooms + "\n" +
            "Meal Preference: " + meal + "\n" +
            "Room Size: " + roomSize + "\n" +
            "Payment Method: " + payment,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, submit it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval;
            return Swal.fire({
                title: "Request Created!",
                html: "Sending <b></b> Request.",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((innerResult) => { // Rename the inner result variable to avoid conflict
                /* Read more about handling dismissals below */
                if (innerResult.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            return swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Request not sent!",
                icon: "success"
            }).then(() => {
                return false; // Return false if the user cancels
            });
        }
    });
}
