<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
<?php if(isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="container">
    <form onsubmit="return valid()" action="<?= $link->url("login") ?>" method="post">
        <div class="mb-3">
            <label for="username" class="input-title">Používateľské meno</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Zadajte používateľské meno">
            <div id="usernameEr" class="text-danger" style="display: none;">Meno nebolo vyplnene .</div>
        </div>
        <div class="mb-3">
            <label for="password" class="input-title">Heslo</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Zadajte heslo">
            <div id="passwordError" class="text-danger" style="display: none;">Heslo nebolo vyplnene.</div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Prihlásiť sa</button>
    </form>
</div>


<script>
    function valid() {
        let userName = document.getElementById("username").value.trim();
        let password = document.getElementById("password").value.trim();
        if (userName.trim() === "") {
            document.getElementById('username').style.borderColor = 'red';
            document.getElementById('usernameEr').style.display = 'block';
            return false;
        }
        if (password.trim() === "") {
            document.getElementById('password').style.borderColor = 'red';
            document.getElementById('passwordError').style.display = 'block';
            return false;
        }
        return true;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let alertBox = document.querySelector(".alert-danger");
        if (alertBox) {
            setTimeout(function () {
                alertBox.style.transition = "opacity 0.5s ease-out";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }
    });
</script>