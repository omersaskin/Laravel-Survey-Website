@extends('survey.master')
@section('title', 'Anket İncele')
@section('content')

    @if ($token == 'admin')
            <div class="row mb-5">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('survey.adminIndex') }}"> Geri</a>
                    </div>
                </div>
            </div>
        @elseif($token == 'user')
            <div class="row mb-5">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{route('survey.index')}}"> Geri</a>
                    </div>
                </div>
            </div>
    @endif


    @foreach ($survey as $item)
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Başlık:</strong>
                    {{ $item->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detay:</strong>
                    {{ $item->detail }}
                </div>
            </div>
        </div>
    @endforeach
        @if ($token == 'admin')
            <h4 class="mt-5">Sorular</h4>
            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th>Soru</th>
                        <th>Cevap-1</th>
                        <th>Cevap-2</th>
                        <th>Cevap-3</th>
                        <th>Cevap-4</th>
                        <th>Cevap-5</th>
                    </tr>
                    @foreach ($question as $item)
                        <tr>
                            <td>{{$item->soru}}</td>
                            <td>{{$item->cevap_bir}}</td>
                            <td>{{$item->cevap_iki}}</td>
                            <td>{{$item->cevap_uc}}</td>
                            <td>{{$item->cevap_dort}}</td>
                            <td>{{$item->cevap_bes}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else 

        @endif
@endsection