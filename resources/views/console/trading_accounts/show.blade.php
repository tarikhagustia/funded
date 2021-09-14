@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">{{ __('Trading Account Detail') }}</div>
                <div class="card-body">

                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body login-card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                  <h2>ACCOUNT</h2>
                                  <b>#{{$account->accountid}}</b><br>
                                  <b>{{$account->group->type_name}}</b>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right">
                                    <div class="d-flex justify-content-end">
                                      <div>
                                          <b>Name</b> : <a href="{{route('console.clients.view',$account->client ? $account->client->id : $account->userid)}}">{{$account->client ? $account->client->nama : '-'}}</a><br>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                              <hr>
                              <div class="card card-success card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    @foreach($tabs as $key => $tab)
                                    <li class="nav-item">
                                      <a class="nav-link {{$key == "trades" ? 'active' : ''}}" id="custom-tabs-{{$key}}" data-toggle="pill" href="#{{$key}}" role="tab" aria-controls="{{$key}}" aria-selected="true">{{$tab}}</a>
                                    </li>
                                    @endforeach
                                  </ul>
                                </div>
                                <div class="card-body">
                                  <div class="tab-content" id="custom-tabs-four-tabContent">
                                    @foreach($tabs as $key => $tab)
                                    <div class="tab-pane fade {{$key == "trades" ? 'show active' : ''}}" id="{{$key}}" role="tabpanel" aria-labelledby="custom-tabs-{{$key}}">
                                      @if(View::exists("console.trading_accounts.tabs.".$key))
                                        @include("console.trading_accounts.tabs.".$key)
                                      @endif
                                    </div>
                                    @endforeach
                                  </div>
                                </div>
                                <!-- /.card -->
                              </div>
                            </div>

                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>

                </div>
            </div>
        </div>
    </div>
@endsection