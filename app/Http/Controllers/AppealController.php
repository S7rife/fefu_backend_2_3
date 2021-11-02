<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealPostRequest;
use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\AppealPostRequest $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('appeal');
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

        return redirect()->route('appeal_stored')->with('status', '✅(ー○ー)＝ Appeal sent is successfully!＝(ー○ー)✅');
    }
}
