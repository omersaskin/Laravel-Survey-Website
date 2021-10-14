@extends('survey.master')
@section('title', 'Soru Oluştur')
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

    <form action="{{ route('storeDetails') }}" method="POST">
        @csrf

        <div class="row pb-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Soru:</strong>
                    <input type="text" name="soru" class="form-control" placeholder="Soru">
                    <input type="hidden" name="survey_id" value="{{$survey_id}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Cevap-1:</strong>
                    <textarea class="form-control" style="height:150px" name="cevap_bir" placeholder="Cevap-1"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Cevap-2:</strong>
                    <textarea class="form-control" style="height:150px" name="cevap_iki" placeholder="Cevap-2"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Cevap-3:</strong>
                    <textarea class="form-control" style="height:150px" name="cevap_uc" placeholder="Cevap-3"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Cevap-4:</strong>
                    <textarea class="form-control" style="height:150px" name="cevap_dort" placeholder="Cevap-4"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Cevap-5:</strong>
                    <textarea class="form-control" style="height:150px" name="cevap_bes" placeholder="Cevap-5"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-5">
                    <button type="submit" class="btn btn-primary">Devam</button>
            </div>
        </div>

    </form>
@endsection