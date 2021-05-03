<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class County
 *
 * @package App\Models
 */
class County extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'county';

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
        'state_id',
        'creation_date',
        'nacceso'
    ];

    /**
     * Get the State associated with the County.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}