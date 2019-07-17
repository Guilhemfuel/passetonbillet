<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

/**
 * Stores the FAQ questions and answers
 *
 * Class HelpQuestion
 * @package App\Models\Content
 */
class HelpQuestion extends Model
{
    public $table = 'help_questions';

    public static $relationships = [];

    public $fillable = [
        'question_en',
        'question_fr',
        'answer_en',
        'answer_fr',
        'tags_en',
        'tags_fr'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_en' => 'string',
        'question_fr' => 'string',
        'answer_en'   => 'string',
        'answer_fr'   => 'string',
        'tags_en'     => 'string',
        'tags_fr'     => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question_en' => 'required|string',
        'question_fr' => 'required|string',
        'answer_en'   => 'required|string',
        'answer_fr'   => 'required|string',
        'tags_en'     => 'required|string',
        'tags_fr'     => 'required|string',
    ];
}
