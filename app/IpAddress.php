<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    //
    public $fillable = [ 'address', 'hostname', 'description' ];

    public function ipRange()
    {
        return $this->belongsTo(IpRange::class);
    }

    /**
      * Function to return an array of ip address strings that are in the database
      * for a given ip_range id
      */

    // TODO: Look at maybe direct access to PDO as the results of this could be large and want
    //       to reduce memory footprint and number of SQL statements run
    public static function getListOfIpRangeIpAddresses($ipRangeId)
    {
        $ipRangeIpAddresses = IpAddress::where('ip_range_id', $ipRangeId)->get();

        $ipAddresses = [];
        foreach ($ipRangeIpAddresses as $ipAddress)
        {
            array_push($ipAddresses,$ipAddress->address);
        }
        return $ipAddresses;

    }
}
