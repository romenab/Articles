<?php

use Articles\Controller\ArticlesController;

return [
    ['GET', '/', [ArticlesController::class, 'index']],

    ['GET', '/create', [ArticlesController::class, 'createView']],
    ['POST', '/create', [ArticlesController::class, 'create']],

    ['GET', '/display', [ArticlesController::class, 'display']],

    ['GET', '/update', [ArticlesController::class, 'updateView']],
    ['POST', '/update', [ArticlesController::class, 'update']],

    ['POST', '/', [ArticlesController::class, 'delete']],

];