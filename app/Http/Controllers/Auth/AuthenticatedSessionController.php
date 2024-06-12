<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\DebtorsList;
use App\Models\Payment;
use App\Models\PaymentInformation;
use App\Models\StudentBill;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\UserModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    use UserModelTrait;

    /**
     * @var User $user This holds the authenticated user
     */
    private ?User $user = null;

    /**
     * @var Model $model This holds the user model
     */
    private ?Model $model = null;

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            "page_title" => "Student Login",
            "role_id" => 5,
            "login_icon" => "fas fa-user-graduate"
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // set user as this user
        $this->user = Auth::user();

        // create the user model
        $this->model = $this->user_model($this->user);

        // create a cookie to hold the login name
        $response = $this->create_cookie();
        $cookie = $response->headers->getCookies()[0];

        // add necessary sessions
        $this->add_sessions();

        return redirect()->intended(RouteServiceProvider::HOME)->withCookie($cookie);
    }

    /**
     * Creates necessary sessions for the authenticated user
     */
    private function add_sessions(){
        // add the school id as a session
        $this->add_school_id();

        // students should have payment details checked out
        if($this->user->role_id == 5){
            $this->check_payments();
        }elseif($this->user->role_id == 4){
            $this->teacher_session();
        }

        // see if system is ready to receive payments
        $this->payment_ready();
    }

    /**
     * This creates a session to determine if the system is ready to receive payments
     */
    private function payment_ready(){
        $admins = Admin::all();
        $ready = false;
        if($admins->count() > 0){
            $admin_payments = PaymentInformation::where("master", true)->get();
            $ready = $admins->count() == $admin_payments->count();
        }

        session(["payment_is_ready" => $ready]);
    }

    /**
     * Creates a school id session
     */
    private function add_school_id(){
        $model = $this->model;
        session(["school_id" => $model->school_id]);
    }

    /**
     * Creates sessions for teacher
     */
    private function teacher_session(){
        $model = $this->model;

        return session([
            "class_teacher" => $model->class_teacher
        ]);
    }

    /**
     * Makes checks and creates sessions for all necessary payments
     */
    private function check_payments(){
        $this->add_payment_status("result");
        $this->add_payment_status("debt");
        $this->add_payment_status("bill");
    }

    /**
     * Creates a payment status session for students
     * @param string $payment_type The type of payment
     */
    private function add_payment_status(string $payment_type){
        switch($payment_type){
            case "result":
                $status = Payment::where('student_id', $this->user->id)
                                 ->where('expiry_date', ">", date("Y-m-d"))
                                 ->where('payment_type', 'results')
                                 ->orderBy('expiry_date', 'desc')->limit(1)->exists();
                break;
            case "debt":
                $status = DebtorsList::where('student_id', $this->user->id)
                                     ->where('status', true)->exists();
                break;
            case "bill":
                $status = StudentBill::where("student_id", $this->user->id)
                                     ->where("status", true)->exists();
                break;
            default:
                $status = Payment::where('student_id', $this->user->id)
                                 ->where('payment_type', strtolower($payment_type))
                                 ->orderBy('created_at', 'desc')->limit(1)->exists();
        }

        return session(["payment_$payment_type" => $status]);
    }

    /**
     * Create a cookie for the login page
     * @return Response returns a response object
     */
    private function create_cookie() :Response{
        $response = new Response('Login page captured');

        // delete cookie when the browser is closed
        $cookie = Cookie::make("login_page", $this->get_login_route());
        $response->cookie($cookie);

        return $response;
    }

    /**
     * Get the route name for the login page
     * @return ?string
     */
    private function get_login_route() :?string{
        // Get the URL of the referring page
        $refererUrl = url()->previous();

        // Get the route name corresponding to the URL
        $refererRouteName = Route::getRoutes()->match(
            request()->create($refererUrl, 'GET')
        )->getName();

        return $refererRouteName;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $login_page = $request->cookie('login_page');

        if($login_page && Route::has($login_page)){
            return redirect()->route($login_page);
        }

        return redirect('/');
    }
}
