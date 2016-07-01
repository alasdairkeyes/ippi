@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">IP Range {{ $ip_range->networkCidr() }} addresses</div>

                <div class="panel-body">
                    <ul class="list-group">
                      <li class="list-group-item"><b>Owner:</b> {{ $ip_range->owner->name }}</li>
                      <li class="list-group-item">
                        <b>Range:</b>
                            {{ $ip_range->networkCidr() }} ( {{ $ip_range->ipAddressesTotal() }} addresses total, {{ $ip_range->ipAddressesAvailable() }} assignable )<br/>
                            @include('shards.ip_range_usage')
                      </li>
                      <li class="list-group-item"><b>IP Version:</b> {{ $ip_range->ipVersion }}</li>
                    </ul>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th width="30%">IP Address</th>
                        <th>Hostname</th>
                        <th>Description</th>
                        <th>Action</th>
                        <th>Tags</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ip_range->iterateIpAddresses() as $ip_address_array)
                        <?php
                            $row_class = '';
                            if ($ip_range->isReservedAddress($ip_address_array[0])) {
                                $row_class = 'danger';
                            } elseif ($ip_address_array[1]) {
                                $row_class = 'success';
                            }
                        ?>
                        <tr class="{{ $row_class }}">
                          <td>{{ $ip_address_array[0] }}</td>
                          <td>{{ $ip_address_array[1] ? $ip_address_array[1]->hostname : '-' }}</td>
                          <td>
                              @if ($ip_address_array[1]) 
                                <span title="{{ $ip_address_array[1]->description }}">{{ substr($ip_address_array[1]->description,0,30) }}</span>
                              @elseif ($ip_range->isReservedAddress($ip_address_array[0]))
                                Reserved by IP Protocol
                              @else
                                -
                              @endif
                          </td>
                          <td>
                              @if (!$ip_range->isReservedAddress($ip_address_array[0]))
                                <a href="/ip_ranges/{{ $ip_range->id }}/ip_addresses/{{ $ip_address_array[0] }}" title="Update '{{ $ip_address_array[0] }}'"><span class="glyphicon glyphicon-pencil" aria-hidden=true></span></a>
                              @endif
                              @if ( $ip_address_array[1] )
                                &nbsp;<a href="/ip_ranges/{{ $ip_range->id }}/ip_addresses/{{ $ip_address_array[0] }}/delete" title="Clear '{{ $ip_address_array[0] }}'"><span class="glyphicon glyphicon-trash" aria-hidden=true></span></a>
                              @endif
                          </td>
                          <td></td>
                        </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
