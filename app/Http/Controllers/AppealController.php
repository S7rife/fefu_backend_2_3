<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealPostRequest;
use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\AppealPostRequest $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $showMessage = false;
        if ($request->get('accepted')) {
            if ($request->session()->get('show_message') === true) {
                $showMessage = true;
            }
            $request->session()->put('show_message', false);
        }
        return view('appeal', ['showMessage' => $showMessage]);
    }

    public function store(AppealPostRequest $request)
    {
        $validated = $request->validated();

        $appeal = new Appeal();
        $appeal->name = $validated['name'];
        $appeal->surname = $validated['surname'];
        $appeal->patronymic = $validated['patronymic'];
        $appeal->age = $validated['age'];
        $appeal->gender = $validated['gender'];
        $appeal->phone = PhoneSanitizer::sanitize($validated['phone']);
        $appeal->email = $validated['email'];
        $appeal->message = $validated['message'];
        $appeal->save();
        $request->session()->put('appealed', true);

        return redirect()->route('appeal_stored')->with('status', '✅(ー○ー)＝ Appeal sent is successfully!＝(ー○ー)✅');
    }
}
