<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Article;

class ForumController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html(
            [
                'articles' =>Article::getAll(),
                'user' => isset($_SESSION['user']),
                'role' => isset($_SESSION['role'])
            ]
        );
    }
}