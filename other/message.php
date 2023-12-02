<?php
if (isset($_SESSION['alert'])) {
    ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.15/bootstrap-4.min.css" rel="stylesheet"> -->
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="assets/plugins/global/plugins.bundle.js">
</script>
<script src="assets/js/scripts.bundle.js"></script>
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