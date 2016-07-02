@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete IP Range <em>{{ $ipRange->networkCidr() }}</em></div>
                <div class="panel-body">

                    <p>Do you really want to delete this IP Range</p>

                    @if ($ipRange->ipAddressesInUse()) 
                        <p>There are currently {{ $ipRange->ipAddressesInUse() }} IP addresses in this range assigned</p>
                        <p>If you delete them, all this information will be removed</p>
                    @else
                        <p>No IP addresses in this range have been assigned</p>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Delete IP Range
                                </button>

                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/ip_ranges') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Keep IP Range
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
