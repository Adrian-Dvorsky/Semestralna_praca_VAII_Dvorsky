<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\Article;
use App\Models\User;

class AdminController extends AControllerBase
{

    public function index(): Response
    {
        if ($this->app->getAuth()->isAdmin()) {
            return $this->html(
                [
                    'users' => User::getAll('role = ?', ["n"])
                ]
            );
        }
        return $this->redirect($this->url("home.index"));
    }

    public function destroyUser(): Response
    {
        if ($this->app->getAuth()->isAdmin()) {
            $id = (int)$this->request()->getValue('id');
            if ($id > 0) {
                $user = User::getOne($id);
                $user->delete();
                $userName = $user->getUserName();
                $articles = Article::getAll('author = ?', [$userName]);
                for ($i = 0; $i < count($articles); $i++) {
                    if ($articles[$i]->getImage() !== "") {
                        FileStorage::deleteFile($articles[$i]->getImage());
                    }
                    $articles[$i]->delete();
                }
            }
            return $this->json(['success' => true]);
        }
        return $this->redirect($this->url("home.index"));
    }
}