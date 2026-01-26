<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-title {
            font-size: 24px;
            font-weight: 600;
            color: #1a202c;
            margin: 0 0 20px 0;
        }
        .email-message {
            font-size: 16px;
            color: #4a5568;
            margin: 0 0 30px 0;
            line-height: 1.8;
        }
        .details-box {
            background-color: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .details-box h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin: 0 0 15px 0;
        }
        .detail-item {
            margin: 10px 0;
            font-size: 14px;
            color: #4a5568;
        }
        .detail-item strong {
            color: #2d3748;
            display: inline-block;
            min-width: 120px;
        }
        .action-button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .email-footer {
            background-color: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #718096;
        }
        .logo {
            display: inline-block;
            margin-bottom: 15px;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .email-header {
                padding: 30px 15px;
            }
            .email-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo">
                <span style="color: #ffffff; font-size: 32px; font-weight: bold;">📚</span>
            </div>
            <h1>EduRecordsGH</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2 class="email-title">{{ $title }}</h2>
            
            <div class="email-message">
                {!! nl2br(e($message)) !!}
            </div>

            @if(!empty($details))
                <div class="details-box">
                    <h3>Details:</h3>
                    @foreach($details as $label => $value)
                        <div class="detail-item">
                            <strong>{{ $label }}:</strong> {{ $value }}
                        </div>
                    @endforeach
                </div>
            @endif

            @if($actionUrl && $actionText)
                <div style="text-align: center;">
                    <a href="{{ $actionUrl }}" class="action-button">{{ $actionText }}</a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>EduRecordsGH</strong></p>
            <p>Student Record Management System</p>
            <p style="margin-top: 15px; font-size: 12px; color: #a0aec0;">
                This is an automated notification. Please do not reply to this email.
            </p>
            <p style="margin-top: 10px; font-size: 12px; color: #a0aec0;">
                &copy; {{ date('Y') }} EduRecordsGH. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
