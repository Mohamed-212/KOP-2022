<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Api\FrontController;
use App\Models\Careers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CareersControllers extends Controller
{

    public function AllJobs()
    {
        $return = (app(FrontController::class)->getAllJobs())->getOriginalContent();
        foreach ($return as $in => $re) {
            if ($in == 'data') {
            $jobs = $re;
            foreach ($jobs as $job) {
                $responsibilities_ar_my_string = preg_replace('/\r\n/', '#PH#', $job->responsibilities_ar);
                $job->arr_responsibilities_ar = explode('#PH#', $responsibilities_ar_my_string);
                $responsibilities_en_my_string = preg_replace('/\r\n/', '#PH#', $job->responsibilities_en);
                $job->arr_responsibilities_en = explode('#PH#', $responsibilities_en_my_string);

                $description_ar_my_string = preg_replace('/\r\n/', '#PH#', $job->description_ar);
                $job->arr_description_ar = explode('#PH#', $description_ar_my_string);
                $description_en_my_string = preg_replace('/\r\n/', '#PH#', $job->description_en);
                $job->arr_description_en = explode('#PH#', $responsibilities_en_my_string);

            }
            // return $jobs;
                return view('website.page-careers', compact(['jobs']));
            }
        }
    }

    public function GetJob($id)
    {
        $return = (app(FrontController::class)->GetJob($id))->getOriginalContent();
        foreach ($return as $in => $re) {
            if ($in == 'data') {
                $job = $re;

                $responsibilities_ar_my_string = preg_replace('/\r\n/', '#PH#', $job->responsibilities_ar);
                $arr_responsibilities_ar = explode('#PH#', $responsibilities_ar_my_string);
                $responsibilities_en_my_string = preg_replace('/\r\n/', '#PH#', $job->responsibilities_en);
                $arr_responsibilities_en = explode('#PH#', $responsibilities_en_my_string);

                $description_ar_my_string = preg_replace('/\r\n/', '#PH#', $job->description_ar);
                $arr_description_ar = explode('#PH#', $description_ar_my_string);
                $description_en_my_string = preg_replace('/\r\n/', '#PH#', $job->description_en);
                $arr_description_en = explode('#PH#', $responsibilities_en_my_string);

                return view('website.page-career', compact(['job', 'arr_responsibilities_ar', 'arr_responsibilities_en', 'arr_description_ar', 'arr_description_en']));
            }
        }
    }

    public function ApplyJobForm($id)
    {
        $return = (app(FrontController::class)->GetJob($id))->getOriginalContent();
        foreach ($return as $in => $re) {
            if ($in == 'data') {
                $job = $re;
                return view('website.page-career-form', compact(['job']));
            }
        }
    }

    public function CareerRequest(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:12',
            'job_id' => 'required',
            'description' => 'required',
            'cv_file' => 'required|mimes:pdf',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();

        }
        $return = (app(FrontController::class)->jobRequest($request, $request->job_id))->getOriginalContent();
        $temp = '';
         foreach ($return as $in => $re) {

            if ($in == 'success') {
                 return redirect()->route('careers.all')->with(['success' => __('general.your application been submitted')]);

            }
            else {
                return redirect()->back()->with(['error' => __('general.Something Went Wrong')])->withInput();

            }

        }
    }
}
