<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpRange extends Model
{
    //
    public function ip_addresses()
    {
        return $this->HasMany(IpAddress::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function network_cidr() {
        return join(' / ', [ $this->network, $this->cidr ]);
    }
}
