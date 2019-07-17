<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class HelpQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray( $request )
    {

        if ( \App::getLocale() == 'fr' ) {
            return [
                'id'      => $this->id,
                'title'   => $this->question_fr,
                'content' => $this->answer_fr,
                'tags'    => explode( "\n", $this->tags_fr ),
            ];
        } else {
            return [
                'id'      => $this->id,
                'title'   => $this->question_en,
                'content' => $this->answer_en,
                'tags'    => explode( "\n", $this->tags_en ),
            ];
        }
    }
}
