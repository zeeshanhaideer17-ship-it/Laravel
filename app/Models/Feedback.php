<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use App\Models\Complaint;
use App\Models\User;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'feedback_id';
    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'customer_id',
        'rating',
        'comment',
        'feedback_date'
    ];


   
public function complaint()
{
    return $this->belongsTo(Complaint::class, 'complaint_id');
}

public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

}
