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
      <form onsubmit="return valid()" method="post" action="<?= $link->url("reg") ?>">
        <div class="mb-3">
          <label for="username" class="input-title">Používateľské meno</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Zadajte používateľské meno" value="<?= isset($data['username']) ? htmlspecialchars($data['username']) : '' ?>">
            <div id="usernameEr" class="text-danger" style="display: none;">Meno nebolo vyplnene .</div>
        </div>
        <div class="mb-3">
          <label for="password" class="input-title">Heslo</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Zadajte heslo" value="<?= isset($data['password']) ? htmlspecialchars($data['password']) : '' ?>">
            <div id="passwordEr" class="text-danger" style="display: none;">Heslo nebolo vyplnene .</div>
        </div>
        <div class="mb-3">
          <label for="passwordConfirm" class="input-title">Potvrď heslo</label>
          <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Zadajte heslo" value="<?= isset($data['password']) ? htmlspecialchars($data['password']) : '' ?>">
            <div id="passwordErConfirm" class="text-danger" style="display: none;">Hesla sa nezhoduju .</div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Registrovať sa</button>
      </form>
    </div>


    <script>
        function valid() {
            let userName = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();
            let passwordConfirm = document.getElementById("passwordConfirm").value.trim();
            if (userName.trim() === "") {
                document.getElementById('username').style.borderColor = 'red';
                document.getElementById('usernameEr').style.display = 'block';
                return false;
            }
            if (password.trim() === "") {
                document.getElementById('password').style.borderColor = 'red';
                document.getElementById('passwordEr').style.display = 'block';
                return false;
            }
            if (password !== passwordConfirm) {
                document.getElementById('passwordConfirm').style.borderColor = 'red';
                document.getElementById('passwordErConfirm').style.display = 'block';
                return false;
            }
            return true;
    </script>
