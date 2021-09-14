@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">{{ __('Affiliate Detail') }}</div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <h2>ACCOUNT</h2>
                      <b>#{{$affiliate->id}}</b><br>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <div class="d-flex justify-content-end">
                          <div>
                              <b>Name</b> : <a href="{{route('console.affiliates.show',$affiliate->id)}}">{{$affiliate->agentname}}</a><br>
                              <b>Email</b> : {{$affiliate->agentemail}}<br>
                              <b>Phone Number</b> : {{$affiliate->agentphone}}<br>
                              <b>Agent Code</b> : {{$affiliate->agentcode}}<br>
                              <b>Reference By</b> : {{$affiliate->reference_by ?? '-'}}<br>
                              <b>Join Date</b> : {{$affiliate->createddate}}<br>
                          </div>
                        </div>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
@endsection