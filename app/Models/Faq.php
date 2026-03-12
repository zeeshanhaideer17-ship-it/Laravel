<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use App\Models\User;

class Faq extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'faq_id';

    protected $fillable = [
        'question',
        'answer',
        'created_by'
    ];

public function admin()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
