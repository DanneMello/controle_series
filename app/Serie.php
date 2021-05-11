<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'capa'];

    public function GetCapaUrlAttribute()
    {
        if($this->capa)
        {
            return Storage::url($this->capa);
        }

        return Storage::url('serie/sem_img.jpg');
    }

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
