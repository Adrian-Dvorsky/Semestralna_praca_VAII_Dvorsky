<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Article;
use App\Models\Event;

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
                'role' => isset($_SESSION['role']),
                'events' =>Event::getAll()
            ]
        );
    }
}