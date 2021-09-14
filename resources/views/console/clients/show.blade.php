@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">{{ __('Clients Detail') }}</div>
                <div class="card-body">

                  <div class="row mb-5">
                    <div class="col-sm-12 col-md-6">
                      <h2>ACCOUNT</h2>
                      <b>#{{$client->id}}</b><br>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <div class="d-flex justify-content-end">
                          <div>
                              <b>Name</b> : <a href="{{route('console.clients.view',$client->id)}}">{{$client->nama}}</a><br>
                              <b>Phone Number</b> : {{$client->contactno}}<br>
                              <b>Join Date</b> : {{$client->cdate}}<br>
                              {{$client->country?$client->get_country->countryname:'-'}}<br>
                              <!-- <b>Ewallet Balance</b> : {{ number_format($client->saldo, 2) }}<br> -->
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12 col-12">
                      <div class="card card-success card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            @foreach($tabs as $key => $tab)
                            <li class="nav-item">
                              <a class="nav-link {{$key == "trading_accounts" ? 'active' : ''}}" id="custom-tabs-{{$key}}" data-toggle="pill" href="#{{$key}}" role="tab" aria-controls="{{$key}}" aria-selected="true">{{$tab}}</a>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                        <div class="card-body">
                          <div class="tab-content" id="custom-tabs-four-tabContent">
                            @foreach($tabs as $key => $tab)
                            <div class="tab-pane fade {{$key == "trading_accounts" ? 'show active' : ''}}" id="{{$key}}" role="tabpanel" aria-labelledby="custom-tabs-{{$key}}">
                              @if(View::exists("console.clients.tabs.".$key))
                                @include("console.clients.tabs.".$key)
                              @endif
                            </div>
                            @endforeach
                          </div>
                        </div>
                        <!-- /.card -->
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>

                </div>
            </div>
        </div>
    </div>
@endsection