@extends('layouts.master')
@section('title', 'Anket Cevapla')
@section('content')
        <div class="row mb-5">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('survey.index') }}"> Geri</a>
                </div>
            </div>
        </div>
        @foreach ($question as $item)
            <form action="{{route('survey.saveAnswer')}}" method="post" class="mb-3">
                @csrf
                <input type="hidden" name="survey_id" value="{{$item->survey_id}}">
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="hidden" name="user" value="{{$user}}">
                <h4>{{$item->soru}}</h4>
                <label>
                    <input type="radio" name="radio" value="{{$item->cevap_bir}}">{{$item->cevap_bir}}
                    <span class="select"></span>
                </label>
                <label>
                    <input type="radio" name="radio" value="{{$item->cevap_iki}}">{{$item->cevap_iki}}
                    <span class="select"></span>
                </label>
                <label>
                    <input type="radio" name="radio" value="{{$item->cevap_uc}}">{{$item->cevap_uc}}
                    <span class="select"></span>
                </label>
                <label>
                    <input type="radio" name="radio" value="{{$item->cevap_dort}}">{{$item->cevap_dort}}
                    <span class="select"></span>
                </label>
                <label>
                    <input type="radio" name="radio" value="{{$item->cevap_bes}}">{{$item->cevap_bes}}
                    <span class="select"></span>
                </label>

                <input type="submit" name="submit" value="Devam">
            </form>
            @php
                $data = \App\Models\Answer::where('user', '=', $user)
                ->where('id', '=', $item->id)
                ->get();
            @endphp
            @foreach ($data as $item)
                <p>Bu soru için {{$item->radio}} şıkkını işaretlediniz.</p>
            @endforeach
        @endforeach
        {{$question->links('pagination::bootstrap-4')}}
@endsection