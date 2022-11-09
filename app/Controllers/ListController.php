<?php

namespace App\Controllers;

use App\Models\Lists;

class ListController extends CoreController
{
    public function list()
    {
      $lists = new Lists();
      $lists = $lists->findAll();
      var_dump($lists);

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