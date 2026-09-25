$(document).ready(function() {
            var table = $('#usersTable').DataTable({
                "pageLength": 10,
                "autoWidth": false,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search accounts...",
                    "width": "50%"
                },
                "columnDefs": [
                    { "width": "15%", "targets": 0 }, // Name
                    { "width": "20%", "targets": 1 }, // Email Address
                    { "width": "5%", "targets": 2 }, // Role
                    { "width": "28%", "targets": 3 }, // Address
                    { "width": "10%", "targets": 4 }, // Assignment
                    { "width": "12%", "targets": 5, "className": "text-center", "orderable": false} // Actions
                ]
            });

        });

$(document).ready(function() {
    // Handle Show/Hide toggle inside View Modal
    $(document).on('click', '.toggle-modal-password', function() {
        var input = $(this).siblings('.modal-password-field');
        var icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    $(document).on('click', '.toggle-update-modal-password', function() {
        var input = $(this).siblings('.update-modal-password');
        var icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
});