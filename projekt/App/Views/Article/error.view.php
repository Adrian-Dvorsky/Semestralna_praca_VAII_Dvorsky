<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
    <?php foreach ($data['errors'] as $error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?><p>
    <?php endforeach; ?>