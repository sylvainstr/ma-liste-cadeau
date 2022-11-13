<?php

namespace App\Controllers;

use App\Models\Lists;

class ListController extends CoreController
{
    public function list()
    {
      $lists = new Lists();
      $lists = $lists->findAll();

      $this->render('list/list', [
        'lists' => $lists
      ]);
    }

    public function add()
    {
        $this->render('add');
    }

    public function edit()
    {
        $this->render('edit');
    }

    public function delete()
    {
    }
}