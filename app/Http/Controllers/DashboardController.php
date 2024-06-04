<?php

namespace App\Http\Controllers;

use App\Payment;
use App\User;
use App\UserAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        $title = __t('dashboard');

        $user = Auth::user();

        $chartData = null;
        if ($user->isInstructor) {
            /**
             * Format Date Name
             */
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');

            $begin = new \DateTime($start_date);
            $end = new \DateTime($end_date.' + 1 day');
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            $datesPeriod = [];
            foreach ($period as $dt) {
                $datesPeriod[$dt->format('Y-m-d')] = 0;
            }

            /**
             * Query This Month
             */
            $sql = "SELECT SUM(instructor_amount) as total_earning,
              DATE(created_at) as date_format
              from earnings
              WHERE instructor_id = {$user->id} AND payment_status = 'success'
              AND (created_at BETWEEN '{$start_date}' AND '{$end_date}')
              GROUP BY date_format
              ORDER BY created_at ASC ;";
            $getEarnings = DB::select($sql);

            $total_earning = array_pluck($getEarnings, 'total_earning');
            $queried_date = array_pluck($getEarnings, 'date_format');

            $dateWiseSales = array_combine($queried_date, $total_earning);

            $chartData = array_merge($datesPeriod, $dateWiseSales);
            foreach ($chartData as $key => $salesCount) {
                unset($chartData[$key]);
                //$formatDate = date('d M', strtotime($key));
                $formatDate = date('d', strtotime($key));
                $chartData[$formatDate] = $salesCount;
            }
        }

        return view(theme('dashboard.dashboard'), compact('title', 'chartData'));
    }

    public function profileSettings()
    {
        $title = __t('profile_settings');

        return view(theme('dashboard.settings.profile'), compact('title'));
    }

    public function profileSettingsPost(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'job_title' => 'max:220',
        ];
        $this->validate($request, $rules);

        $input = array_except($request->input(), ['_token', 'social']);
        $user = Auth::user();
        $user->update($input);
        $user->update_option('social', $request->social);

        return back()->with('success', __t('success'));
    }

    public function resetPassword()
    {
        $title = __t('reset_password');

        return view(theme('dashboard.settings.reset_password'), compact('title'));
    }

    public function resetPasswordPost(Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = clean_html($request->old_password);
        $new_password = clean_html($request->new_password);

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();

                return redirect()->back()->with('success', __t('password_changed_msg'));
            }

            return redirect()->back()->with('error', __t('wrong_old_password'));
        }
    }

    public function enrolledCourses()
    {
        $title = __t('enrolled_courses');

        return view(theme('dashboard.enrolled_courses'), compact('title'));
    }

    public function myReviews()
    {
        $title = __t('my_reviews');

        return view(theme('dashboard.my_reviews'), compact('title'));
    }

    public function wishlist()
    {
        $title = __t('wishlist');

        return view(theme('dashboard.wishlist'), compact('title'));
    }

    public function purchaseHistory()
    {
        $title = __t('purchase_history');

        return view(theme('dashboard.purchase_history'), compact('title'));
    }

    public function purchaseView($id)
    {
        $title = __a('purchase_view');
        $payment = Payment::find($id);

        return view(theme('dashboard.purchase_view'), compact('title', 'payment'));
    }

    public function listAssignmentView(Request $request)
    {
        $assignments = UserAssignment::all()->toArray();
        return view(theme('dashboard.assignment_view'), compact('assignments'));
    }

    public function assignmentRegisterView(Request $request)
    {
        return view(theme('dashboard.assignment_register_view'));
    }
    public function assignAssignmentView($id)
    {
        $users = User::where('user_type', 'instructor')->get();
        $assignment = UserAssignment::where('id', $id)->first();
        return view(theme('dashboard.admin_assignment_assign_view'), compact('assignment', 'users'));
    }
    public function assignAssignmentInstructor(Request $request, $id)
    {
        UserAssignment::where('id', $id)->update(['assinged_user_id' => $request->select_option]);
        $assignments = UserAssignment::all()->toArray();
        return view(theme('dashboard.assignment_view'), compact('assignments'));
    }

    public function approvePayment(Request $request)
    {
        UserAssignment::where('id', $request->aId)
                        ->where('assinged_user_id',$request->iId)
                        ->update(['status' => 1]);
        return response()->json(['success'=>'Payment approved']);
    }

    public function registerAssignment(Request $request)
    {
        if ($request->hasFile('assignments')) {
            
            $file = $request->file('assignments');
            $directory = public_path('uploads/studentsAssignments');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }
             
            $fileName = time().'_'.$request->name.'.'.$file->getClientOriginalExtension();
            $file->move($directory, $fileName);

            UserAssignment::create([
                'name' => $request->name,
                'collage_name'  => $request->colgname,
                'department_name'  => $request->depname,
                'course_name'  => $request->crsname,
                'description'  => $request->desc,
                'page_number'  => $request->pagenum,
                'assignment_files_name'  => $fileName,
                'is_admin'  => 1
            ]);

            return redirect()->back()->with('success', __a('settings_saved_msg'));
        }
    }


    // public function uploadAssignment(Request $request)
    // {
    //     if (Auth::check()) {
    //         $userId = Auth::id();
    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $fileName = time().'.'.$file->getClientOriginalExtension();

    //             $directory = public_path('uploads/assignments');
    //             if (!File::isDirectory($directory)) {
    //                 File::makeDirectory($directory, 0755, true, true);
    //             }

    //             $file->move($directory, $fileName);

    //             assignment::create([
    //                 'file_name' => $fileName,
    //                 'user_id' => $userId,
    //             ]);

    //             return response()->json(['success'=>'File uploaded successfully.']);
    //         } else {
    //             return response()->json(['error'=>'No file uploaded.']);
    //         }
    //     }
    // }
}
