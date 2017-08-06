<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BaseController
{
    protected $CRUDmodelName = '';

    public function home(){
        return $this->lastarView('admin.dashboard');
    }
}
