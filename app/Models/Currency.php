<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'code'];

    // CREATE
    public static function insertCurrency(array $data)
    {
        // Mass assignment to create a new currency
        return self::create($data);
    }

    // READ - all currencies with pagination
    public static function fetchCurrencies(int $perPage = 10)
    {
        return self::latest()->paginate($perPage);
    }

    // READ - single currency by id
    public static function fetchCurrencyById(int $id)
    {
        return self::findOrFail($id);
    }

    // UPDATE
    public function updateCurrency(array $data)
    {
        return $this->update($data);
    }
    // DELETE
    public function deleteCurrency()
    {
        return $this->delete();
    }
}
