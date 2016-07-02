@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete IP Address <em>{{ $ip_address->address }}</em></div>
                <div class="panel-body">

                    <p>Do you really want to clear this IP Address</p>

                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Delete IP Address
                                </button>

                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/ip_ranges/' . $ip_address->ip_range_id . '/' . $ip_address->address ) }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Keep IP Address
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
