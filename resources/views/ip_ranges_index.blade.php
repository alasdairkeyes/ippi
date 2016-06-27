@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">IP Ranges</div>

                <div class="panel-body">
                    Here are your IP Ranges
                </div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th width="30%">IP Range</th>
                        <th>Owner</th>
                        <th width="10%">Version</th>
                        <th>Size</th>
                        <th>Action</th>
                        <th>Tags</th>
                      </tr>
                    </thead>
                    <tbody>
                      @include('shards.add_ip_range_row')

                      @foreach ($ip_ranges as $ip_range)
                      <tr>
                        <td>{{ $ip_range->network_cidr() }}</td>
                        <td>{{ $ip_range->owner->name }}</td>
                        <td>IPv{{ $ip_range->ip_version }}</td>
                        <td>
                            @include('shards.ip_range_usage')
                        </td>
                        <td>
                            <a href="/ip_ranges/{{ $ip_range->id }}/delete" title="Delete '{{ $ip_range->network_cidr() }}'"><span class="glyphicon glyphicon-trash" aria-hidden=true></span></a>
                            <a href="/ip_ranges/{{ $ip_range->id }}" title="View '{{ $ip_range->network_cidr() }}'"><span class="glyphicon glyphicon-search" aria-hidden=true></span></a>
                        </td>
                        <td>
                        </td>
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
