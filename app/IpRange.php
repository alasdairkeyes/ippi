<?php

namespace App;
use App\IpAddress;

use Illuminate\Database\Eloquent\Model;

class IpRange extends Model
{

    protected $fillable = ['network','cidr','owner_id','ip_version'];

    // Internal storage for IPBlock object
    private $_ip_block;


    public function ip_addresses()
    {
        return $this->HasMany(IpAddress::class);
    }

    public function list_ip_addresses_in_use() {
        return IpAddress::get_list_of_ip_range_ip_addresses($this->id);
    }


    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }


    public function network_cidr() {
        return join('/', [ $this->network, $this->cidr ]);
    }


    public function ip_block() {
        if (!$this->_ip_block) {
            $this->_ip_block = \IPBlock::create($this->network_cidr());
        }
        return $this->_ip_block;
    }


    public function ip_addresses_total() {
        return $this->ip_block()->getNbAddresses();
    }


    public function ip_addresses_available() {
        return $this->ip_addresses_total() - 2;
    }


    public function ip_addresses_in_use() {
        return count($this->ip_addresses);
    }


    public function ip_addresses_in_use_percentage() {
        return sprintf('%.2f', ($this->ip_addresses_in_use() / $this->ip_addresses_available()) * 100);
    }


    public function ip_addresses_available_percentage() {
        return sprintf('%.2f', (($this->ip_addresses_available() - $this->ip_addresses_in_use()) / $this->ip_addresses_available()) * 100);
    }


    public function network_address() {
        return $this->ip_block()->getFirstIp();
    }


    public function broadcast_address() {
        return $this->ip_block()->getLastIp();
    }

    public function contains_ip_range ($ip_block) {
        // Check this block doesn't contain another block
        return $this->ip_block()->contains($ip_block);
    }

    public function is_in_ip_range ($ip_block) {
        // Check this block isn't in another block
        return $this->ip_block()->isIn($ip_block);
    }

    public function iterate_ip_addresses() {
        return new IpAddressIterator ($this);
    }

    /*
     *  Checks if an IP address is one of the reserved ones on this range
     *  Accepts a string containing an IP address
     *  Returns true if it is reserved
     *  Returns false if it is not reserved
     *  Throws exception if it's not even part of this range
     */
    public function is_reserved_address($ip_address) {
        if ($this->contains_ip_range($ip_address)) {
            if ($ip_address == $this->network_address() || $ip_address == $this->broadcast_address()) {
                return true;
            }
            return false;
        }
        throw new Exception(__CLASS__ . " IP '$ip_address' isn't within this range " . $this->address_cidr());
    }

}



/*
 *  Iterator Class to iterate through all IP addresses in this range
 *  This class queries the database for a list of all known IP addresses
 *  in the range, the array is stored in $ip_address_list
 *  This class actually iterates through the supplied IPvXBlock object, and
 *  if it finds that the IP address is in the array it loads the record from
 *   the database
 *  It is a trade off between, lots of database accesses for individual records
 *  and large memory use by grabbing all records and instantiating objects at once
 */


class IpAddressIterator implements \Iterator {

    private $ip_range;
    private $ip_block;
    private $ip_address_list;

    public function __construct($ip_range) {
        $this->ip_range         = $ip_range;
        $this->ip_block         = $ip_range->ip_block();
        $this->ip_address_list  = $ip_range->list_ip_addresses_in_use();
    }

    function rewind() {
        $this->ip_block->rewind();
    }

    function key() {
        return $this->ip_block->key();
    }

    function next() {
        $this->ip_block->next();
    }

    function valid() {
        return $this->ip_block->valid();
    }

    function current() {
        // Get current UP address from the block
        $current_ip_address = $this->ip_block->current();
        $r= null;

        // If value is in the array... load the object and pass back
        if (in_array($current_ip_address, $this->ip_address_list)) {
            $r = IpAddress::where('ip_range_id', $this->ip_range->id)
                          ->where('address', $current_ip_address)
                          ->first();
        }
        return array($this->ip_block->current(), $r);
    }
}

