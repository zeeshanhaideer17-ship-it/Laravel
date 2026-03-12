<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Complaint;
use App\Models\User;

class Assignment extends Model
{
    protected $primaryKey = 'assignment_id';
    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'agent_id',
        'assigned_by',
        'assigned_at'
    ];



public function complaint()
{
    return $this->belongsTo(Complaint::class, 'complaint_id');
}

public function agent()
{
    return $this->belongsTo(User::class, 'agent_id');
}
}