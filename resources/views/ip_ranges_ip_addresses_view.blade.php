@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update IP Address <em>{{ $ipAddressString }}</em></div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('hostname') ? ' has-error' : '' }}">
                            <label for="hostname" class="col-md-4 control-label">Hostname</label>

                            <div class="col-md-6">
                                <input id="hostname" type="text" class="form-control" name="hostname" value="{{ old('hostname', isset($ip_address) ? $ip_address->hostname : '') }}">

                                @if ($errors->has('hostname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hostname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" rows="4">{{ old('description', isset($ip_address) ? $ip_address->description : '') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Update
                                </button>

                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/ip_ranges/' . $ipRange->id ) }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Cancel
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
