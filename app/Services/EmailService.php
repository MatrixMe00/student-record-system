<?php

namespace App\Services;

use App\Mail\SystemNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send a system notification email to super admins
     *
     * @param string $subject
     * @param string $title
     * @param string $message
     * @param array $details
     * @param string|null $actionUrl
     * @param string|null $actionText
     * @return bool
     */
    public static function sendSystemNotification(
        string $subject,
        string $title,
        string $message,
        array $details = [],
        ?string $actionUrl = null,
        ?string $actionText = null
    ): bool {
        try {
            // Get all super admins (role_id <= 2)
            $superAdmins = User::where('role_id', '<=', 2)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get();

            if ($superAdmins->isEmpty()) {
                Log::warning('No super admin emails found to send system notification');
                return false;
            }

            // Send email to each super admin
            foreach ($superAdmins as $admin) {
                try {
                    Mail::to($admin->email)->send(
                        new SystemNotificationMail(
                            $subject,
                            $title,
                            $message,
                            $details,
                            $actionUrl,
                            $actionText
                        )
                    );
                } catch (\Exception $e) {
                    Log::error("Failed to send email to {$admin->email}: " . $e->getMessage());
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error('EmailService::sendSystemNotification failed: ' . $e->getMessage());
            return false;
        }
    }
}
