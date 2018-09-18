@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Send SMS</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form name="sms" id="sms" method="post" action="{{url('/send-sms')}}">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Recipient</label>
                        <input type="text" name="recipient" class="form-control" id="recipient" aria-describedby="Recipient" placeholder="Mobile number(s) to send to">
                        <small id="emailHelp" class="form-text text-muted">Begin with the country code. If more than one separate with commas e.g +254712521478,+254785412521</small>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Message</label>
                        <textarea class="form-control" id="message" placeholder="Message" rows="5" name="message">
                            
                        </textarea>
                      </div>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="btn btn-primary" name="submit">Send SMS</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
