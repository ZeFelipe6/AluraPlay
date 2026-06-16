<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $userData = is_string($email) ? $this->userRepository->findByEmail($email) : null;
        $correctPassword = $userData !== null
            && is_string($password)
            && password_verify($password, $userData['password']);

        if (!$correctPassword) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $this->userRepository->updatePassword((int) $userData['id'], $password);
        }

        $_SESSION['logado'] = true;
        return new Response(302, ['Location' => '/']);
    }
}
