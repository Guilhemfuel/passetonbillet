<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class TableCrudController extends Controller
{
    public $class;
    public $classResource;

    public function __construct()
    {
        if ($this->class == null) {
            throw new \Exception('$class controller attribute must be defined.');
        }
        if ($this->classResource == null) {
            throw new \Exception('$classResource controller attribute must be defined.');
        }
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
        $request = request();

        $query = $this->defaultQuery();
        $obj = ( new $this->class );
        $validColumns = $obj->getFillable();

        /*
         * Validate request
         */
        \Validator::make( $request->all(), [
            'items_per_page'   => [ 'nullable', 'integer', 'min:0' ],
            'sort_by'          => [ 'nullable', 'string', 'in:' . implode( ',', $validColumns ) ],
            'sort_desc'        => [ 'nullable', 'string', 'in:true,false' ],
            'search_value'     => [ 'required_with:search_columns', 'string' ],
            'search_columns.*' => [
                'required_with:search_value',
                'in:' . implode( ',', $validColumns )
            ]

        ] )->validate();

        /*
         *  Search by the given column
         */
        if ( $request->has( 'search_value' ) && $request->has( 'search_columns' ) ) {
            $searchName = '%' . strtolower( $request->search_value ) . '%';

            foreach ( $request->search_columns as $key => $column ) {

                // Make sure column name is valid
                if ( ! in_array( $column, $validColumns ) ) {
                    throw new \InvalidArgumentException( "Field {$column} does not exist on model {$this->class}." );
                }

                $columnQuery = $column;

                // Default case
                if ( $key === 0 ) {
                    $query = $query->where( \DB::raw( "LOWER({$columnQuery})" ), "LIKE", $searchName );
                } else {
                    $query = $query->orWhere( \DB::raw( "LOWER({$columnQuery})" ), "LIKE", $searchName );
                }
            }
        }

        /*
         *  Sort by the given column
         */
        if ( $request->has( 'sort_by' ) ) {

            // Make sure column name is valid
            if ( ! in_array( $request->sort_by, $validColumns ) ) {
                throw new \InvalidArgumentException( "Field {$request->sort_by} does not exist on model {$this->class}." );
            }

            $sortQuery = $request->sort_by;

            if ( ! $request->has( 'sort_desc' ) || $request->sort_desc == 'false' ) {
                $query = $query->orderBy( $sortQuery );
            } else {
                $query = $query->orderByDesc( $sortQuery );
            }
        } else {
            $query = $query->latest();
        }

        /*
         *  Pagination
         */
        if ( $request->has( 'items_per_page' ) ) {
            if ( $request->items_per_page == 0 ) {
                // Return all results, no pagination
                $data = $query->get();
            } else {
                $data = $query->paginate( $request->items_per_page );
            }
        } else {
            $data = $query->paginate( self::DEFAULT_PAGINATION );
        }

        return $this->classResource::collection($data);
    }

    protected function defaultQuery() {
        $obj = ( new $this->class );
        return $obj->newQuery();
    }

}
