<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //

    public function ip_ranges()
    {
        return $this->HasMany(IpRange::class);
    }
}
