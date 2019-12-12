<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'family_name',
        'email',
        'phone',
        'average_salary',
        'gender',
        'birth_date',
    ];

    protected $appends = [
        'full_name',
        'age',
    ];

    public function getFullNameAttribute()
    {
        return trim($this->name) . ' ' . trim($this->family_name);
    }

    public function getAgeAttribute()
    {
        try {
            return Carbon::parse($this->birth_date)->age;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function chartData()
    {
        return self::all(['birth_date', 'gender', 'average_salary'])->makeHidden('full_name');
    }
}
