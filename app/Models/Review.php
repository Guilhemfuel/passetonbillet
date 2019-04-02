<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public $table = 'reviews';

    public $fillable = [
        'user_id',
        'mark',
        'text',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'mark'    => 'float',
        'text'    => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mark'    => 'required|numeric',
        'text'    => 'required|string'
    ];

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    /**
     * Boot
     */
    public static function boot() {
        parent::boot();

        static::creating(function (Review $item) {
            $item->user_id = \Auth::id(); //assigning value
        });

    }

    public static function getReviews( $n ) {
        $reviews = [
            [
                'name' =>  'Eugenie',
                'date' => '3rd March 2019',
                'rating' => '5',
                'picture' => secure_asset('img/ninie.jpg'),
                'text' => 'A peine inscrite j\'ai déjà vendu mon A/R Paris Londres. Super site!!'

            ],
            [
                'name' => 'Balthazar',
                'date' => '2nd Febuary 2019',
                'rating' => '5',
                'picture' => secure_asset('img/balou.jpg'),
                'text' => 'Tout s’est super bien passé, je réutiliserai le site pour sûr !'

            ],
            [
                'name' => 'Kristelle',
                'date' => '10th March 2019',
                'rating' => '5',
                'picture' => secure_asset('img/kristelle.jpg'),
                'text' => 'Enfin une plateforme sécurisée, bien mieux que les groupes Facebook !'
            ],
            [
                'name' => 'Christophe',
                'date' => '20th March 2019',
                'rating' => '5',
                'picture' => secure_asset('img/kristelle.jpg'),
                'text' => 'Genial billet vendu en 30 mn. Systeme tres securise.'
            ],
            [
                'name' => 'Reese',
                'date' => '4th March 2019',
                'rating' => '5',
                'picture' => secure_asset('img/reese.jpg'),
                'text' => 'Tres bien ! Pouvez vous ajouter un taux de billet vendu sans probleme, et potentiellement un service qui permet d effectuer la transaction par le site.'
            ],
            [
                'name' => 'Cydney',
                'date' => '9 January 2019',
                'rating' => '5',
                'picture' => secure_asset('img/cydney.jpg'),
                'text' => 'Inscrit il y’a quelque jours, 2 billets revendus ...'
            ],
            [
                'name' => 'Casimer',
                'date' => '18 January 2018',
                'rating' => '5',
                'picture' => secure_asset( 'img/casimer.jpg' ),
                'text' => 'Très  facile et rapide'
            ]
        ];

        shuffle($reviews);
        return array_slice($reviews, 0, $n);
    }

}
