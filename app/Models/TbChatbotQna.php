<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbChatbotQna extends Model
{
    protected $table = 'tb_chatbot_qna';
    protected $fillable = [
        'parent_id', 'question', 'answer', 'answer_type',
        'link_url', 'link_label', 'sort_order', 'is_active',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }
}