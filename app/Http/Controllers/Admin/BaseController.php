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
    protected $CRUDsingularEntityName;
    protected $model;

    public function __construct()
    {
        $this->middleware( 'auth' );
        $this->middleware( 'auth.admin' );
    }

    protected function lastarView( $viewName, $data = [] )
    {
        if ( $this->CRUDmodelName === null ) {
            throw new LastarException( '$CRUDmodelName must not be null.' );
        }
        if ( $this->CRUDsingularEntityName === null ) {
            throw new LastarException( '$CRUDsingularEntityName must not be null.' );
        }
        $data['model'] = $this->CRUDmodelName;
        $data['entitySingleName'] = $this->CRUDsingularEntityName;

        return view( $viewName, $data );
    }

    public function index( Request $request )
    {
        if ( $request->has( 'search' ) ) {
            $entities = $this->model::search( $request->input( 'search' ) )->orderBy('updated_at','desc')->paginate( 30 );
            $data = [ 'entities' => $entities, 'search' => $request->input( 'search' ) ];
        } else {
            $entities = $this->model::orderBy('updated_at','desc')->paginate( 30 );
            $data = [ 'entities' => $entities ];
        }

        return $this->lastarView( 'admin.CRUD.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->lastarView( 'admin.CRUD.create' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $entity = $this->model::find($id);
        if (!$entity){
            \Session::flash('danger','Entity not found!');
        }
        return $this->lastarView( 'admin.CRUD.edit', ['entity'=>$entity] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $entity = $this->model::find($id);
        if (!$entity){
            \Session::flash('danger','Entity not found!');
        }
        $entity->delete();
        return redirect()->route($this->CRUDmodelName.'.index');

    }

}
