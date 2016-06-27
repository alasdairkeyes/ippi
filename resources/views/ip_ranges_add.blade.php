@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add IP Range</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/ip_ranges/add') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('network') ? ' has-error' : '' }}">
                            <label for="network" class="col-md-4 control-label">Network</label>

                            <div class="col-md-6">
                                <input id="network" type="text" class="form-control" name="network" placeholder="192.168.0.0" value="{{ old('network') }}">

                                @if ($errors->has('network'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('network') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cidr') ? ' has-error' : '' }}">
                            <label for="cidr" class="col-md-4 control-label">CIDR</label>

                            <div class="col-md-6">
                                <input id="cidr" type="text" class="form-control" name="cidr" placeholder="24" value="{{ old('cidr') }}">

                                @if ($errors->has('cidr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cidr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('owner_id') ? ' has-error' : '' }}">
                            <label for="owner_id" class="col-md-4 control-label">Owner</label>

                            <div class="col-md-6">
                                <select id="owner_id" name="owner_id" class="form-control">
                                    @foreach ($ip_owners as $ip_owner)
                                        <option value="{{ $ip_owner->id }}"
                                            @if (old('owner_id') == $ip_owner->id)
                                                selected
                                            @endif
                                        >{{ $ip_owner->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('owner_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('owner_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Create IP Range
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
