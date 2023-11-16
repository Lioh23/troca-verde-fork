        <footer class="py-3"></footer>
        
        <script src="assets/js/bootstrap5.min.js?t=<?= md5(time()) ?>"></script>
        <script src="assets/js/fontawesome.min.js?t=<?= md5(time()) ?>"></script>
    </body>
</html>

<?php 
    if(isset($_SESSION['error'])) unset($_SESSION['error']);
    if(isset($_SESSION['flashMessage'])) unset($_SESSION['flashMessage']);
?>