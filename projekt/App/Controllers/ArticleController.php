<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Helpers\FileStorage;
use App\Models\Article;

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
        return $this->html();
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
                $tags = $_POST['tags'];
                $link = $_POST['link'];
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
                if ($image !="") {
                    $image = FileStorage::saveFile($this->request()->getFiles()['image']);
                }
                $article->setTitle($title);
                $article->setContent($content);
                $article->setImage($image);
                $article->setTags($tags);
                $article->setLink($link);
                $article->save();
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
            $article->setTags($_POST['tags']);
            $article->setLink($_POST['link']);
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
            return new RedirectResponse($this->url('home.index'));
        }
    }
}