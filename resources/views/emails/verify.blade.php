<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
</head>
<body style="font-family: Tahoma, sans-serif; background:#f5f7fa; padding:30px;">

    <div style="max-width:500px; margin:auto; background:#fff; padding:30px; border-radius:15px;">

        <h2 style="color:#0B3C5D;">مرحباً {{ $customer->full_name }}،</h2>

        <p style="color:#555; line-height:1.8;">
            شكراً لتسجيلك بمنصة Home Line. الرجاء تفعيل حسابك بالضغط على الزر أدناه:
        </p>

        <a href="{{ $verifyUrl }}"
           style="display:inline-block; background:#0B3C5D; color:#fff; padding:14px 30px; border-radius:10px; text-decoration:none; margin-top:15px;">
            تفعيل الحساب
        </a>

        <p style="color:#999; font-size:13px; margin-top:25px;">
            إذا لم تقومي بإنشاء هذا الحساب، يمكنك تجاهل هذه الرسالة.
        </p>

    </div>

</body>
</html>