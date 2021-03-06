<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Profile extends Model
{

    use Searchable;

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array["index"] = $this->user->name;
        // Customize array...

        return $array;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
