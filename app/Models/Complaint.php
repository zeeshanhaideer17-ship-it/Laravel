<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $primaryKey = 'complaint_id';

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'category',
        'priority',
        'status'
    ];
}
