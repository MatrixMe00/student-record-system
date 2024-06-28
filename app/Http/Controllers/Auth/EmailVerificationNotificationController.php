<?php

namespace App\Http\Controllers\Auth;

use App\Constants\LogType;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        ActivityLog::$user_id = $request->user()->id;
        ActivityLog::success_log(LogType::EMAIL_VERIFY, "email sent for confirmation");

        return back()->with('status', 'verification-link-sent');
    }
}
