<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sendgrid_id',
        'sendgrid_contact_count',
        'sendgrid_metadata',
    ];

    public function email()
    {
        return $this->belongsToMany(Email::class);
    }

    public function singleSend()
    {
        return $this->belongsToMany(SingleSend::class,'single_send_lists');
    }

    public function campaign()
    {
        $this->belongsToMany(Campaign::class, 'campaign_list');
    }
}
