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

    /**
      * Function to return an array of ip address strings that are in the database
      * for a given ip_range id
      */

    // TODO: Look at maybe direct access to PDO as the results of this could be large and want
    //       to reduce memory footprint and number of SQL statements run
    public static function get_list_of_ip_range_ip_addresses($ip_range_id) {
        $ip_range_ip_addresses = IpAddress::where('ip_range_id', $ip_range_id)->get();

        $ip_addresses = [];
        foreach ($ip_range_ip_addresses as $ip_address) {
            array_push($ip_addresses,$ip_address->address);
        }
        return $ip_addresses;

    }
}
