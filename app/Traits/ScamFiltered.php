<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 21/04/2018
 * Time: 12:37
 */

namespace App\Traits;

use App\Scopes\ScamFilteredScope;

trait ScamFiltered
{

    /**
     * Boot the scam filtered trait for a model.
     *
     * @return void
     */
    public static function bootScamFiltered()
    {
        static::addGlobalScope(new ScamFilteredScope);
    }

    /**
     * Perform the actual scam query on this model instance.
     *
     * @return void
     */
    public function scam()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        $time = $this->freshTimestamp();

        $columns = [$this->getMarkedAsScamAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getMarkedAsScamAtColumn()} = $time;

        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function unscam()
    {
        // If the scaming event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('unscaming') === false) {
            return false;
        }

        $this->{$this->getMarkedAsScamAtColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('unscamed', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function scammed()
    {
        return ! is_null($this->{$this->getMarkedAsScamAtColumn()});
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function unscaming($callback)
    {
        static::registerModelEvent('unscaming', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function unscamed($callback)
    {
        static::registerModelEvent('unscamed', $callback);
    }


//    ---

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getMarkedAsScamAtColumn()
    {
        return defined('static::MARKED_AS_FRAUD_AT') ? static::MARKED_AS_FRAUD_AT : 'marked_as_fraud_at';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedMarkedAsScamAtColumn()
    {
        return $this->qualifyColumn($this->getMarkedAsScamAtColumn());
    }

}