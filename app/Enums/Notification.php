<?php

namespace App\Enums;

enum Notification: string
{
    case EmailVerification = 'email_verification';
    case PasswordReset = 'password_reset';
}
