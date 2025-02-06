<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <link type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css?v=<?= time() ?>">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

</head>
<body class="main-body">
<header class="bg-dark text-white text-center py-5 custom-header">
    <h1>Vesmirne fórum</h1>
    <p>Objavte zázraky vesmíru</p>
</header>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $link->url("home.index") ?>">
            <img src="public/images/rocket.png" alt="Icon" style="height: 40px;" id="fly">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $link->url("forum.index") ?>">Príspevky</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $link->url("auth.login") ?>"">Príhlasiť sa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $link->url("registration.reg") ?>">Registrovať sa</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $link->url("article.add") ?>">Vytvor príspevok</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $link->url("auth.logout") ?>">Odhlásiť sa</a>
                </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['role'] === 'a') : ?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $link->url("admin.index") ?>">Spravuj užívateľov</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <?php if (isset($_SESSION['user'])): ?>
                <ul class="navbar-nav ms-3 mb-2 mb-lg-0">
                    <li class="nav-item">
                    <span class="navbar-text text-light" style="font-size: 18px; margin-right: 30px">
                        Prihlásený používateľ : <?= $_SESSION['user']; ?>
                    </span>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
<script src="public/js/script.js"></script>
</body>
</html>
