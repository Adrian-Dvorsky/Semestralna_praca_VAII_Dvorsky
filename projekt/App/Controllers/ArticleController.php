<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\Article;
use App\Models\Tag;
use App\Models\ArticleTag;
class ArticleController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        if (!isset($_SESSION['user'])) {
            return $this->redirect($this->url("home.index"));
        }
        return $this->html();
    }

    public function add(): Response
    {
        if (!$this->app->getAuth()->isLogged()) {
            $_SESSION['error_message'] = "Musíš byť najskôr prihláseny";
            return new RedirectResponse($this->url('home.index.'));
        }
        return $this->html(
            [
                'tags' =>  Tag::getAll()
            ],
        );
    }

    public function save() : Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$this->request()->getValue('id');
            $oldFIlneName = "";

            if ($id > 0) {
                $article = Article::getOne($id);
                if ($article->getImage() !== null || $article->getImage() !== "") {
                    $oldFIlneName = $article->getImage();
                }
            } else {
                $article = new Article();
                $title = $_POST['title'];
                $content = $_POST['content'];
                $author = $this->app->getAuth()->getLoggedUserName();
                $link = $_POST['link'];
                $image = $this->request()->getFiles()['image']['name'];
                $article->setTitle($title);
                $article->setContent($content);
                if (isset($_POST['tags'])) {
                    $tags= $_POST['tags'];
                } else {
                    $tags = [];
                }
                if ($image != "") {
                    $imageFile = $_FILES['image'];
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    if (!in_array($imageFile['type'], $allowedTypes)) {
                        $_SESSION['error_message'] = 'Obrázok nie je spravnom formate';
                        return $this->html(
                            [
                                'tagsName' => $tags,
                                'article' => $article,
                                'tags' => Tag::getAll(),
                            ],'edit'
                        );
                    }
                }
                if ($link !== "" && !filter_var($link, FILTER_VALIDATE_URL)) {
                    $_SESSION['error_message'] = 'Neplatný link';
                } else {
                    $article->setLink($link);
                }
                if (isset($_SESSION['error_message'])) {
                    return $this->html(
                        [
                            'tagsName' => $tags,
                            'article' => $article,
                            'tags' => Tag::getAll(),
                        ],'edit'
                    );
                }
                if ($image != "") {
                    $image = FileStorage::saveFile($this->request()->getFiles()['image']);
                }
                $article->setTitle($title);
                $article->setContent($content);
                $article->setAuthor($author);
                $article->setImage($image);
                $article->setLink($link);
                $article->save();
                if ($tags != null) {
                    for ($i = 0; $i < count($tags); $i++) {
                        $artTag = new ArticleTag();
                        $artTag->setIdTag($tags[$i]);
                        $artTag->setIdArticle($article->getId());
                        $artTag->save();
                    }
                }
            }
        }
        return new RedirectResponse($this->url('forum.index'));
    }

    public function edit(): Response
    {
        if (!$this->app->getAuth()->isLogged()) {
            $_SESSION['error_message'] = "Musíš byť najskôr prihláseny";
            return $this->redirect($this->url("home.index"));
        }
        $id = (int)$this->request()->getValue('id');
        $article = Article::getOne($id);
        return $this->html(
            [
                'article' => $article,
                'tags' => Tag::getAll(),
            ],'edit'
        );
    }
    public function delete(): Response
    {
        if (!$this->app->getAuth()->isLogged()) {
            $_SESSION['error_message'] = "Musíš byť najskôr prihláseny";
            return new RedirectResponse($this->url('home.index.'));
        }
        $id = (int)$this->request()->getValue('id');
        $article = Article::getOne($id);
        if ($this->app->getAuth()->getLoggedUserName() !== $article->getAuthor()) {
            $_SESSION['error_message'] = "Nemáš právo mazať";
            return $this->redirect($this->url("home.index"));
        }
        if (is_null($article)) {
            throw new HTTPException(404);
        } else {
            if ($article->getImage() !== "") {
                FileStorage::deleteFile($article->getImage());
            }
            $article->delete();
            return $this->json(['success' => true, 'message' => 'Článok bol vymazaný']);
        }
    }

    public function saveEdit() : Response
    {
        if (!$this->app->getAuth()->isLogged()) {
            $_SESSION['error_message'] = "Musíš byť najskôr prihláseny";
            return new RedirectResponse($this->url('home.index.'));
        }
        $id = (int)$this->request()->getValue('id');
        $oldFIlneName = "";
        if ($id > 0) {
            $article = Article::getOne($id);
            if ($article->getImage() !== null || $article->getImage() !== "") {
                $oldFIlneName = $article->getImage();
            }
        } else {
            $article = new Article();
            $author = $this->app->getAuth()->getLoggedUserName();
            $article->setAuthor($author);
        }
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $image = $this->request()->getFiles()['image']['name'];
        $link = trim($_POST['link']);
        if ($title === "" || $content === "" ) {
            $_SESSION['error_message'] = "Názov a obsah sú povinne";
            return $this->html(
                [
                    'article' => $article,
                    'tags' => Tag::getAll(),
                ],'edit'
            );
        }
        if ($image !== "") {
            $imageFile = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!in_array($imageFile['type'], $allowedTypes)) {
                $_SESSION['error_message'] = 'Obrázok nie je spravnom formate';
                return $this->html(
                    [
                        'article' => $article,
                        'tags' => Tag::getAll(),
                    ],'edit'
                );
            }
        }
        if ($link !== "" && !filter_var($link, FILTER_VALIDATE_URL)) {
            $_SESSION['error_message'] = 'Neplatný link';
        } else {
            $article->setLink($link);
        }
        if (isset($_SESSION['error_message'])) {
            return $this->html(
                [
                    'article' => $article,
                    'tags' => Tag::getAll(),
                ],'edit'
            );
        }
        if ($image != "") {
            if ($oldFIlneName != "") {
                FileStorage::deleteFile($oldFIlneName);
            }
            $image = FileStorage::saveFile($this->request()->getFiles()['image']);
            $article->setImage($image);
        }
        $article->setTitle(htmlspecialchars($title, ENT_QUOTES, 'UTF-8'));
        $article->setContent(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));
        $article->setLink(htmlspecialchars($_POST['link'], ENT_QUOTES, 'UTF-8'));
        if (isset($_POST['tags'])) {
            $tags= $_POST['tags'];
        } else {
            $tags = [];
        }
        $currentTags = ArticleTag::getAll('idArticle = ?', [$article->getId()]);
        $tagsCurrentId = array_map(fn($tag) => $tag->getIdTag(), $currentTags);
        $article->save();
        foreach ($currentTags as $currentTag) {
            if (!in_array($currentTag->getIdTag(), $tags)) {
                $tagToDelete = $currentTag;
                $tagToDelete->delete();
            }
        }

        foreach ($tags as $tagId) {
            if (!in_array($tagId, $tagsCurrentId)) {
                $tagToAdd = new ArticleTag();
                if ($article->getId() === null) {
                    $tagToAdd->setIdArticle($_SESSION['userId']);
                } else {
                    $tagToAdd->setIdArticle($article->getId());
                }
                    $tagToAdd->setIdTag($tagId);
                $tagToAdd->save();
            }
        }
        return $this->redirect($this->url('forum.index'));
    }

}