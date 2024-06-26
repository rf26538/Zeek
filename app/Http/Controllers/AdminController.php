<?php

namespace App\Http\Controllers;

use App\Course;
use App\Withdraw;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\UserAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Spatie\PdfToImage\Pdf;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Exception
     *
     * Landing page of dashboard
     */
    public function index()
    {
        $title = __a('dashboard');

        /**
         * Format Date Name
         */
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');

        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date . ' + 1 day');
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        $datesPeriod = [];
        foreach ($period as $dt) {
            $datesPeriod[$dt->format('Y-m-d')] = 0;
        }

        /**
         * Query This Month
         */
        $sql = "SELECT SUM(total_amount) as total_amount,
              DATE(created_at) as date_format
              from payments
              WHERE status = 'success'
              AND (created_at BETWEEN '{$start_date}' AND '{$end_date}')
              GROUP BY date_format
              ORDER BY created_at ASC ;";
        $getEarnings = DB::select($sql);

        $total_amount = array_pluck($getEarnings, 'total_amount');
        $queried_date = array_pluck($getEarnings, 'date_format');

        $dateWiseSales = array_combine($queried_date, $total_amount);

        $chartData = array_merge($datesPeriod, $dateWiseSales);
        foreach ($chartData as $key => $salesCount) {
            unset($chartData[$key]);

            $formatDate = date('d M', strtotime($key));
            //$formatDate = date('d', strtotime($key));
            $chartData[$formatDate] = $salesCount ? $salesCount : 0;
        }

        $extendCTRL = new ExtendController();
        $extended_products = (array) $extendCTRL->extended_products();
        $extended_plugins = array_get($extended_products, 'plugin');

        return view('admin.dashboard', compact('title', 'chartData', 'extended_plugins'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * Show all courses to the admin.
     */
    public function adminCourses(Request $request)
    {
        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

        if ($request->bulk_action_btn) {
            if (config('app.is_demo')) {
                return back()->with('error', __a('demo_restriction'));
            }
        }

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];

            if ($request->status == 1) {
                $data['published_at'] = $now;
            }

            Course::whereIn('id', $ids)->update($data);

            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'mark_as_popular' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_popular' => 1, 'popular_added_at' => $now]);

            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'mark_as_feature' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_featured' => 1, 'featured_at' => $now]);

            return back()->with('success', __a('bulk_action_success'));
        }

        if ($request->bulk_action_btn === 'remove_from_popular' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_popular' => null, 'popular_added_at' => null]);

            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'remove_from_feature' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_featured' => null, 'featured_at' => null]);

            return back()->with('success', __a('bulk_action_success'));
        }

        //Delete
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                Course::find($id)->delete_and_sync();
            }

            return back()->with('success', __a('bulk_action_success'));
        }

        $title = __a('courses');
        $courses = Course::query()->where('status', '>', 0);
        if ($request->filter_status) {
            $courses = $courses->whereStatus($request->filter_status);
        }
        if ($request->q) {
            $courses = $courses->where('title', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter_by === 'popular') {
            $courses = $courses->where('is_popular', 1);
            $courses = $courses->orderBy('popular_added_at', 'desc');
        } elseif ($request->filter_by === 'featured') {
            $courses = $courses->where('is_featured', 1);
            $courses = $courses->orderBy('featured_at', 'desc');
        } else {
            $courses = $courses->orderBy('last_updated_at', 'desc');
        }
        $courses = $courses->paginate(20);

        return view('admin.courses.courses', compact('title', 'courses'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * Withdraw requests
     */
    public function withdrawsRequests(Request $request)
    {
        if ($request->bulk_action_btn) {
            if (config('app.is_demo')) {
                return back()->with('error', __a('demo_restriction'));
            }
        }

        if ($request->bulk_action_btn === 'update_status' && $request->update_status) {
            Withdraw::whereIn('id', $request->bulk_ids)->update(['status' => $request->update_status]);

            return back();
        }
        if ($request->bulk_action_btn === 'delete') {
            Withdraw::whereIn('id', $request->bulk_ids)->delete();

            return back();
        }

        $title = __a('withdraws');
        $withdraws = Withdraw::query();

        if ($request->status) {
            if ($request->status !== 'all') {
                $withdraws = $withdraws->where('status', $request->status);
            }
        } else {
            $withdraws = $withdraws->where('status', 'pending');
        }

        $withdraws = $withdraws->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.withdraws', compact('title', 'withdraws'));
    }
    public function adminAssignment(Request $request)
    {
        $title = __a('create_assignment');
        return view('admin.assignment', compact('title'));
    }
    public function adminAssignmentView(Request $request)
    {
        $status = '';
        $q = '';
        $q1 = '';
        $q2 = '';
        $user = Auth::user();

        $res = UserAssignment::query();

        if ($request->has('q') && !empty($request->input('q'))) {
            $r = $request->input('q');
            $res->where('collage_name', 'like', '%' . $r . '%');
        }

        if ($request->has('q1') && !empty($request->input('q1'))) {
            $r1 = $request->input('q1');
            $res->where('department_name', 'like', '%' . $r1 . '%');
        }

        if ($request->has('q2') && !empty($request->input('q2'))) {
            $r2 = $request->input('q2');
            $res->where('course_name', 'like', '%' . $r2 . '%');
        }

        if ($request->has('status')) {
            $status = $request->input('status');

            if($status != 'all') {
                $res->where('status', '=', $status);
            }
        }

        $assignments = $res->orderBy('created_at', 'desc')->paginate(10);
        $title = __a('assignment_info');

        return view('admin.list_assignment', compact('assignments', 'status', 'q', 'q1', 'q2', 'title'));
    }

    public function editAssigment($id)
    {
        $assignment = UserAssignment::with('user')->find($id);
        $users = User::where('user_type', 'instructor')->get();
        $title = __a('assignment_list');

        return view('admin.assigmentedit', compact('assignment', 'users', 'title'));
    }

    public function deleteAssigment($id)
    {
        // Find the assignment by its ID
        $assignment = UserAssignment::find($id);

        // Check if the assignment exists
        if ($assignment) {
            // Delete the assignment
            $assignment->delete();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Assignment deleted successfully.');
        } else {
            // Redirect back with an error message if the assignment does not exist
            return redirect()->back()->with('error', 'Assignment not found.');
        }
    }

    public function assigmentUpdateShow(Request $request)
    {
        UserAssignment::where('id', $request->id)
            ->update(['is_for_dashboard' => $request->isChecked]);

        return response()->json(['success' => __a('status_updated_success')]);
    }


    public function adminAssignmentSubmit(Request $request)
    {
        $rules = [
            'name' => 'required',
            'colgname' => 'required',
            'depname' => 'required',
            'crsname' => 'required',
            'desc' => 'required',
            'pagenum' => 'required|numeric',
            'assignments' => 'required|file|mimes:pdf',
        ];

        $messages = [
            'name.required' => 'Please enter Title/Name',
            'colgname.required' => 'Please enter School/College Name',
            'depname.required' => 'Please enter Department Name',
            'crsname.required' => 'Please enter Course Name',
            'desc.required' => 'Please enter Description',
            'pagenum.required' => 'Please enter Page Number',
            'pagenum.numeric' => 'Page Number should only be numbers.',
            'assignments.required' => 'Please select a file',
            'assignments.file' => 'Please upload a valid file.',
            'assignments.mimes' => 'Only PDF files are allowed.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('assignments')) {
            $file = $request->file('assignments');
            $directory = public_path('uploads/studentsAssignments');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            $fileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);

            $pdfPath = $directory . '/' . $fileName; // Define $pdfPath here

            $pdf = new Pdf($pdfPath);
            $imageNames = [];

            // Determine the number of pages in the PDF
            $totalPages = $pdf->getNumberOfPages();
            $maxPages = min($totalPages, 3); // Convert maximum of 3 pages or total available pages

            // Convert each page (up to $maxPages)
            for ($page = 1; $page <= $maxPages; $page++) {
                $outputImagePath = $directory . '/' . time() . '_' . $request->name . '_page' . $page . '.png';
                $pdf->setPage($page)
                    ->saveImage($outputImagePath);
                if (file_exists($outputImagePath)) {
                    $imageNames[] = basename($outputImagePath);
                }
            }

            $user = Auth::user();

            if ($user) {
                $userAssignment = new UserAssignment([
                    'name' => $request->name,
                    'collage_name' => $request->colgname,
                    'department_name' => $request->depname,
                    'course_name' => $request->crsname,
                    'description' => $request->desc,
                    'page_number' => $request->pagenum,
                    'assignment_file_name' => $fileName,
                    'pdf_images' => implode(',', $imageNames),
                    'is_for_dashboard' => 1,
                    'is_admin' => 1
                ]);
                $userAssignment->user_id = $user->id;
                $userAssignment->save();
                return redirect()->back()->with('success', 'Assignment uploaded successfully');
            } else {
                return redirect()->back()->with('error', 'User not authenticated');
            }
        }
    }

    public function adminAssignmentUpdate(Request $request)
    {

        $rules = [
            'amount' => 'integer',
            'instamount' => 'integer',
        ];

        $messages = [
            'amount.required' => 'Please enter an amount',
            'amount.integer' => 'The amount must be an integer',
            'instamount.integer' => 'The amount must be an integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateArr = [
            'amount' => $request->amount,
            'instructor_amount' => $request->instamount
        ];

        if ($request->has('assinged_user_id')) {
            $updateArr['assinged_user_id'] = $request->assinged_user_id;
        }

        if (!empty($request->instructorAssignment)) {
            $updateArr['status'] = 2;
        } else {
            $updateArr['status'] = 1;
        }

        UserAssignment::where('id', $request->id)->update($updateArr);

        return redirect()->route('admin_assignment_view')->with('success', 'Instructor assigned successfully');
    }
    public function updateInstructorStatus(Request $request)
    {
        User::where('id', $request->id)
            ->update(['is_for_dashboard' => $request->isChecked]);

        return response()->json(['success' => __a('status_updated_success')]);
    }
}
