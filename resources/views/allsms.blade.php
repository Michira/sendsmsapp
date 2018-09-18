@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">          
            <div class="card">  
                <div class="card-header alert-primary">All Sent SMS
                    
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover display nowrap" id="mytable">
                      <thead>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created On</th>                        
                      </thead>
                      <tbody>
                        @foreach($sms as $s_log)
                          <tr>
                            <td>{{$s_log->phone}}</td>
                            <td>{{$s_log->message}}</td>
                            <td>{{$s_log->status}}</td>
                            <td>{{$s_log->created_at}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
