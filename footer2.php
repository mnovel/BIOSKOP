<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; <?= date("Y") ?> <div class="bullet"></div> GA.Tix</a>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="<?= BASE_URL ?>template/assets/modules/jquery.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/popper.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/tooltip.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/moment.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/js/stisla.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>

<!-- JS Libraies -->
<script src="<?= BASE_URL ?>template/assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/modules/prism/prism.js"></script>

<!-- Page Specific JS File -->
<script src="<?= BASE_URL ?>template/assets/js/page/bootstrap-modal.js"></script>

<!-- Template JS File -->
<script src="<?= BASE_URL ?>template/assets/js/scripts.js"></script>
<script src="<?= BASE_URL ?>template/assets/js/custom.js"></script>

<?php
if (!empty($_COOKIE['alert'])) {
    $split = explode('|', $_COOKIE['alert']);
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: '<?= $split[0] ?>',
            title: '<?= $split[1] ?>'
        })
    </script>
<?php
}
?>
</body>

</html>