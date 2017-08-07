<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends BaseController
{
    protected $CRUDmodelName = '';
    protected $CRUDsingularEntityName = '';


    public function home(){
        return $this->lastarView('admin.dashboard');
    }
}
