<?php
  
namespace App\Http\Controllers;
   
use App\Models\Survey;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\ComplateSurvey;
use App\Models\SuccessSurvey;
use App\Models\Visitor;
use App\Models\User;
use App\Models\SurveyDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $survey = Survey::latest()->paginate(5);
        $token="admin";
        $user_id=Auth::id();

        return view('survey.index',compact('survey', 'token', 'user_id'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function userIndex()
    {
        $survey = Survey::latest()->paginate(5);
        $token="user";
        $user_id=Auth::id();
        
        $d7 = date("Y-m-d", strtotime("+ 3 day"));
        $d6 = date("Y-m-d", strtotime("+ 2 day"));
        $d5 = date("Y-m-d", strtotime("+ 1 day"));
        $d4 = date("Y-m-d");
        $d3 = date("Y-m-d", strtotime("- 1 day"));
        $d2 = date("Y-m-d", strtotime("- 2 day"));
        $d1 = date("Y-m-d", strtotime("- 3 day"));

        $m1=SuccessSurvey::whereDate('created_at', '=', $d1)->count();
        $m2=SuccessSurvey::whereDate('created_at', '=', $d2)->count();
        $m3=SuccessSurvey::whereDate('created_at', '=', $d3)->count();
        $m4=SuccessSurvey::whereDate('created_at', '=', $d4)->count();
        $m5=SuccessSurvey::whereDate('created_at', '=', $d5)->count();
        $m6=SuccessSurvey::whereDate('created_at', '=', $d6)->count();
        $m7=SuccessSurvey::whereDate('created_at', '=', $d7)->count();

        return view('survey.index', compact('survey', 'token', 'user_id', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token="admin";

        return view('survey.create', compact('token'));
    }
    
    public function createDetails($id)
    {
        $survey_id=$id;
        $token="admin";

        return view('survey.create-details', compact('survey_id', 'token'));
    }

    public function comment($id)
    {
        $survey_id=$id;
        $token="user";
        $user_id=Auth::id();

        return view('survey.comment', compact('survey_id', 'token', 'user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        Survey::create($request->all());
     
        return redirect()->route('survey.adminIndex')
                        ->with('success','Anket oluşturma tamamlandı.');
    }
     
    public function storeDetails(Request $request)
    {
        $request->validate([
            'soru' => 'required',
            'cevap_bir' => 'required',
            'cevap_iki' => 'required',
            'cevap_uc' => 'required',
            'cevap_dort' => 'required',
            'cevap_bes' => 'required',
            'survey_id' => 'required',
        ]);
    
        SurveyDetails::create($request->all());
     
        return redirect()->route('survey.adminIndex');
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'survey_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required',
        ]);
  
        Comment::create($request->all());
     
        return redirect()->route('survey.index')
                        ->with('success','Yorum oluşturma tamamlandı.');
    }

    public function createAnswer(Request $request, $id)
    {
        $token="user";
        $user=Auth::id();

        $question=SurveyDetails::where('survey_id', $id)->paginate(1);

        return view('answer', compact('question', 'token', 'user'));
    }

    public function saveAnswer(Request $request) {
        $request->validate([
            'survey_id' => 'required',
            'id' => 'required',
            'radio' => 'required',
            'user' => 'required',
        ]);

        $id = $request->input('id');
        $survey_id = $request->input('survey_id');
        $user=Auth::id();
        $token="user";
        $radio=$request->radio;
        $a=Answer::where('user', $user)->where('id', '=', $id)->get()->count();

        $question = DB::table('survey-details')
        ->where('survey_id', '=', $survey_id)
        ->paginate(1);
        
        if($a < 1) {
            Answer::create($request->all());
        } elseif($a == 1) {
            Answer::where('id', '=', $id)
                ->update(['radio' => $radio]);
        }
        return Redirect()->route('survey.createAnswer', $survey_id);
    }

    public function succes(Request $request) {
        SuccessSurvey::create($request->all());
        
        return redirect()->route('survey.index');
    }

    public function succesVisitor(Request $request) {
        SuccessSurvey::create($request->all());
        
        return redirect()->route('login');
    }

    public function createAnswerVisitor(Request $request, $id) {

        $survey_id=$id;

        $question=SurveyDetails::where('survey_id', $survey_id)->paginate(1);
        return view('auth.login', compact('question'));
    }

    public function saveAnswerVisitor(Request $request) {

        $request->validate([
            'survey_id' => 'required',
            'id' => 'required',
            'radio' => 'required',
            'visitor' => 'required',
        ]);

        $id = $request->input('id');
        $survey_id = $request->input('survey_id');
        $visitor = $request->input('visitor');
        $radio = $request->input('radio');
        $saydir=Visitor::where('visitor', $visitor)->where('id', '=', $id)->get()->count();

        $question = DB::table('table_visitor')
        ->where('survey_id', '=', $survey_id)
        ->paginate(1);

        if($saydir < 1) {
            Visitor::create($request->all());
        } elseif($saydir == 1) {
            Visitor::where('id', '=', $id)
                ->update(['radio' => $radio]);
        }

        return Redirect('createAnswerVisitor/'.$survey_id);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $token="admin";
        $survey_id=$id;
        $survey = DB::table('survey')
                ->where('id', $survey_id)
                ->get();
        $question=SurveyDetails::where('survey_id', $survey_id)->get();
        return view('survey.show',compact('survey', 'question', 'token'));
    } 

    public function showVisitor($id)
    {
        $survey_id=$id;
        $survey = DB::table('survey')
                ->where('id', $survey_id)
                ->get();
        $question=SurveyDetails::where('survey_id', $survey_id)->get();
        return view('auth.show-visitor',compact('survey', 'question'));
    } 

    public function userShow($id)
    {
        $token="user";
        $survey_id=$id;
        $survey = DB::table('survey')
                ->where('id', $survey_id)
                ->get();
        $question=SurveyDetails::where('survey_id', $survey_id)->get();
        return view('survey.show',compact('survey', 'question', 'token'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        $token="admin";
        $survey_id=$survey->id;

        $question = DB::table('survey-details')
        ->where('survey_id', '=', $survey_id)
        ->paginate(1);

        return view('survey.edit',compact('survey', 'token', 'question'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $survey->update($request->all());
    
        return redirect()->route('survey.adminIndex')
                        ->with('success','Anket güncelleme tamamlandı.');
    }

    public function editDetails(Request $request, Survey $survey)
    {
        $request->validate([
            'soru' => 'required',
            'cevap_bir' => 'required',
            'cevap_iki' => 'required',
            'cevap_uc' => 'required',
            'cevap_dort' => 'required',
            'cevap_bes' => 'required',
            'id' => 'required',
        ]);

        $id=$request->id;
        $soru=$request->soru;
        $cevap_bir=$request->cevap_bir;
        $cevap_iki=$request->cevap_iki;
        $cevap_uc=$request->cevap_uc;
        $cevap_dort=$request->cevap_dort;
        $cevap_bes=$request->cevap_bes;
    
        $survey->update($request->all());
    
        SurveyDetails::where('id', '=', $id)
        ->update(['soru' => $soru, 'cevap_bir' => $cevap_bir, 'cevap_iki' => $cevap_iki, 'cevap_uc' => $cevap_uc, 'cevap_dort' => $cevap_dort, 'cevap_bes' => $cevap_bes]);

        return redirect()->route('survey.adminIndex')
                        ->with('success','Anket güncelleme tamamlandı.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */

     public function search(Request $request) {
        $name = $request->input('arama');
        $arama_token="arama_var";

        $survey = Survey::latest()->paginate(5);

        $user = Auth::user();
        $user_id = Auth::id();
        $token=$user->type;

        $posts = User::query()
            ->where('name', 'like', "%{$name}%")
            ->orWhere('email', 'like', "%{$name}%")
            ->orderBy('created_at', 'desc')
            ->get();

            if($token == "user") {
                return view('survey.index', compact('posts', 'arama_token', 'token', 'survey', 'user_id'));
            } elseif($token == "admin") {
                return view('datas', compact('posts', 'arama_token', 'token', 'survey', 'user_id'));
            }         
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
    
        return redirect()->route('survey.adminIndex')
                        ->with('success','Anket silme tamamlandı.');
    }
}