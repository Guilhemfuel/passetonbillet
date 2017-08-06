<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LastarException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;

abstract class BaseController extends Controller
{

    protected $CRUDmodelName;
    protected $model;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }

    protected function lastarView( $viewName, $data = []){
        if ($this->CRUDmodelName === null){
            throw new LastarException('$CRUDmodelName must not be null.');
        }
        $data['model'] = $this->CRUDmodelName;
        return view($viewName, $data);
    }

    public function index(Request $request)
    {
        if ($request->has('search')){
            $entities = $this->model::search($request->input('search'))->paginate( 30 );
            $data = [ 'entities' => $entities, 'search' => $request->input('search') ];
        } else {
            $entities = $this->model::paginate( 30 );
            $data = [ 'entities' => $entities ];
        }

        return $this->lastarView( 'admin.CRUD.'.$this->CRUDmodelName.'.index', $data );
    }

}
