<?php
if (isset($_SESSION['alert'])) {
    ?>
    <style>
        .title-toast {
            margin-top: 9px !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.15/bootstrap-4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script>
        Swal.fire({
            text: '<?= $_SESSION['alert']['message'] ?>',
            icon: '<?= $_SESSION['alert']['type'] ?>',
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary",
            },
        });
    </script>
    <?php
    unset($_SESSION['alert']);
}
?>