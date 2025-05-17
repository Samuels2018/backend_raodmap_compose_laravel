<?php

namespace App\Models\image;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'original_path',
    'filename',
    'mime_type',
    'size',
    'transformations'
  ];

  protected $casts = [
    'transformations' => 'array',
  ];

  public function user () {
    return $this->belongsTo(User::class);
  }

  public function getUrlAttribute () {
    return Storage::disk('s3')->url($this->original_path);
  }
}
