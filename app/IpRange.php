<?php

namespace App;

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


    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }


    public function network_cidr() {
        return join('/', [ $this->network, $this->cidr ]);
    }


    private function ip_block() {
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
        return count($this->ip_addresses());
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

}
