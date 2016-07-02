@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are tracking the following IP information!
                    <div class="row">
                      <div class="col-lg-6 text-center">
                        <h3>IP Ranges</h3>
                          <p class="large-home-text">{{ $ipRangeCount }}</p>
                        <p><a class="btn btn-default" href="/ip_ranges" role="button">View &raquo;</a></p>
                      </div><!-- /.col-lg-6 -->
                      <div class="col-lg-6 text-center">
                        <h3>IP Owners</h3>
                          <p class="large-home-text">{{ $ipOwnerCount }}</p>
                        <p><a class="btn btn-default" href="/ip_owners" role="button">View &raquo;</a></p>
                      </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
