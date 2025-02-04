<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Article;
use App\Models\User;

class AdminController extends AControllerBase
{

    public function index(): Response
    {
        return $this->html(
            [
                'users' => User::getAll('role = ?', ["n"])
            ]
        );
    }

    public function destroyUser(): Response
    {
        $userName = (string)$this->request()->getValue('userName');
        if ($userName != "") {
            $articles = Article::getAll('author = ?', [$userName]);
            for ($i = 0; $i < count($articles); $i++) {
                $articles[$i]->delete();
            }
            $user = User::getAll('userName = ?', [$userName]);
            $user[0]->delete();
        }
        return $this->redirect($this->url("admin.index"));
    }
}