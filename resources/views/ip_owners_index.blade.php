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
                        <th>Tags</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ip_owners as $ip_owner)
                      <tr>
                        <td>{{ $ip_owner->name }}</td>
                        <td><span title="{{ $ip_owner->description }}">{{ $ip_owner->description }}</td>
                        <td>{{ $ip_owner->number_of_ranges() }}</td>
                        <td>&nbsp;</td>
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
