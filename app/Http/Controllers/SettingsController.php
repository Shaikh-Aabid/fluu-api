<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all Setting
       *
     *@
     */
    public function index(Request $request)
    {
        $settings = $request->site->settings()->get();

        return response()->json([
            'data'     =>  $settings
        ], 200);
    }

    /*
     * To store a new Setting
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_1_title'    =>  'required',
        ]);
        $setting = new Setting($request->all());
        $request->site->settings()->save($setting);

        return response()->json([
            'data'    =>  $setting
        ], 201);
    }

    /*
     * To view a single Setting
     *
     *@
     */
    public function show(Setting $setting)
    {
        return response()->json([
            'data'   =>  $setting,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a Setting
     *
     *@
     */
    public function update(Request $request, Setting $setting)
    {

        $setting->update($request->all());

        return response()->json([
            'data'  =>  $setting
        ], 200);
    }

    public function destroy($id)
    {
        $setting = Setting::find($id);
        $setting->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
