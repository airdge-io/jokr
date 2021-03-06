<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FAQ extends Model
{
    use SoftDeletes;

    protected $table = 'faqs';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'question'    => 'required|min:3:max:255',
        'answer'      => 'required|min:5:max:1500',
        'category_id' => 'required|exists:faq_categories,id',
    ];

    protected function getSlugOptions()
    {
        return Str::slug($this->question);
    }

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getAnswerSummaryAttribute()
    {
        return substr(strip_tags($this->attributes['answer']), 0, 80) . '...';
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id', 'id');
    }
}