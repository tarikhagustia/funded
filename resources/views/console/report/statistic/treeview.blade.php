@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    {{ __('Treeview Report') }}
                </div>
                <div class="card-body">
                    <h3 class="text-center">STRUKTUR ORGANISASI AFFILIATES BFX</h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>AF1</th>
                            <th>AF2</th>
                            <th>AF3</th>
                            <th>AF4</th>
                            <th>AF5</th>
                            <th>AF6</th>
                            <th>AF7</th>
                            <th>AF8</th>
                        </tr>

                        </thead>
                        <tbody>
                        @foreach($af as $k1 => $row)
                            <tr>
                                @php
                                    $lastUser = $row;
                                $array = collect();
                                @endphp
                                @foreach(range(1, 7) as $r)
                                   @if ($lastUser && $lastUser->parent)
                                       @php
                                        $array->push("<td>".$lastUser->parent->agentname."</td>")
                                       @endphp
                                   @else
                                        @php
                                            $array->push("<td></td>")
                                        @endphp
                                   @endif
                                    @php
                                        $lastUser = $lastUser->parent ?? null;
                                    @endphp
                                @endforeach

                                @foreach($array->reverse() as $parents)
                                    {!!  $parents  !!}
                                @endforeach
{{--                                <td>{{ $k1+1 }}</td>--}}
                                <td>{{ $row->agentname }} - {{ $row->parent->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
