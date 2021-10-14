@extends('survey.master')
@section('title', 'Anketler')
@section('content')
@if(!isset($arama_token))

    @if ($token == 'admin')
        <div class="row mb-5">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('survey.create') }}"> Yeni Anket Oluştur</a>
                </div>
            </div>
        </div>
    @else

    @endif


        @if ($token=='user')
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
        @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

        <div style="overflow-x:auto;">
        <table>
            <tr>
                <th>Anket Adı</th>
                <th>Detay</th>
                <th>İşlemler</th>
            </tr>

            @foreach ($survey as $item)
                @php
                    $id=$item->id;
                    $tmp = \App\Models\Answer::where('user', $user_id)
                        ->where('survey_id', '=', $id)
                        ->get()
                        ->count();
                    $user= \Illuminate\Support\Facades\Auth::id();
                @endphp

                @php
                    $id=$item->id;
                    $smp = \App\Models\SuccessSurvey::where('user', $user)
                        ->where('survey_id', '=', $item->id)
                        ->get()
                        ->count();
                    $user= \Illuminate\Support\Facades\Auth::id();
                @endphp

                @if ($tmp==5 && $smp<1)
                    <form action="{{route('survey.succes')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user" value="{{$user}}">
                        <input type="hidden" name="survey_id" value="{{$item->id}}">
                        <input type="hidden" name="name" value="{{$item->name}}">
                        <input type="hidden" name="detail" value="{{$item->detail}}">
                        Tamamlanan {{$item->name}} adlı anketin sonuçlarını göndermek için <button type="submit"><span style="font-weight:bold;">tıklayınız.</span></button>
                    </form>
                    @elseif($smp==1)
                @endif
                    <br>
                @if ($tmp == 5 && $token == 'user')

                @else
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->detail }}</td>
                        <td>
                            
                            @if ($token == 'admin')
                                <form action="{{ route('survey.destroy',$item->id) }}" method="POST">

                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.adminShow',$item->id) }}">Göster</a>

                                    <a class="btn btn-info text-white a-br" href="{{ route('createDetails',$item->id) }}">Detay</a>

                                    <a class="btn btn-primary a-br" href="{{ route('survey.edit',$item->id) }}">Düzenle</a>

                                    @csrf
                                    @method('DELETE')
                    
                                    <button type="submit" class="btn btn-danger">Sil</button>
                                </form>
                            @elseif($token == 'user')
                                <form action="{{ route('survey.destroy',$item->id) }}" method="POST">

                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.show',$item->id) }}">Detay</a>
                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.createAnswer',$item->id) }}">Cevapla</a>
                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.comment',$item->id) }}">Yorumla</a>


                                    @csrf
                                </form>                            
                            @endif
                        </td>
                    </tr>    
                @endif
            @endforeach
        </table>
    </div>
        @endif
        <br><br>
    {!! $survey->links() !!}
    
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
    </div>   

@endsection