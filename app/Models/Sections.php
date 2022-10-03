<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Sections extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'sections';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $fillable = [
    ];
    /**
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * @return string[]
     */
    static function validateRules(): array
    {
        return [
            'nom' => 'required|string|unique:sections|max:3',
        ];
    }
}
