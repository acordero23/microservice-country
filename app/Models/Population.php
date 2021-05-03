<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Population
 *
 * @package App\Models
 */
class Population extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'population';

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
        'zip_code',
        'county_id',
        'creation_date',
        'nacceso'
    ];

    /**
     * Get the State associated with the County.
     */
    public function county()
    {
        return $this->belongsTo(County::class);
    }
}