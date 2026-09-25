$(document).ready(function() {
            var table = $('#userApplicationsTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search accounts..."
                },
            });

        });