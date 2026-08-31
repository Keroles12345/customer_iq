<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class Customers extends Model
{
    /** @use HasFactory<\Database\Factories\CustomersFactory> */
    use HasFactory;
    protected $table='customers';
    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'customer_id');
    }
}
