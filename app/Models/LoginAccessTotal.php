<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginAccessTotal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'year_id', 'total'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_access_total';


    public function client()
    {
        return $this->belongsTo(Client::class, 'content_id', 'id');
    }



    public static function createAccessLog($clientId, $yearId)
    {
        $postViews = new LoginAccessTotal();
        $postViews->client_id = $clientId;
        $postViews->year_id = 1;
        $postViews->total = 0;
        $postViews->save();
    }



}
