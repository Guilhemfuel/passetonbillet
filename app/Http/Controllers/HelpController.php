<?php
namespace App\Http\Controllers;
use App\Mail\ContactEmail;
use App\User;
use Illuminate\Http\Request;
class HelpController extends Controller
{
    /**
     * Make sure a user can contact us via the form
     */
    public function contact( Request $request )
    {
        $this->validate( $request, [
            'g-recaptcha-response' => 'required|captcha',
            'name'                 => 'required',
            'email'                => 'required|email',
            'message'              => 'required'
        ] );
        \Mail::to(User::where('status',100)->first())->send(new ContactEmail($request->name,$request->email,$request->message));
        flash()->success(__('email.contact_success'));
        return redirect()->route('home');
        \Mail::to(\App\User::first())->send(new \App\Mail\ContactEmail('ok','ok','ok'));
    }
}
