<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 21/04/2018
 * Time: 12:40
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ScamFilteredScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithScams', 'WithoutScams', 'OnlyScams'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($model->getQualifiedMarkedAsScamAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Get the "marked as scam at" column for the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return string
     */
    protected function getMarkedAsScamAtColumn(Builder $builder)
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedMarkedAsScamAtColumn();
        }

        return $builder->getModel()->getMarkedAsScamAtColumn();
    }

    /**
     * Add the with-scams extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithScams(Builder $builder)
    {
        $builder->macro('withScams', function (Builder $builder, $withTrashed = true) {
            if (! $withTrashed) {
                return $builder->withoutScams();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-scams extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutScams(Builder $builder)
    {
        $builder->macro('withoutScams', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedMarkedAsScamAtColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-scams extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyScams(Builder $builder)
    {
        $builder->macro('onlyScams', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedMarkedAsScamAtColumn()
            );

            return $builder;
        });
    }
}