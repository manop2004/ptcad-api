<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'tb_document';

    protected $fillable = [
        'document_title',
        'document_file',
        'document_order',
        'document_show',
        'created_by',
        'updated_by',
    ];
}