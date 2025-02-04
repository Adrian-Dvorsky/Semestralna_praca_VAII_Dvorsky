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
        return $this->html();
    }

    public function add(): Response
    {
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
                if (empty($title) || empty($content)) {
                    $_SESSION['error_message'] = 'Polia nadpís a obsah musia byť vyplnené';
                }
                if ($image != "") {
                    $imageFile = $_FILES['image'];
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    if (!in_array($imageFile['type'], $allowedTypes)) {
                        $_SESSION['error_message'] = 'Obrázok nie je spravnom formate';
                    }
                }
                if (!empty($errors)) {
                    return $this->html(['errors' => $errors]);
                }
                if ($image !="") {
                    $image = FileStorage::saveFile($this->request()->getFiles()['image']);
                }
                $article->setTitle($title);
                $article->setContent($content);
                $article->setAuthor($author);
                $article->setImage($image);
                $article->setLink($link);
                $article->save();
                $tags = $_POST['tags'];
                for ($i = 0; $i < count($tags); $i++) {
                    $artTag = new ArticleTag();
                    $artTag->setIdTag($tags[$i]);
                    $artTag->setIdArticle($article->getId());
                    $artTag->save();
                }
                return new RedirectResponse($this->url('home.index'));
            }
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $this->request()->getFiles()['image']['name'];
            $errors = [];
            if (empty($title) || empty($content)) {
                $errors[] = 'Polia nadpís a obsah musia byť vyplnené';
            }
            if ($image != "") {
                $imageFile = $_FILES['image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!in_array($imageFile['type'], $allowedTypes)) {
                    $errors[] = 'Obrázok nie je spravnom formate';
                }
            }
            if (!empty($errors)) {
                return $this->html(['errors' => $errors], 'error');
            }
            if ($image != "") {
                if ($oldFIlneName != "") {
                    FileStorage::deleteFile($oldFIlneName);
                }
                $image = FileStorage::saveFile($this->request()->getFiles()['image']);
                $article->setImage($image);
            }
            $article->setTitle($title);
            $article->setContent($content);
            $article->setLink($_POST['link']);
            $tags = $_POST['tags'];
            $currentTags = ArticleTag::getAll('idArticle = ?', [$article->getId()]);
            $tagsCurrentId = array_map(fn($tag) => $tag->getIdTag(), $currentTags);

            foreach ($currentTags as $currentTag) {
                if (!in_array($currentTag->getIdTag(), $tags)) {
                    $tagToDelete = $currentTag;
                    $tagToDelete->delete();
                }
            }

            foreach ($tags as $tagId) {
                if (!in_array($tagId, $tagsCurrentId)) {
                    $tagToAdd = new ArticleTag();
                    $tagToAdd->setIdArticle($article->getId());
                    $tagToAdd->setIdTag($tagId);
                    $tagToAdd->save();
                }
            }
            $article->save();
        }
        return new RedirectResponse($this->url('home.index'));
    }

    public function edit(): Response
    {
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
        $id = (int)$this->request()->getValue('id');
        $article = Article::getOne($id);

        if (is_null($article)) {
            throw new HTTPException(404);
        } else {
            if ($article->getImage() !== null || $article->getImage() !== "") {
                FileStorage::deleteFile($article->getImage());
            }
            $article->delete();
            return $this->json(['success' => true, 'message' => 'Článok bol vymazaný']);
        }
    }

}