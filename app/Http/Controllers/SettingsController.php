<?php

namespace App\Http\Controllers;

use App\Option;
use App\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function GeneralSettings()
    {
        $title = trans('admin.general_settings');

        return view('admin.settings.general_settings', compact('title'));
    }

    public function LMSSettings()
    {
        $title = trans('admin.lms_settings');

        return view('admin.settings.lms_settings', compact('title'));
    }

    public function StorageSettings()
    {
        $title = trans('admin.file_storage_settings');

        return view('admin.settings.storage_settings', compact('title'));
    }

    public function ThemeSettings()
    {
        $title = trans('admin.theme_settings');

        return view('admin.settings.theme_settings', compact('title'));
    }

    public function invoiceSettings()
    {
        $title = trans('admin.invoice_settings');

        return view('admin.settings.invoice_settings', compact('title'));
    }

    public function modernThemeSettings()
    {
        $title = trans('admin.modern_theme_settings');

        return view('admin.settings.modern_theme_settings', compact('title'));
    }

    public function SocialUrlSettings()
    {
        $title = trans('admin.social_url_settings');

        return view('admin.settings.social_url_settings', compact('title'));
    }

    public function SocialSettings()
    {
        $title = __a('social_login_settings');

        return view('admin.settings.social_settings', compact('title'));
    }

    public function BlogSettings()
    {
        $title = trans('admin.blog_settings');

        return view('admin.settings.blog_settings', compact('title'));
    }

    public function withdraw()
    {
        $title = trans('admin.withdraw');

        return view('admin.settings.withdraw_settings', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $inputs = array_except($request->input(), ['_token']);

        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                $value = 'json_encode_value_'.json_encode($value);
            }

            $option = Option::firstOrCreate(['option_key' => $key]);
            $option->option_value = $value;
            $option->save();
        }
        //check is request comes via ajax?
        if ($request->ajax()) {
            return ['success' => 1, 'msg' => __a('settings_saved_msg')];
        }

        return redirect()->back()->with('success', __a('settings_saved_msg'));
    }

    public function bannerSetting(Request $request){
        $title = trans('admin.banner_settings');
        $files = banner::all();

        return view('admin.settings.banner_settings', compact('title', 'files'));
    }

    public function deleteBanner(Request $request){
        $banner = banner::find($request->id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found.'], 404);
        }

        $banner->delete();

        return response()->json(['success' => 'Banner deleted successfully.']);
    }

    public function uploadBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_file' => 'required|array',
            'banner_file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ], [
            'banner_file.*.required' => 'Please select a file for each banner.',
            'banner_file.*.image' => 'The file must be an image.',
            'banner_file.*.mimes' => 'Only JPEG, PNG, JPG, and GIF images are allowed.',
            'banner_file.*.max' => 'Each image must not be larger than 2MB.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
    
        if ($request->hasFile('banner_file')) {
            $directory = public_path('uploads/banner');
            
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            foreach ($request->file('banner_file') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move($directory, $fileName);
                $option = new Banner();
                $option->file_name = $fileName;
                $option->save();
            }
        }

        return redirect()->back()->with('success', __('settings_saved_msg'));
    }
}
