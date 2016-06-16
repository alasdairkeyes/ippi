<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    //
    public function ip_range()
    {
        return $this->belongsTo(IpRange::class);
    }
}
