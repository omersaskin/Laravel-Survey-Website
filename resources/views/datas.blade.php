@extends('layouts.master')
@section('title', 'Anket Yönetimi')
@section('content')
@if (!isset($arama_token))
<h4>Günlere Göre Anket Bitme Durumu</h4>
<canvas id="myChart"></canvas>

<script>
    var t1 = <?php echo $m1; ?>;
    var t2 = <?php echo $m2; ?>;
    var t3 = <?php echo $m3; ?>;
    var t4 = <?php echo $m4; ?>;
    var t5 = <?php echo $m5; ?>;
    var t6 = <?php echo $m6; ?>;
    var t7 = <?php echo $m7; ?>;

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
            datasets: [{
                label: 'Miktar',
                data: [t5, t6, t7, t1, t2, t3, t4],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<br><br>
<h2>Yorumlar</h2>
    <div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Kullanıcı</th>
            <th>Anket</th>
            <th>Yorum</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($comments as $item)
                @php
                    $user_id=$item->user_id;
                    $survey_id=$item->survey_id;
                    $tmp_user = \App\Models\User::where('id', '=', $user_id)->get();
                    $tmp_survey = \App\Models\Survey::where('id', '=', $survey_id)->get();
                    $comment=$item->comment;
                    $id=$item->id;
                @endphp
                <tr>
                    <td>
                        @foreach ($tmp_user as $item)
                            {{$item->name}}
                        @endforeach    
                    </td>
                    <td>
                        @foreach ($tmp_survey as $item)
                            {{$item->name}}
                        @endforeach    
                    </td>
                    <td>
                        {{$comment}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endif

@if(isset($arama_token))

<h2 class="text-center">Arama Sonucu</h2>
<div class="table-responsive">
<table class="table table-striped table-sm">
    <thead>
    <tr>
        <th>Kullanıcı Adı</th>
        <th>E-Posta</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($posts as $item)
            <tr>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->email}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

@if(isset($question))
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
@endif

<br><br>
@endsection