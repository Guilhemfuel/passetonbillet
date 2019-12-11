<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Resources\Admin\TicketTableResource;
use App\Http\Resources\UserRessource;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class UserController extends TableCrudController
{
    public $class = User::class;
    public $classResource = UserRessource::class;
}
