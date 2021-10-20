<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $errors = [];
        $success = $request->session()->get('success', false);

        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $message = $request->input('message');
            $phone = $request->input('phone');
            $email = $request->input('email');

            if ($name === null) {
                $errors['name'] = 'Is your name so empty?';
            }

            if ($message === null) {
                $errors['message'] = 'Well, write at least something!';
            }

            if (0 < strlen($phone) && strlen($phone) < 11) {
                $errors['phone'] = 'You seem to be missing numbers...';
            }

            if ($email && (!strpos($email, '@') || !strpos($email, '.'))) {
                $errors['email'] = "There are legends that every email should contain '@' and '.'";
            }

            if ($phone === null && $email === null) {
                $errors['contacts'] = 'We just need to contact you somehow';
            }


            if (count($errors) > 0) {
                $request->flash();
            } else {
                $appeal = new Appeal();
                $appeal->name = $name;
                $appeal->message = $message;
                $appeal->phone = $phone;
                $appeal->email = $email;
                $appeal->save();

                $success = true;

                return redirect()
                    ->route('appeal')
                    ->with('success', $success);
            }
        }
        return view('appeal', ['errors' => $errors, 'success' => $success]);
    }
}
