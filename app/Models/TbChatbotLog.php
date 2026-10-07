<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbChatbotLog extends Model
{
    protected $table = 'tb_chatbot_log';
    public $timestamps = false;
    protected $fillable = ['qna_id', 'session_id', 'created_at'];
}