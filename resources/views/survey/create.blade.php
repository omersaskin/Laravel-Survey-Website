@extends('survey.master')
@section('title', 'Anket Oluştur')
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

    <form action="{{ route('survey.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Başlık:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Başlık">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Detay:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detay"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-5">
                    <button type="submit" class="btn btn-primary">Devam</button>
            </div>
        </div>

    </form>
@endsection