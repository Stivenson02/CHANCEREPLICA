<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class PaidUser extends Model {

    public function users() {
        return $this->belongsTo(User::class);
    }

}
