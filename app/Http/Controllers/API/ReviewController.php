<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function store( Request $request )
    {
        $this->validate($request, Review::$rules);

        Review::create($request->all());

        return ['status'=>'ok','message'=>'Review created.'];
    }
}
