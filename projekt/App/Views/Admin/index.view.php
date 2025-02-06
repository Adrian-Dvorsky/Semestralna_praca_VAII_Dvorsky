<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

use App\Models\Article;

?>

<div class="container">
    <?php foreach($data['users'] as $users):?>
        <div class="user-box"  id="user-<?= $users->getId()?>">
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
                        <input type="hidden" name="userName" value="<?= $users->getUserName() ?>">
                        <button class="user-delete-button" type="button" data-user-id="<?= $users->getId()?>"> Vymaz</button>
                </div>
        </div>
    <?php endforeach;?>
</div>

<script>
    document.querySelectorAll('.user-delete-button').forEach(button => {
        button.addEventListener('click', function () {
            let userId = this.getAttribute('data-user-id');
            fetch('http://localhost/?c=admin&a=destroyUser&id=' + userId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + userId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let articleElement = document.getElementById('user-' + userId);
                        if (articleElement) {
                            articleElement.remove();
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Chyba:', error));
        });
    });
</script>