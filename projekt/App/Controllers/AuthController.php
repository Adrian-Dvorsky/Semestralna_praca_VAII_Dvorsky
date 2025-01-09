<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Config\Configuration;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
class AuthController extends AControllerBase
{
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    public function login(): Response
    {
        if (isset($_SESSION['user'])) {
            //$this->app->getAuth()->logout();
            return $this->redirect($this->url("home.index"));
        }
        $data = $this->app->getRequest()->getPost();
        if (isset($data['submit'])) {
            if ($this->app->getAuth()->login($data['username'], $data['password'])) {
                return $this->redirect($this->url("home.index"));
            };
        }
        return $this->html();
    }

    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return new RedirectResponse($this->url("home.index"));
    }
}