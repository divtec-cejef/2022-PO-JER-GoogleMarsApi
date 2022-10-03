<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Base extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'bases';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var string[]
     */
    protected $fillable = [
        'nom',
        'credit',
        'positionX',
        'positionY',
        'user_id',
        'img_base',
        'date_fin'
    ];
    /**
     * @var string[]
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * @return string[]
     */
    static function validateRules(): array
    {
        return [
            'nom' => 'required|string|unique:bases',
            'credit' => 'integer',
            'oxygene' => 'integer',
            'positionX' => 'integer',
            'positionY' => 'integer',
            'user_id' => 'integer',
            'img_base' => 'integer',
        ];
    }

}
