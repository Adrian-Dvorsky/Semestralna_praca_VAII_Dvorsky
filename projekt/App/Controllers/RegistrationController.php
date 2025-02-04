<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;
class RegistrationController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html();
    }
    public function reg(): Response
    {
        unset($_SESSION['error_message']);
        $data = $this->app->getRequest()->getPost();
        if (isset($data['submit'])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $user = User::getAll('userName = ?', [$username]);

            if (count($user) == 0) {
                $user = new User();
                $user->setUsername($username);
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
                $user->setRole("n");
                $user->save();
                $this->app->getAuth()->login($username, $password);
                return $this->redirect($this->url("home.index"));
            }

            $_SESSION['error_message'] = 'Používateľské meno je už obsadené.';
            return $this->html([
                'username' => $username,
                'password' => $password,
            ]);
        }
        return $this->html();
    }
}