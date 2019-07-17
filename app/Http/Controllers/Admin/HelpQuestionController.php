<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content\HelpQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpQuestionController extends BaseController
{

    protected $CRUDmodelName = 'help_questions';
    protected $CRUDsingularEntityName = 'Help Question';

    protected $creatable = true;

    protected $model = HelpQuestion::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $this->validate($request,HelpQuestion::$rules);

        $question = new HelpQuestion( $request->all() );
        $question->save();

        flash()->success( $this->CRUDsingularEntityName . ' created!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $question->id );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        $user = User::find( $id );
        if ( ! $user ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }
        $user->update( $request->all() );
        $user->save();

        flash()->success( $this->CRUDsingularEntityName . ' updated!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $user->id );
    }
}
