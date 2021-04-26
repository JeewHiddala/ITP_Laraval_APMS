<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill extends Model
{
    protected $fillable = [
        'invoice_no', 'invoice_date', 'due_date', 'title', 'client', 'client_address',
        'sub_total','discount', 'grand_total'
    ];

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
