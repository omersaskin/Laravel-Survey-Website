@extends('auth.master')
@section('title', 'Giriş')

    <main class="login-form pt-5 mb-5">
        <div class="container">
            <div class="row">
                @section('content')
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                <div class="col-md-8 mt-5">
                    <h1 class="text-dark text-center">Anketler</h1>
                    @if (isset($survey))
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
                            $tmp = \App\Models\Visitor::where('visitor', Session::get('token'))
                                ->where('survey_id', '=', $id)
                                ->get()
                                ->count();
                        @endphp
                        @php
                            $id=$item->id;
                            $smp = \App\Models\SuccessSurvey::where('user', Session::get('token'))
                                ->where('survey_id', '=', $id)
                                ->get()
                                ->count();
                        @endphp
                        @if ($tmp==5 && $smp<1)
                            <form action="{{route('survey.succesVisitor')}}" method="POST">
                                @csrf
                                <input type="hidden" name="user" value="{{Session::get('token')}}">
                                <input type="hidden" name="survey_id" value="{{$item->id}}">
                                <input type="hidden" name="name" value="{{$item->name}}">
                                <input type="hidden" name="detail" value="{{$item->detail}}">
                                Tamamlanan {{$item->name}} adlı anketin sonuçlarını göndermek için <button type="submit"><span style="font-weight:bold;">tıklayınız.</span></button>
                                <br><br>
                            </form>
                            @elseif($smp==1)
                        @endif
                    
                                    @if ($tmp == 5)
                                        
                                    @else
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->detail }}</td>
                                            <td>
                                                <form action="{{ route('survey.destroy',$item->id) }}" method="POST">
                                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.showVisitor',$item->id) }}">Detay</a>
                                                    <a class="btn btn-info text-white a-br" href="{{ route('survey.createAnswerVisitor', $item->id) }}">Cevapla</a>
                                                    @csrf
                                                </form>                            
                                            </td>
                                        </tr>  
                                    @endif
                                @endforeach
                            </table>
                        </div>
                        <br><br>
                        {!! $survey->links() !!} 

                        @elseif(isset($question))

                            <div class="pull-right mb-5">
                                <a class="btn btn-primary" href="{{ route('login') }}"> Geri</a>
                            </div>
                            @foreach ($question as $item)
                                <form action="{{route('survey.saveAnswerVisitor')}}" method="POST" class="mb-3">
                                    @csrf
                                    <input type="hidden" name="survey_id" value="{{$item->survey_id}}">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <input type="hidden" name="visitor" value="{{Session::get('token')}}">
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
                                    $data = \App\Models\Visitor::where('visitor', Session::get('token'))
                                    ->where('survey_id', $item->survey_id)
                                    ->where('id', '=', $item->id)->get();
                                @endphp
                                @foreach ($data as $item)
                                    <p>Bu soru için {{$item->radio}} şıkkını işaretlediniz.</p>
                                @endforeach
                                
                            {!! $question->links() !!} 

                            @endforeach
                @endif

                </div>

                <div class="col-md-4 mt-5 mb-5">
                    <div class="card">
                        <h3 class="card-header text-center bg-info text-light">Giriş</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.custom') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="E-Posta" id="email" class="form-control" name="email" required
                                        autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Şifre" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-info btn-block text-light">Devam</button>
                                </div>
                            </form>
                            <div class="d-grid mx-auto mt-5">
                                <a href="{{route('register-user')}}" class="btn btn-info btn-block text-light">Ya da Üye Olun</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection