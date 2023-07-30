<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UtilHelper;

class Employee extends Model
{
    protected $table='employees';
    protected $fillable = [
        'name','department_id','gender_id','record_no','certification_id','job_no','ministry_date','department_date','specialization_id','job_title_id','employee_type_id',
    ];

    const FOLDER = 'employees';
    const PAGE = 'employee';

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    public function certification()
    {
        return $this->belongsTo('App\Models\Certification', 'certification_id');
    }

    public function specialization()
    {
        return $this->belongsTo('App\Models\Specialization', 'specialization_id');
    }

    public function job_title()
    {
        return $this->belongsTo('App\Models\JobTitle', 'job_title_id');
    }

    public function job_level()
    {
        return $this->belongsTo('App\Models\JobLevel', 'job_level_id');
    }

    public function job_class()
    {
        return $this->belongsTo('App\Models\JobClass', 'job_class_id');
    }

    public function job_rank()
    {
        return $this->belongsTo('App\Models\JobRank', 'job_rank_id');
    }


    public function scopeDetails($query){
      return $query->with([
        'user',
        'gender',
        'certification',
        'specialization:id,title',
        'job_title',
        'job_level',
        'job_class',
        'job_rank'
      ]);
    }


    // employee types
    public function scopeOfType($query,$employee_type_id){
        return $query->where('employee_type_id',$employee_type_id);
    }


    // public function setministry_dateAttribute( $value ) {
    //   $this->attributes['ministry_date'] = ($value);
    // }

    public function getMinistryDate()
    {
        return UtilHelper::DateToShow($this->attributes['ministry_date']);
    }

    public function getDepartmentDate()
    {
        return UtilHelper::DateToShow($this->attributes['department_date']);
    }



    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function isActive($value)
    {
        return $this->is_active == $value;
    }


    public function imagePath()
    {
        return asset('storage/app/'.$this->image);
    }
}
