<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use App\Traits\Actived\ActiveTrait;
use App\Models\FaqCategory\FaqCategory;

class Faq extends Model
{
    use HasFactory, HasUuid, ActiveTrait;

    protected $table = 'faqs';

    protected $fillable = [
        'uuid',
        'question',
        'answer',
        'active',
        'category_id'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
