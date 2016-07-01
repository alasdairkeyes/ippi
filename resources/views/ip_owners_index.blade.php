@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">IP Owners</div>

                <div class="panel-body">
                    Here are the owners of IP ranges
                </div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>IP Owner</th>
                        <th>Description</th>
                        <th>Number of ranges</th>
                        <th width="10">Actions</th>
                        <th>Tags</th>
                      </tr>
                    </thead>
                    <tbody>

                      @include('shards.add_owner_row')

                      @foreach ($ip_owners as $ip_owner)
                      <tr>
                        <td>{{ $ip_owner->name }}</td>
                        <td><span title="{{ $ip_owner->description }}">{{ $ip_owner->description }}</td>
                        <td>{{ $ip_owner->numberOfRanges() }}</td>
                        <td>
                            <a href="/ip_owners/{{ $ip_owner->id }}/delete" title="Delete '{{ $ip_owner->name }}'"><span class="glyphicon glyphicon-trash" aria-hidden=true></span></a>
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                      @endforeach


                      @if (count($ip_owners) > 10)
                        @include('shards.add_owner_row')
                      @endif

                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
