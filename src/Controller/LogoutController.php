<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Override;

class LogoutController implements Controller
{
    #[Override]
    public function processaRequisicao(): void
    {
        session_destroy();
        header('Location: /login');
    }
}
