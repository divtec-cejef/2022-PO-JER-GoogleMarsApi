<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Badge extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'badges';
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
     * @var string[]
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * @return string[]
     */
    static function validateRules(): array
    {
        return [
            'nom' => 'required|string',
            'prix' => 'required|int',
            'section_id' => 'required|string',

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'recevoir');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responsable()
    {
        return $this->belongsToMany(User::class, 'responsable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sections()
    {
        return $this->hasOne(Sections::class);
    }

}
