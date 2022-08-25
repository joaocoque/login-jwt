<?php

namespace App\Models\FaqCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faq\Faq;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use App\Traits\Actived\ActiveTrait;


class FaqCategory extends Model
{
    use HasFactory, HasUuid, ActiveTrait;

    protected $table = 'faqs_categories';

    protected $fillable = [
        'uuid',
        'title',
        'icon',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_id');
    }
}
