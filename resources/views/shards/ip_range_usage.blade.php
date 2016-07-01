    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ip_range->ipAddressesInUsePercentage() }}"
      aria-valuemin="0" aria-valuemax="100" style="width:{{ $ip_range->ipAddressesInUsePercentage() }}%; color:black;">
        {{ $ip_range->ipAddressesInUsePercentage() }}&#37;({{ $ip_range->ipAddressesInUse() }}/{{ $ip_range->ipAddressesAvailable() }})
      </div>
    </div>
