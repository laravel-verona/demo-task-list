<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Indica se devono essere salvate automaticamente le informazioni
     * sull'autore del record.
     *
     * @var bool
     */
    protected $authors = true;

    /**
     * Utente loggato.
     *
     * @return Dipendente
     */
    public function getLoggedUser()
    {
        return Auth::user();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->authors and $author = $model->getLoggedUser()) {
                $model->created_by = $author->id;
                $model->updated_by = $author->id;
            }
        });

        static::updating(function ($model) {
            if ($model->authors and $author = $model->getLoggedUser()) {
                $model->updated_by = $author->id;
            }
        });

        static::deleting(function ($model) {
            if ($model->authors and $author = $model->getLoggedUser()) {
                $model->deleted_by = $author->id;
            }
        });
    }

    /**
     * Model utente che ha creato il record.
     *
     * @return User
     */
    public function creator()
    {
        if ($this->authors) {
            return User::find($this->created_by);
        }
    }

    /**
     * Model utente che ha aggiornato il record.
     *
     * @return User
     */
    public function editor()
    {
        if ($this->authors) {
            return User::find($this->updated_by);
        }
    }

    /**
     * Model utente che ha eliminato il record (Soft Delete).
     *
     * @return User
     */
    public function trasher()
    {
        if ($this->authors and $this->forceDeleting === false) {
            return User::find($this->deleted_by);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */
    /**
     * Utente che ha creato il record.
     *
     * @return User
     */
    public function getCreatorAttribute()
    {
        return $this->creator();
    }

    /**
     * Utente che ha aggiornato il record.
     *
     * @return User
     */
    public function getEditorAttribute()
    {
        return $this->editor();
    }

    /**
     * Utente che ha eliminato il record.
     *
     * @return User
     */
    public function getTrasherAttribute()
    {
        return $this->trasher();
    }
}
