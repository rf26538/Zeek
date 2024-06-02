<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    
    protected $guarded = [];

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banner';

    protected $fillable = ['file_name'];
}
