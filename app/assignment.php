<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignment';

    protected $fillable = ['file_name'];
}
