<?php  namespace App\Filters;

class CustomerFilter extends QueryFilter
{
    public function search($value=null) {
        if ($value){
            return $this->builder->where(function($q) use($value){
                $q->where('name', "LIKE", "%$value%")
                ->orWhere('first_name', "LIKE", "%$value%")
                ->orWhere('last_name', "LIKE", "%$value%");
            });
        }
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
