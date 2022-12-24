<?php  namespace App\Filters;

class OrderFilters extends QueryFilter
{
    public function state($value = null) {
		if ($value != null and $value !='all')
	        return $this->builder->where('state', $value);

    }

    public function customer($value = null) {
    	if ($value)
	        return $this->builder->where('customer_id', $value);
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
