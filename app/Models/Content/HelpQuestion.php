<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Stores the FAQ questions and answers
 *
 * Class HelpQuestion
 * @package App\Models\Content
 */
class HelpQuestion extends Model
{
    use SearchableTrait;

    const CACHE_KEY = 'cached_help_question';

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

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'help_questions.question_en' => 8,
            'help_questions.question_fr'  => 8,
            'help_questions.answer_fr'  => 6,
            'help_questions.answer_en'  => 6,
            'help_questions.tags_fr'  => 10,
            'help_questions.tags_en'  => 10,
        ]
    ];

    /**
     * Return Cached questions
     */
    public static function getCached( $count = null )
    {
        // Retrive from cache or set to cache
        if ( \Cache::has( self::CACHE_KEY ) ) {
            $questions = \Cache::get( self::CACHE_KEY );
        } else {


            $questions = self::updateCache();
        }

        // Return desired number
        if ( $count ) {
            return $questions->take( $count );
        }

        return $questions;
    }

    /**
     * Update cached questions and return questions
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function updateCache()
    {
        $questions = HelpQuestion::all();
        \Cache::forever( self::CACHE_KEY, $questions );

        return $questions;
    }

    /**
     * Update cache on modification
     */
    public static function boot() {
        parent::boot();

        static::created(function (HelpQuestion $item) {
            self::updateCache();
        });

        static::updated(function (HelpQuestion $item) {
            self::updateCache();
        });

        static::deleted(function (HelpQuestion $item) {
            self::updateCache();
        });

    }

}
