@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete Owner <em>{{ $ipOwner->name }}</em></div>
                <div class="panel-body">

                    <p>Do you really want to delete this owner</p>

                    @if ($ipOwner->numberOfRanges()) 
                        <p>They are currently assigned to {{ $ipOwner->numberOfRanges() }} IP ranges</p>
                        <p>If you delete them, all this information will be removed</p>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Delete Owner
                                </button>

                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/ip_owners') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Keep Owner
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
