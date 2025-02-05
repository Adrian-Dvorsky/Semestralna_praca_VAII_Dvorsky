<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Event;
use App\Models\User;

class EventController extends AControllerBase
{

    public function index(): Response
    {
        return $this->html();
    }

    public function save(): Response
    {
        if (isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $eventTitle = $_POST['eventTitle'];
                $eventDate = $_POST['eventDate'];
                $eventDescription = $_POST['eventDescription'];
                $event = new Event();
                $event->setTitle($eventTitle);
                $event->setDate($eventDate);
                $event->setContent($eventDescription);
                $user = User::getAll('userName =?', [$_SESSION['user']]);
                $event->setAuthorId($user[0]->getId());
                $event->save();
                $response = [
                    'success' => true,
                    'title' => $event->getTitle(),
                    'date' => $event->getDate(),
                    'content' => $event->getContent(),
                    'eventId' => $this->getId($event),
                     'isAdmin' => ($_SESSION['role'] === 'a')
                ];
                echo json_encode($response);
                exit;
            }
            echo json_encode(['success' => false]);
            exit;
        }
        exit;
    }

    public function delete(): Response {
        if (isset($_SESSION['user'])) {
            $id = (int)$this->request()->getValue('id');
            $event = Event::getOne($id);
            $event->delete();
            echo json_encode(['success' => true]);
            exit();
        }
        echo json_encode(['success' => false]);
        exit;
    }

    public function getId($event): int
    {
        $eventId = Event::getAll('content=?',[$event->getContent()]);
        return $eventId[0]->getId();
    }
}