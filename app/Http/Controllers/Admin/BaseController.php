<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PasseTonBilletException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;

abstract class BaseController extends Controller
{

    /**
     *
     * Every admin controller extends BaseController.
     * It implements most of laravel CRUD actions apart from update and store, which have to be implemented
     * on the specific controllers.
     *
     */

    /**
     * @var $CRUDmodelName : eg. users
     */
    protected $CRUDmodelName;
    /**
     * @var $CRUDsingularEntityName : eg. User
     */
    protected $CRUDsingularEntityName;
    /**
     * @var $model : eg. User::class
     */
    protected $model;
    /**
     * @var $searchable : wether entity can be searched or not (If model has searchable trait)
     */
    protected $searchable = true;
    /**
     * @var $searchable : wether entity can be created or not
     */
    protected $creatable = true;

    /**
     * @var $paginable : wether entity uses pagination or not
     */
    protected $paginable = true;


    public function __construct()
    {
        $this->middleware( 'auth.admin' );
    }

    /**
     * Handle search, pagination and pass information to view
     *
     * @param       $viewName
     * @param array $data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws PasseTonBilletException
     */
    protected function ptbView( $viewName, $data = [] )
    {
        if ( $this->CRUDmodelName === null ) {
            throw new PasseTonBilletException( '$CRUDmodelName must not be null.' );
        }
        if ( $this->CRUDsingularEntityName === null ) {
            throw new PasseTonBilletException( '$CRUDsingularEntityName must not be null.' );
        }
        $data['model'] = $this->CRUDmodelName;
        $data['entitySingleName'] = $this->CRUDsingularEntityName;
        $data['paginable'] = $this->paginable;

        return view( $viewName, $data );
    }

    /**
     * Show a list of all entities
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        if ( $this->searchable && $request->has( 'search' ) ) {
            $entities = $this->model::search( $request->input( 'search' ) )
                                    ->orderBy( 'updated_at', 'desc' )
                                    ->with(  $this->model::$relationships )
                                    ->paginate( 30 );

            $data = [
                'entities'   => $entities,
                'searchable' => $this->searchable,
                'search'     => $request->input( 'search' ),
                'creatable'  => $this->creatable
            ];
        } else {
            $entities = $this->model::orderBy( 'updated_at', 'desc' )
                                    ->with(  $this->model::$relationships )
                                    ->paginate( 30 );

            $data = [ 'entities' => $entities, 'searchable' => $this->searchable, 'creatable' => $this->creatable ];
        }

        return $this->ptbView( 'admin.CRUD.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->creatable){
            return $this->ptbView( 'admin.CRUD.create' );
        } else {
            flash()->error('You can\'t create this entity');
            return redirect()->back();
        }
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
        return redirect()->route( $this->CRUDmodelName . '.edit', $id );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {

        $entity = $this->model::find( $id );
        if ( ! $entity ) {
            flash()->error('Entity not found!');
            return redirect()->back();
        }

        return $this->ptbView( 'admin.CRUD.edit', [ 'entity' => $entity ] );
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
        $entity = $this->model::find( $id );
        if ( ! $entity ) {
            flash()->error('Entity not found!');
            return redirect()->back();
        }
        $entity->delete();
        flash()->success('Entity deleted!' );
        return redirect()->route( $this->CRUDmodelName . '.index' );
    }

}
