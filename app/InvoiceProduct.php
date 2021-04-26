<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    //recheck
    protected $fillable = [
        'name', 'qty', 'price', 'total'
    ];

    public function invoice()
    {

        return $this->belongsTo(bill::class);
    }
}
