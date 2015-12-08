<?php

namespace Todo;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

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
    protected $fillable = ['task', 'done', 'created_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'created_by'];

    /**
     * Relations
     */
    public function author()
    {
        return $this->belongsTo('Todo\User', 'created_by', 'id');
    }
}
