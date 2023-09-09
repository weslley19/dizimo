<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cargo_id'];

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }
}
