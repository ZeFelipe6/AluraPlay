<?php

use Alura\Mvc\Repository\VideoRepository;

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new VideoRepository($pdo);
$repository->add(new \Alura\Mvc\Entity\Video($url, $titulo));

if ($repository->add(new \Alura\Mvc\Entity\Video($url, $titulo)) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
