@extends('survey.master')
@section('title', 'Anket Düzenle')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('survey.adminIndex') }}"> Geri</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Girişinizle ilgili bazı sorunlar var.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('survey.update',$survey->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                <div class="form-group">
                    <strong>Başlık:</strong>
                    <input type="text" name="name" value="{{ $survey->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Açıklama:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $survey->detail }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Devam</button>
            </div>
        </div>

    </form>
    <br><br>
    <form action="{{ route('survey.editDetails') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row pb-5">
            @foreach ($question as $item)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="hidden" name="survey_id" value="{{$item->survey_id}}">
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Soru:</strong>
                                        <input type="text" name="soru" value="{{ $item->soru }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Cevap-1:</strong>
                                        <textarea class="form-control" style="height:150px" name="cevap_bir">{{ $item->cevap_bir }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Cevap-2:</strong>
                                        <textarea class="form-control" style="height:150px" name="cevap_iki">{{ $item->cevap_iki }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Cevap-3:</strong>
                                        <textarea class="form-control" style="height:150px" name="cevap_uc">{{ $item->cevap_uc }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Cevap-4:</strong>
                                        <textarea class="form-control" style="height:150px" name="cevap_dort">{{ $item->cevap_dort }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Cevap-5:</strong>
                                        <textarea class="form-control" style="height:150px" name="cevap_bes">{{ $item->cevap_bes }}</textarea>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary">Devam</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </form>
@endsection