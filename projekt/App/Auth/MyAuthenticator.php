<?php

namespace App\Auth;

use App\Core\AControllerBase;
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
                $_SESSION["userId"] = $user->getId();
                return true;
            }
            $_SESSION["error_message"] = "Meno alebo heslo nie je spravne";
            return false;
        }
        $_SESSION["error_message"] = "Používateľ sa nenšiel";
        return false;
    }

    public function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            unset($_SESSION["role"]);
            unset($_SESSION["userId"]);
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

    public function getUserId(): int
    {
        return $_SESSION["userId"];
    }

    public function getLoggedUserContext(): mixed
    {
        return $_SESSION["user"];
    }

    public function isLogged(): bool
    {
        return isset($_SESSION["user"]) && $_SESSION["user"] !== "";
    }

    public function isAdmin(): bool
    {
        return isset($_SESSION["role"]) && $_SESSION["role"] == "a";
    }

}