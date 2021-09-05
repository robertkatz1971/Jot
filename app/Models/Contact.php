<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $dates = ['birthday'];

    public function path() {
        return '/contacts/' . $this->id;
    }

    public function scopeBirthdays($query) {

        return $query->whereRaw("birthday like '%-" . now()->format('m') . "-%'" );
    }

}
