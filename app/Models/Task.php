<?php

namespace App\Models;

class Task extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'done', 'created_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_by'];

    /**
     * Relations
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
