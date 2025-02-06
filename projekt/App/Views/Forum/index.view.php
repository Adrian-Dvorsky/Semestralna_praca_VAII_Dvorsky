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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 left-bar">
            <?php foreach($data['articles'] as $article):?>
                <div id="article-<?= $article->getId() ?>"  class="mini-box">
                    <h1>
                        <?= $article->getTitle()?>
                    </h1>
                    <p class="mini-box-content">
                        <?= htmlspecialchars_decode($article->getContent()) ?>
                    </p>
                    <?php if (!empty($article->getImage())): ?>
                        <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . htmlspecialchars($article->getImage()) ?>" class="img-fluid article-image" alt="Article Image">
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($article->getLink()) ?>" target="_blank" rel="noopener noreferrer" style="display: block; text-align: left; margin-left: 0;">Odkaz</a>
                    <p style="text-align: left">
                        <?php
                        $tags = \App\Models\ArticleTag::getAll('idArticle = ?', [$article->getId()]);
                            if (!empty($tags)) {
                                $tagsName = [];
                                foreach ($tags as $tag) {
                                    $tagObj = \App\Models\Tag::getOne($tag->getIdTag());
                                    $name = '#' . $tagObj->getName();
                                    $tagsName[] = $name;
                                }
                                echo implode(', ', $tagsName);
                            }

                        ?>
                    </p>
                    <p class="description">
                        autor: <?= htmlspecialchars($article->getAuthor()) ?>
                    </p>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] == $article->getAuthor()): ?>
                        <div class="article-buttons">
                            <button type="button" class="btn btn-danger delete-article" data-id="<?= $article->getId() ?>">Vymaž</button>
                            <form method="post" action="<?= $link->url('article.edit') ?>" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $article->getId() ?>">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach;?>
    </div>
    <div class="main-box col-md-6">
        <?php if (isset($_SESSION['user'])): ?>
            <button class="event-button" id="showFormBtn">Pridať udalosť</button>
                <div id="eventFormContainer" style="text-align: left; display: none">
                    <form id="eventForm" class="event-form">
                        <div>
                            <label style="font-weight: bold; font-size: 20px" for="eventTitle">Názov udalosti:</label>
                            <input type="text" id="eventTitle" required name="eventTitle" style="width: 100%" placeholder="Zadajte názov udalosti">
                        </div>
                        <div>
                            <label style="font-weight: bold; font-size: 20px" for="eventDate">Dátum udalosti:</label>
                            <input type="text" id="eventDate" required name="eventDate" placeholder="Vyberte dátum udalosti">
                        </div>
                        <div>
                            <label style="font-weight: bold; font-size: 20px" for="eventDescription">Popis udalosti:</label>
                            <input id="eventDescription" required name="eventDescription" style="width: 100%" placeholder="Napíšte popis udalosti">
                        </div>
                        <button class="event-button" type="submit">Pridať udalosť</button>
                    </form>

                </div>
            <?php foreach($data['events'] as $event): ?>
                <div class="event-card" id="event-<?= $event['id'] ?>">
                    <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
                    <p class="event-date">Dátum konania <?= htmlspecialchars($event['date']) ?></p>
                    <p class="event-content"><?= htmlspecialchars($event['content']) ?></p>
                    <button class="delete-event-btn" data-event-id="<?= $event['id'] ?>">Vymazať</button>
                </div>
            <?php endforeach; ?>
        <div class="events-container">

        </div>
        <?php endif; ?>
    </div>
</div>
</div>

<script>
    document.querySelectorAll('.delete-article').forEach(button => {
        button.addEventListener('click', function () {
            let articleId = this.getAttribute('data-id');
            fetch('http://localhost/?c=article&a=delete&id=' + articleId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + articleId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let articleElement = document.getElementById('article-' + articleId);
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

<script>
    $(document).ready(function () {
        $("#eventDate").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        let eventForm = document.getElementById("eventForm");

        if (eventForm) {
            eventForm.addEventListener("submit", function (event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('http://localhost/?c=event&a=save', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            eventForm.reset();
                            document.getElementById("eventFormContainer").style.display = "none";

                            let eventCard = document.createElement("div");
                            eventCard.classList.add("event-card");
                            eventCard.setAttribute("id", "event-" + data.id);

                            eventCard.innerHTML = `
                            <h3 class="event-title">${data.title}</h3>
                            <p class="event-date">Dátum konania: ${data.date}</p>
                            <p class="event-content">${data.content}</p>
                            <button class="delete-event-btn" data-event-id="${data.id}">Vymazať</button>
                        `;
                            document.querySelector(".events-container").appendChild(eventCard);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Chyba:', error);
                        alert("Chyba pri odosielaní požiadavky.");
                    });
            });
        }
    });

</script>

<script>
    document.querySelectorAll('.delete-event-btn').forEach(button => {
        button.addEventListener('click', function () {
            let eventId = this.getAttribute('data-event-id');
            fetch('http://localhost/?c=event&a=delete&id=' + eventId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + eventId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let eventElement = document.getElementById('event-' + eventId);
                        if (eventElement) {
                            eventElement.remove();
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Chyba:', error));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let showFormBtn = document.getElementById("showFormBtn");
        if (showFormBtn) {
            showFormBtn.addEventListener("click", function () {
                let formContainer = document.getElementById("eventFormContainer");
                if (formContainer) {
                    formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
                }
            });
        }
    });
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