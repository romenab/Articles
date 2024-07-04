<?php

namespace Articles\Controller;

use Articles\RedirectResponse;
use Articles\Response;
use Articles\Database\Sqlite;

class ArticlesController
{
    private Sqlite $db;

    public function __construct(Sqlite $db)
    {
        $this->db = $db;
    }

    public function index(): Response
    {
        $articles = $this->db->getArticles();
        return new Response('index', ['articles' => $articles]);
    }

    public function createView(): Response
    {
        return new Response('create');
    }

    public function create(): RedirectResponse
    {
        $this->db->createNew($_POST['headline'], $_POST['body']);
        return new RedirectResponse('/');
    }

    public function display(): Response
    {
        $article = $this->db->getByUuid($_GET['uuid']);
        return new Response('display', ['articles' => $article]);
    }

    public function updateView(): Response
    {
        $article = $this->db->getByUuid($_GET['uuid']);
        return new Response('update', ['article' => $article]);
    }

    public function update(): RedirectResponse
    {
        $this->db->update($_POST['uuid'], $_POST['headline'], $_POST['body']);
        return new RedirectResponse('/');
    }

    public function delete(): RedirectResponse
    {
        $this->db->delete($_POST['uuid']);
        return new RedirectResponse('/');
    }
}