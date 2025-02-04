<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

use App\Models\Article;

?>

<div class="container">
    <?php foreach($data['users'] as $users):?>
        <div class="user-box">
            <?php
                $article = Article::getAll('author = ?', [$users->getUsername()]);
                $count = count($article);
            ?>
            <div class="user-icon">
                <img src="public/images/user.png" alt="Icon">
            </div>
            <div>
                <p class="user-name">
                    <?= $users->getUserName()?>
                </p>
                <p>
                    Počet článkov: <?= $count ?>
                </p>
            </div>
                <div style="margin-left: auto">
                    <form method="post" action="<?= $link->url('admin.destroyUser') ?>" style="display: inline;">
                        <input type="hidden" name="userName" value="<?= $users->getUserName() ?>">
                        <button class="user-delete-button" type="submit"> Delete</button>
                    </form>
                </div>
        </div>
    <?php endforeach;?>
</div>