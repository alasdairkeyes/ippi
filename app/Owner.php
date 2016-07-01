<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    //
    protected $fillable = ['name','description'];

    public function ipRanges()
    {
        return $this->HasMany(IpRange::class);
    }

    public function numberOfRanges()
    {
        return count($this->ipRanges);
    }
}
