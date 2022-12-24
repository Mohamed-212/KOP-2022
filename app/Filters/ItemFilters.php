<?php  namespace App\Filters;

class ItemFilters extends QueryFilter
{
    public function category($value = null) {
        if ($value != null and $value !='all')
            return $this->builder->where('category_id', $value);
    }

    public function branch($value = null) {
        if ($value != null and $value !='all')
            return $this->builder->where('branch_id', $value);
    }

    public function from($value = null){
        if ($value)
            return $this->builder->whereDate('created_at', '>=', $value);
    }

    public function to($value = null){
        if ($value)
            return $this->builder->whereDate('created_at', '<=', $value);
    }
}
