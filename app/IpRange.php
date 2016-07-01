<?php

namespace App;
use App\IpAddress;

use Illuminate\Database\Eloquent\Model;

class IpRange extends Model
{

    protected $fillable = ['network','cidr','owner_id','ip_version'];

    // Internal storage for IPBlock object
    private $ipBlock;


    public function ipAddresses()
    {
        return $this->HasMany(IpAddress::class);
    }

    public function listIpAddressesInUse()
    {
        return IpAddress::getListOfIpRangeIpAddresses($this->id);
    }


    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }


    public function networkCidr()
    {
        return join('/', [ $this->network, $this->cidr ]);
    }


    public function ipBlock()
    {
        if (!$this->ipBlock) {
            $this->ipBlock = \IPBlock::create($this->networkCidr());
        }
        return $this->ipBlock;
    }


    public function ipAddressesTotal() 
    {
        return $this->ipBlock()->getNbAddresses();
    }


    public function ipAddressesAvailable()
    {
        return $this->ipAddressesTotal() - 2;
    }


    public function ipAddressesInUse()
    {
        return count($this->ipAddresses);
    }


    public function ipAddressesInUsePercentage()
    {
        return sprintf('%.2f', ($this->ipAddressesInUse() / $this->ipAddressesAvailable()) * 100);
    }


    public function ipAddressesAvailablePercentage()
    {
        return sprintf('%.2f', (($this->ipAddressesAvailable() - $this->ipAddressesInUse()) / $this->ipAddressesAvailable()) * 100);
    }


    public function networkAddress()
    {
        return $this->ipBlock()->getFirstIp();
    }


    public function broadcastAddress()
    {
        return $this->ipBlock()->getLastIp();
    }

    public function containsIpRange ($ipBlock)
    {
        // Check this block doesn't contain another block
        return $this->ipBlock()->contains($ipBlock);
    }

    public function isInIpRange ($ipBlock)
    {
        // Check this block isn't in another block
        return $this->ipBlock()->isIn($ipBlock);
    }

    public function iterateIpAddresses()
    {
        return new IpAddressIterator ($this);
    }

    /*
     *  Checks if an IP address is one of the reserved ones on this range
     *  Accepts a string containing an IP address
     *  Returns true if it is reserved
     *  Returns false if it is not reserved
     *  Throws exception if it's not even part of this range
     */
    public function isReservedAddress($ipAddress)
    {
        if ($this->containsIpRange($ipAddress)) {
            if ($ipAddress == $this->networkAddress() || $ipAddress == $this->broadcastAddress()) {
                return true;
            }
            return false;
        }
        throw new Exception(__CLASS__ . " IP '$ipAddress' isn't within this range " . $this->networkCidr());
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


class IpAddressIterator implements \Iterator
{

    private $ipRange;
    private $ipBlock;
    private $ipAddressList;

    public function __construct($ipRange)
    {
        $this->ipRange          = $ipRange;
        $this->ipBlock          = $ipRange->ipBlock();
        $this->ipAddressList    = $ipRange->listIpAddressesInUse();
    }

    function rewind()
    {
        $this->ipBlock->rewind();
    }

    function key()
    {
        return $this->ipBlock->key();
    }

    function next()
    {
        $this->ipBlock->next();
    }

    function valid()
    {
        return $this->ipBlock->valid();
    }

    function current()
    {
        // Get current UP address from the block
        $currentIpAddress = $this->ipBlock->current();
        $r= null;

        // If value is in the array... load the object and pass back
        if (in_array($currentIpAddress, $this->ipAddressList)) {
            $r = IpAddress::where('ip_range_id', $this->ipRange->id)
                          ->where('address', $currentIpAddress)
                          ->first();
        }
        return array($this->ipBlock->current(), $r);
    }
}

