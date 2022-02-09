<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  protected $fillable = [
    'name', 'phone', 'email',
  ];

  public function users()
  {
    return $this->belongsToMany(User::class)
      ->with('roles', 'sites');
  }

  public function values()
  {
    return $this->hasMany(Value::class);
  }

  public function login_questions()
  {
    return $this->hasMany(LoginQuestion::class)->with('user_login_questions');
  }

  public function settings()
  {
    return $this->hasMany(Setting::class);
  }
}
