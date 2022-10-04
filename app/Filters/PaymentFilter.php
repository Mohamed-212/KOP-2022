<?php  namespace App\Filters;

class PaymentFilter extends QueryFilter
{
    public function search($value=null) {
        if ($value)
            return $this->builder->where('order_id', "LIKE", "%$value%")
                ->orWhere('payment_id', "LIKE", "%$value%")
                ->orWhere('customer_id', "LIKE", "%$value%");
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
