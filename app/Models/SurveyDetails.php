<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class SurveyDetails extends Model
{
    use HasFactory;
  
    protected $table = 'survey-details';

    protected $fillable = [
        'soru', 'cevap_bir', 'cevap_iki', 'cevap_uc', 'cevap_dort', 'cevap_bes', 'survey_id'
    ];
}