<?php

namespace Roshangara\Statusable\Models;

use Illuminate\Database\Eloquent\Model;
use Roshangara\Translatable\Translatable;

class Status extends Model
{
    use Translatable;

    protected $table = 'statuses';

    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'color'];

    public function scopeStatus($query, int $status)
    {
        return $query->where('statusable_status.status_id', $status);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('statusable_status.id', 'desc');
    }
}