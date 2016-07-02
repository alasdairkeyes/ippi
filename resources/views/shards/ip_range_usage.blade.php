    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ipRange->ipAddressesInUsePercentage() }}"
      aria-valuemin="0" aria-valuemax="100" style="width:{{ $ipRange->ipAddressesInUsePercentage() }}%; color:black;">
        {{ $ipRange->ipAddressesInUsePercentage() }}&#37;({{ $ipRange->ipAddressesInUse() }}/{{ $ipRange->ipAddressesAvailable() }})
      </div>
    </div>
