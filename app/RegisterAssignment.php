<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterAssignment extends Model
{
    protected $guarded = [];

    /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'register_assignment';

  protected $fillable = [
        'name',
        'collage_name',
        'department_name',
        'course_name',
        'description',
        'page_number',
        'assignment_files_name'
    ];
}
