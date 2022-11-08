<?php

namespace App\Controllers;

class ListController extends CoreController
{
    public function list()
    {
      $this->renderList('list');
    }

    public function add()
    {
        $this->renderList('add');
    }

    public function edit()
    {
        $this->renderList('edit');
    }

    public function delete()
    {
    }
}