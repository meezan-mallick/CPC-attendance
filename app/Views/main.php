<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CPC-ORBIT' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- boostrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <head>
        <script>
            // Apply Dark Mode instantly before page load
            (function() {
                if (localStorage.getItem("darkMode") === "enabled") {
                    document.documentElement.classList.add("dark-mode");
                }
            })();
        </script>
    </head>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- <link rel="stylesheet" href="<?= base_url('assets/css/forms.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tablestyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/studentscards.css') ?>"> -->

</head>

<body>

    <!-- if Loggedin Show dashboard -->
    <?php if (session()->get('logged_in')): ?>

        <?php include 'header.php'; ?>
        <?php include 'navbar.php'; ?>
        <?= $this->renderSection('content') ?>

    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>

    <footer>
        © <?= date('Y'); ?> CPC-ORBIT Attendance System | Version 1.0.0 |
        Developed by <a href="https://github.com/meezan-mallick" target="_blank">Meezan Mallick</a>
    </footer>

</body>

</html>



<!-- Bootstrap Bundle with Popper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Custom JS -->


<script src="<?= base_url('assets/js/main.js') ?>"></script>

<!-- DATATABLE JS -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pagingType": "full_numbers", // Adds rich pagination UI
            "language": {
                "search": "_INPUT_", // Custom Search Box
                "searchPlaceholder": "🔍 Search records...",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ records"
            },
            "lengthMenu": [5, 10, 25, 50], // Custom pagination options
            "pageLength": 10, // Default number of rows
            "dom": '<"top"lf>rt<"bottom"ip><"clear">' // Positions elements
        });

        // Enhance search input field
        $(".dataTables_filter input").addClass("form-control form-control-lg ");

        // Improve pagination UI
        $(".dataTables_paginate").addClass("pagination-lg justify-content-center ");
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.documentElement; // Apply to the entire HTML document

        // Apply Dark Mode instantly if enabled
        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
            darkModeToggle.innerHTML = "☀️ Light Mode";
        }

        // Toggle Dark Mode on button click
        darkModeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");

            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("darkMode", "enabled");
                darkModeToggle.innerHTML = "☀️ Light Mode";
            } else {
                localStorage.setItem("darkMode", "disabled");
                darkModeToggle.innerHTML = "🌙 Dark Mode";
            }
        });
    });
</script>



</body>

</html>