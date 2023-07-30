<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionTranaction extends Model
{
    const PAGE = 'commission';
    const FILE_FOLDER = 'commission';

    protected $table = 'commission_transactions';
    protected $fillable = [
        'user_id', 'bank_name', 'date', 'name',"note","status","image","amount",
    ];
    protected $hidden = [
        'updated_at',
    ];
}
