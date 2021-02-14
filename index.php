<?php

include_once 'core/Router.php';
include_once 'repositories/UserRepository.php';
include_once 'models/User.php';

use \Models\User;
use \Core\Router;
use \Repositories\UserRepository;

$router = new Router();

$router->get('/', function () {
    echo '<a href="/user">Lista de utilizadores</a> <br><br>';
    echo '<a href="/user/1">Obter um utilizador 1</a> <br><br>';
    echo '<a href="/user/2">Obter um utilizador 2</a> <br><br>';
    echo '<a href="/user/create">Criar um utilizador</a> [name: teste3,  email: teste2@email.com, birthday: 01/02/1980, gender: f]<br><br>';
    echo '<a href="/user/delete/1">Eliminar o utilizador 1</a> <br><br>';
    echo '<a href="/user/delete/2">Eliminar o utilizador 2</a> <br><br>';
    echo '<a href="/user/update/1">Atualizar o utilizador 1</a> <br><br>';
    echo '<a href="/user/update/2">Atualizar o utilizador 2</a> <br><br>';
});

$router->get('/user', function () {
    $userRepository = new UserRepository();
    echo '<strong>Lista completa</strong> <br><br>';
    return json_encode($userRepository->list());
});

$router->get('/user/:id', function ($request) {
    $userRepository = new UserRepository();
    echo '<strong>Lista completa</strong> <br><br>';
    echo json_encode($userRepository->list()) . '<br><br>';
    echo '<strong>Utilizador escolhido index: ' . $request['id'] . ' </strong> <br><br>';
    return json_encode($userRepository->get($request['id']));
});

$router->get('/user/create', function () {
    $userRepository = new UserRepository();
    echo '<strong>Lista completa</strong> <br><br>';
    echo json_encode($userRepository->list()) . '<br><br>';
    $userRepository->create(new User('teste3', 'teste2@email.com', '01/02/1980', 'f'));
    echo '<strong>Lista com um novo utilizador</strong> <br><br>';
    return json_encode($userRepository->list());
});

$router->get('/user/delete/:id', function ($request) {
    $userRepository = new UserRepository();
    echo '<strong>Lista completa</strong> <br><br>';
    echo json_encode($userRepository->list()) . '<br><br>';
    $userRepository->delete($request['id']);
    echo '<strong>Lista sem o utilizador index: ' . $request['id'] . '</strong> <br><br>';
    return json_encode($userRepository->list());
});

$router->get('/user/update/:id', function ($request) {
    $userRepository = new UserRepository();
    echo '<strong>Lista completa</strong> <br><br>';
    echo json_encode($userRepository->list()) . '<br><br>';
    echo '<strong>Valores a serem atualizados</strong> <br><br>';
    echo json_encode(new User('teste3', 'teste3@email.com', '01/02/1980', 'f')) . '<br><br>';
    echo '<strong>Lista com um utilizador atualizado index: ' . $request['id'] . '</strong> <br><br>';
    $userRepository->update(new User('teste3', 'teste3@email.com', '01/02/1980', 'f'), $request['id']);
    return json_encode($userRepository->list());
});

$router->post('/data', function ($request) {
    return json_encode($request);
});
