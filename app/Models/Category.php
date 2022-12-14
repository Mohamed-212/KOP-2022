<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name_ar', 'name_en', 'image', 'description_ar', 'description_en', 'dough_type_id', 'dough_type_2_id', 'cat_branches'];
    protected $hidden = ["dough_type_id", 'dough_type_2_id'];

    public $appends = ['is_hidden'];

    public function getIsHiddenAttribute()
    {
        if (!request()->has('branch_id')) {
            return false;
        }

        return $this->isHiddenByBranch(request('branch_id', 0));
    }

    public function isHiddenByBranch($branchId)
    {
        if (empty($this->cat_branches)) {
            return false;
        }

        $branches = explode(',', $this->cat_branches);
        
        if (in_array(request('branch_id', 0), $branches)) {
            return true;
        }

        return false;
    }

    public function getWebsiteIsHiddenAttribute()
    {
        if (!session()->has('branch_id') && !session()->has('address_branch_id')) return false;

        if (empty($this->cat_branches)) {
            return false;
        }

        $branchID = session('address_branch_id') ?? session('branch_id') ?? 0;

        $branches = explode(',', $this->cat_branches);
        
        if (in_array($branchID, $branches)) {
            return true;
        }

        return false;
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function extras()
    {
        return $this->hasMany('App\Models\Extra');
    }

    public function doughTypes()
    {
        return $this->hasMany('App\Models\DoughType');
    }

    public function withouts()
    {
        return $this->hasMany('App\Models\Without');
    }

    public function getImageAttribute($value)
    {
        if (!empty($value) && file_exists(public_path($value))) {
            return url($value);
        } else {
            return 'http://via.placeholder.com/200x200?text=No+Image';
        }
    }
}
