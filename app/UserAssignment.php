<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAssignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_assignments';

    protected $fillable = [
        'name',
        'college_name',
        'department_name',
        'course_name',
        'description',
        'page_number',
        'collage_name',
        'assignment_file_name',
        'instructor_assignment_file_name',
        'is_for_dashboard',
        'is_admin',
        'assigned_user_id',
        'instructor_amount',
        'pdf_images'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assinged_user_id', 'id');
    }
}
