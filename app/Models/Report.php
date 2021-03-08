<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ReportType;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    public function reportType()
    {
        return $this->hasOne(ReportType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
