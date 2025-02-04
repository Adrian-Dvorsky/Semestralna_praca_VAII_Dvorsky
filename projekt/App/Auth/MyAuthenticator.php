<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\User;
class MyAuthenticator implements IAuthenticator
{
    public function __construct() {
        session_start();
    }

    public function login($login, $password): bool
    {
        $user = User::getAll("userName = ?", [$login]);
        if ($user != null) {
            $user = $user[0];
            if ($login == $user->getUserName() && password_verify($password, $user->getPassword())) {
                $_SESSION["user"] = $login;
                $_SESSION["role"] = $user->getRole();
                return true;
            }
            $_SESSION["error_message"] = "Meno alebo heslo nie je spravne";
            return false;
        }
        return false;
    }

    public function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            unset($_SESSION["role"]);
            session_destroy();
        }
    }

    public function getLoggedUserName(): string
    {
        return $_SESSION["user"];
    }

    public function getLoggedUserId(): mixed
    {
        return $_SESSION["user"];
    }

    public function getLoggedUserContext(): mixed
    {
        return $_SESSION["user"];
    }

    public function isLogged(): bool
    {
        return $_SESSION["user"] != null;
    }

    public function isAdmin(): bool
    {
        return $_SESSION["role"] == "a";
    }
}