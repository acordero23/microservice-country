<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 *
 * @package App\Models
 */
class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state';

    /**
     * To Disable updated_at, created_at when executed insert which create.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'abbreviation',
        'country_id',
        'creation_date',
        'nacceso'
    ];

    /**
     * Get the Country associated with the State.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}