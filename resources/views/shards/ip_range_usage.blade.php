    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ip_range->ip_addresses_in_use_percentage() }}"
      aria-valuemin="0" aria-valuemax="100" style="width:{{ $ip_range->ip_addresses_in_use_percentage() }}%; color:black;">
        {{ $ip_range->ip_addresses_in_use_percentage() }}&#37;({{ $ip_range->ip_addresses_in_use() }}/{{ $ip_range->ip_addresses_available() }})
      </div>
    </div>
