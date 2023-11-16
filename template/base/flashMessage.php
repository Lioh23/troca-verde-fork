<?php if(isset($_SESSION['flashMessage'])): ?> 
    <div class="row justify-content-center">           
        <div class="col-7">
            <div class="alert alert-<?= $_SESSION['flashMessage']['color'] ?> text-center" role="alert">
                <?= $_SESSION['flashMessage']['text'] ?>
            </div>
        </div>
    </div>
<?php endif ?>