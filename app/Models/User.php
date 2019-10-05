<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'birth', 'gender', 'user_name01', 'user_name02', 'image_path', 'show_mail_flg', 'url'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        });
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function report_comments()
    {
        return $this->hasMany(ReportComment::class);
    }

    public function followUsers()
    {
        return $this->belongsToMany(self::class, 'follow_users', 'user_id', 'followed_user_id')
                    ->using(FollowUser::class);
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follow_users', 'followed_user_id', 'user_id')
                    ->using(FollowUser::class);
    }

    public function followReportTags()
    {
        return $this->belongsToMany(ReportTag::class, 'follow_report_tags', 'user_id', 'report_tag_id')
                    ->using(FollowReportTag::class);
    }

    public function followReports()
    {
        return $this->belongsToMany(Report::class, 'follow_reports', 'user_id', 'report_id')
                    ->using(FollowReport::class);
    }
}
