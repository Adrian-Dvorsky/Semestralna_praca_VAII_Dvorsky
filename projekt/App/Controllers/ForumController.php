<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Article;
use App\Models\Event;
use PDO;

class ForumController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $con = Connection::connect();
        $stmt = $con->prepare("SELECT * FROM events WHERE date > CURDATE();");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->html(
            [
                'articles' =>Article::getAll(),
                'user' => isset($_SESSION['user']),
                'role' => isset($_SESSION['role']),
                'events' => $result
            ]
        );
    }
}