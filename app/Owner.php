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

    public function number_of_ranges() {
        return count($this->ip_ranges);
    }
}
