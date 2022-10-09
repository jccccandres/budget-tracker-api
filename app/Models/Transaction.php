<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'category_id',
        'note',
        'amount',
        'date_transact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getTransactionMonths()
    {
        // return Transaction::select("id", DB::raw("(SUM(id)) AS total_count"), DB::raw("(DATE_FORMAT(date_transact, '%m-%Y')) AS month_year"))
        //                 ->orderBy('date_transact')
        //                 ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
        //                 ->get();
        
        $response_data = [
            "data" => Transaction::select(
                                DB::raw("(to_char(cast(date_transact as date), 'Mon yyyy')) AS monthYear"),
                                DB::raw("(to_char(cast(date_transact as date), 'yyyy-MM-01')) AS dateTransact")
                            )
                            ->groupBy(
                                DB::raw("to_char(cast(date_transact as date), 'Mon yyyy')"), 
                                DB::raw("to_char(cast(date_transact as date), 'yyyy-MM-01')")
                            )
                            ->orderBy(DB::raw("to_char(cast(date_transact as date), 'Mon yyyy')"), 'DESC')
                            ->get()
        ];

        return response()->json($response_data);
    }
}
