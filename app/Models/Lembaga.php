<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $table = 'lembaga';

    protected $fillable = [
        'name',
        'industry',
        'phone',
        'email',
        'address',
    ];

    /**
     * Relasi ke model Employee (satu lembaga bisa punya banyak employee).
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
