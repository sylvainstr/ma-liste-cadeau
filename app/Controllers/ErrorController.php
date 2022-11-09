<?php

namespace App\Controllers;

class ErrorController extends CoreController
{
    public function notFound()
    {
        http_response_code(404);
        $this->renderError('404');
    }
}