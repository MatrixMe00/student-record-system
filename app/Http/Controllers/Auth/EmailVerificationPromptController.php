<?php

namespace App\Http\Controllers\Auth;

use App\Constants\LogType;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        ActivityLog::$user_id = $request->user()->id;
        ActivityLog::success_log(LogType::EMAIL_VERIFY);
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');
    }
}
