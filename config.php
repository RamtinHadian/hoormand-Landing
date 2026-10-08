<?php
// تنظیمات تماس لندینگ. فقط روی سرور خوانده می‌شود و از بیرون قابل دیدن نیست.
// هر کدام که خالی باشد، دکمه‌اش در صفحه نمی‌آید.
if (!defined('HOORMAND')) { http_response_code(403); exit; }

return [
    'demoUrl'  => 'https://demo.ramtinai.com',   // نشانی نمایش آزمایشی
    'phone'    => '03133920',                     // شمارهٔ تلفن
    'phoneExt' => '500',                          // داخلی
    'whatsapp' => '',                             // مثلاً https://wa.me/989121234567
    'telegram' => '',                             // مثلاً https://t.me/نام_کاربری
    'email'    => '',                             // مثلاً info@example.ir
];
