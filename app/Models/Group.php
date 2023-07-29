<?php

namespace App\Models;

use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_manager')->withTimestamps();
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }
}
