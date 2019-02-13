<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountList extends Model
{
    protected $table = 'accountLists';
    protected $fillable = ['name', 'memo', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
