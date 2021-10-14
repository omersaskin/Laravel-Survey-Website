@extends('survey.master')
@section('title', 'Yorum Oluştur')
@section('content')
    <div class="row mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('survey.index') }}"> Geri</a>
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

    <form action="{{ route('storeComment') }}" method="POST">
        @csrf

        <div class="row">
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <input type="hidden" name="survey_id" value="{{$survey_id}}">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <strong>Yorum:</strong>
                    <textarea class="form-control" style="height:150px" name="comment" placeholder="Yorum"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-5">
                    <button type="submit" class="btn btn-primary">Devam</button>
            </div>
        </div>
    </form>
@endsection