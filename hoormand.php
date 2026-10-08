<?php
declare(strict_types=1);
define('HOORMAND', true);
// every request gets its own nonce: only the one inline script that carries it may run
$nonce = base64_encode(random_bytes(16));
$contact = require __DIR__ . '/config.php';
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: public, max-age=300, must-revalidate');
header("Content-Security-Policy: default-src 'none'; script-src 'self' 'nonce-$nonce'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; base-uri 'none'; form-action 'none'; frame-ancestors 'none'; object-src 'none'" . ($https ? '; upgrade-insecure-requests' : ''));
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()');
header('Cross-Origin-Opener-Policy: same-origin');
header('Cross-Origin-Resource-Policy: same-origin');
header_remove('X-Powered-By');
if ($https) { header('Strict-Transport-Security: max-age=31536000; includeSubDomains'); }
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>هورمند | نرم‌افزار اتوماسیون اداری، CRM و مدیریت مشتریان فارسی</title>
<meta name="description" content="هورمند سامانهٔ فارسی اتوماسیون اداری و بازرگانی: نامه‌نگاری و ارجاع، مدیریت مشتریان (CRM)، فرصت فروش و پیش‌فاکتور، گارانتی، پشتیبانی، پاپ‌آپ تماس تلفنی و پیامک خودکار. نصب روی سرور خودتان؛ نمایش آزمایشی.">
<meta name="theme-color" content="#0c0b14">
<link rel="icon" href="img/mark.png">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<meta name="keywords" content="نرم‌افزار اتوماسیون اداری, سیستم اتوماسیون اداری فارسی, نرم‌افزار CRM فارسی, مدیریت مشتریان, نرم‌افزار نامه‌نگاری اداری, صدور پیش‌فاکتور, نرم‌افزار گارانتی, سیستم پشتیبانی مشتریان, پاپ‌آپ تماس ایزابل, هورمند">
<meta name="author" content="هورمند">
<link rel="canonical" href="https://ramtinai.com/">
<link rel="alternate" hreflang="fa" href="https://ramtinai.com/">
<link rel="alternate" hreflang="x-default" href="https://ramtinai.com/">
<meta property="og:type" content="website">
<meta property="og:locale" content="fa_IR">
<meta property="og:site_name" content="هورمند">
<meta property="og:title" content="هورمند | نرم‌افزار اتوماسیون اداری، CRM و مدیریت مشتریان فارسی">
<meta property="og:description" content="هورمند سامانهٔ فارسی اتوماسیون اداری و بازرگانی: نامه‌نگاری و ارجاع، مدیریت مشتریان (CRM)، فرصت فروش و پیش‌فاکتور، گارانتی، پشتیبانی، پاپ‌آپ تماس تلفنی و پیامک خودکار. نصب روی سرور خودتان؛ نمایش آزمایشی.">
<meta property="og:url" content="https://ramtinai.com/">
<meta property="og:image" content="https://ramtinai.com/img/og.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="هورمند | نرم‌افزار اتوماسیون اداری، CRM و مدیریت مشتریان فارسی">
<meta name="twitter:description" content="هورمند سامانهٔ فارسی اتوماسیون اداری و بازرگانی: نامه‌نگاری و ارجاع، مدیریت مشتریان (CRM)، فرصت فروش و پیش‌فاکتور، گارانتی، پشتیبانی، پاپ‌آپ تماس تلفنی و پیامک خودکار. نصب روی سرور خودتان؛ نمایش آزمایشی.">
<meta name="twitter:image" content="https://ramtinai.com/img/og.png">
<link rel="apple-touch-icon" href="img/mark.png">
<script type="application/ld+json">[{"@context": "https://schema.org", "@type": "SoftwareApplication", "name": "هورمند", "alternateName": ["Hoormand", "سامانه اتوماسیون اداری هورمند"], "applicationCategory": "BusinessApplication", "operatingSystem": "Web, Linux, Windows", "inLanguage": "fa-IR", "description": "هورمند سامانهٔ فارسی اتوماسیون اداری و بازرگانی: نامه‌نگاری و ارجاع، مدیریت مشتریان (CRM)، فرصت فروش و پیش‌فاکتور، گارانتی، پشتیبانی، پاپ‌آپ تماس تلفنی و پیامک خودکار. نصب روی سرور خودتان؛ نمایش آزمایشی.", "url": "https://ramtinai.com/", "image": "https://ramtinai.com/img/og.png", "featureList": ["نامه‌نگاری اداری با شماره‌گذاری و ارجاع", "مدیریت مشتریان (CRM) و قیف فروش", "صدور پیش‌فاکتور با تأیید مدیرعامل", "سامانه گارانتی و گواهی چاپی", "پشتیبانی مشتریان با پلن و مهلت پاسخ", "پاپ‌آپ تماس تلفنی (ایزابل)", "پیامک خودکار به مشتری", "تقویم شمسی و رابط کاملاً فارسی"]}, {"@context": "https://schema.org", "@type": "Organization", "name": "هورمند", "url": "https://ramtinai.com/", "logo": "https://ramtinai.com/img/mark.png", "contactPoint": {"@type": "ContactPoint", "telephone": "+98-31-33920", "contactType": "sales", "availableLanguage": "fa"}}, {"@context": "https://schema.org", "@type": "WebSite", "name": "هورمند", "url": "https://ramtinai.com/", "inLanguage": "fa-IR"}, {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": "اطلاعات شرکت ما کجا نگه‌داری می‌شود؟", "acceptedAnswer": {"@type": "Answer", "text": "روی سرور خودتان. سامانه روی سرور شما نصب می‌شود و هر شب از پایگاه داده نسخهٔ پشتیبان می‌گیرد."}}, {"@type": "Question", "name": "روی گوشی هم کار می‌کند؟", "acceptedAnswer": {"@type": "Answer", "text": "بله. صفحه‌ها برای گوشی هم طراحی شده‌اند، با منوی پایین صفحه و اعلان موبایل."}}, {"@type": "Question", "name": "به تلفن شرکت وصل می‌شود؟", "acceptedAnswer": {"@type": "Answer", "text": "بله، به تلفن‌خانهٔ ایزابل وصل می‌شود. وقتی مشتری زنگ بزند، نام و پروندهٔ او روی صفحهٔ همکار می‌آید و تماس‌ها در سابقه می‌مانند."}}, {"@type": "Question", "name": "پیامک به مشتری چطور فرستاده می‌شود؟", "acceptedAnswer": {"@type": "Answer", "text": "با پنل کاوه‌نگار. مدیر مشخص می‌کند کدام پیام‌ها (مثل خوش‌آمد یا صدور پیش‌فاکتور) خودکار برای مشتری برود و نام شرکت یا آدرس سایت زیر هر پیامک نوشته می‌شود."}}, {"@type": "Question", "name": "هر همکار همه‌چیز را می‌بیند؟", "acceptedAnswer": {"@type": "Answer", "text": "نه. مدیر برای هر کاربر تعیین می‌کند کدام منوها را ببیند؛ مثلاً حذف مشتری فقط با مدیر سیستم است."}}, {"@type": "Question", "name": "نمایش آزمایشی می‌خواهم.", "acceptedAnswer": {"@type": "Answer", "text": "از دکمهٔ «نمایش آزمایشی» وارد نسخهٔ نمونه شوید؛ همه‌چیز با اطلاعات نمونه است و هر ساعت به حالت اول برمی‌گردد."}}]}]</script>
<noscript><style>.rv{opacity:1!important;transform:none!important}</style></noscript>

<link rel="preload" href="fonts/Vazirmatn-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css?v=202610090254">
</head>
<body>

<!-- floating white navigation pill -->
<header class="nav" id="nav">
  <nav class="pill-nav" aria-label="منوی اصلی">
    <a class="brand" href="#top" aria-label="هورمند"><img src="img/mark.png" alt="" width="32" height="32"><b>هورمند</b></a>
    <div class="links" id="navLinks"><i class="lens" aria-hidden="true"></i>
      <a href="#features">امکانات</a>
      <a href="#control">چرا هورمند</a>
      <a href="#flow">روند کار</a>
      <a href="#showcase">از نزدیک</a>
      <a href="#mobile">روی گوشی</a>
      <a href="#faq">پرسش‌ها</a>
    </div>
    <a class="btn btn-blue" href="#contact" data-cta>نمایش آزمایشی</a>
  </nav>
</header>

<main id="top">

<!-- ============ HERO: dark, with light rays ============ -->
<section class="hero">
  <div class="rays" aria-hidden="true"><i class="glow gl"></i><i class="glow gr"></i><canvas id="rayCanvas"></canvas><i class="floor"></i></div>
  <div class="hero-in">
    <span class="eyebrow-grad rv">سامانهٔ هوشمند اتوماسیون اداری و بازرگانی</span>
    <h1 class="h-hero rv" style="--i:1">همهٔ کارهای شرکت را<br>با <span class="grad">وضوح</span> پیش ببرید.</h1>
    <p class="hero-p rv" style="--i:2">هورمند فایل، نامه، مشتری، فروش، گارانتی و پشتیبانی را در یک سامانهٔ فارسی کنار هم می‌گذارد؛ با تقویم شمسی، پاپ‌آپ تماس تلفنی و پیامک خودکار به مشتری.</p>
    <div class="hero-cta rv" style="--i:3">
      <a class="btn btn-blue btn-lg" href="#contact" data-cta>درخواست نمایش آزمایشی</a>
      <a class="btn btn-glass btn-lg" href="#features">دیدن امکانات</a>
    </div>
  </div>
  <a class="scroll-hint" href="#preview" aria-label="ادامه"><i></i></a>
</section>

<!-- ============ PREVIEW + 4 DARK CARDS ============ -->
<section class="dark-sec" id="preview">
  <div class="glow-top" aria-hidden="true"></div>
  <div class="wrap">
    <h2 class="h2 center rv">مورد اعتماد تیم‌های فروش و اداری،<br><span class="grad">از اولین تماس تا آخرین فاکتور.</span></h2>
    <p class="sub center rv" style="--i:1">سامانه‌ای که همکاران در آن به هم می‌رسند و هیچ مشتری و هیچ درخواستی گم نمی‌شود.</p>

    <div class="stage-dev rv" style="--i:2" id="stageDev">
      <div class="dev">
        <div class="bar"><i></i><i></i><i></i><span>سامانهٔ هورمند</span></div>
        <img src="img/deals.webp" alt="قیف فروش در سامانهٔ هورمند" width="1760" height="990" fetchpriority="high">
      </div>
      <div class="chip c1"><b>☎ تماس ورودی</b><small>شرکت آرمان صنعت · داخلی ۵۰۰</small></div>
      <div class="chip c2"><b>✓ پیش‌فاکتور صادر شد</b><small>پیامک به مشتری رفت</small></div>
    </div>

    <div class="dcards" id="features">
      <article class="dcard rv" style="--i:0">
        <span class="tagp"><i class="ring"></i>مشتریان و فروش</span>
        <div class="dimg"><img src="img/crm.webp" alt="خلاصهٔ مشتریان و فروش در نرم‌افزار CRM فارسی هورمند" loading="lazy" width="1760" height="990"></div>
        <h3>مشتری را از اولین تماس تا فروش موفق ببینید.</h3>
        <ul><li>پروندهٔ کامل هر مشتری</li><li>قیف فروش و پیگیری روزانه</li><li>پیش‌فاکتور با تأیید مدیرعامل</li></ul>
      </article>
      <article class="dcard rv" style="--i:1">
        <span class="tagp"><i class="ring"></i>تلفن و پیامک</span>
        <div class="dimg call"><img src="img/call.webp" alt="پاپ‌آپ تماس ورودی مشتری در سامانه هورمند" loading="lazy" width="1760" height="990"></div>
        <h3>مشتری زنگ زد، پروندهاش همان لحظه باز شد.</h3>
        <ul><li>پاپ‌آپ تماس با نام مشتری</li><li>سابقهٔ همهٔ تماس‌ها</li><li>پیامک خودکار با نام شرکت شما</li></ul>
      </article>
      <article class="dcard rv" style="--i:2">
        <span class="tagp"><i class="ring"></i>نامه و فایل</span>
        <div class="dimg"><img src="img/letters.webp" alt="کارتابل نامه‌نگاری اداری با ارجاع و امضا" loading="lazy" width="1760" height="990"></div>
        <h3>نامهٔ رسمی با شماره، ارجاع و امضای مدیرعامل.</h3>
        <ul><li>ویرایشگر شبیه Word</li><li>شمارهٔ خودکار نامه</li><li>ارسال فایل به همکار و واحد</li></ul>
      </article>
      <article class="dcard rv" style="--i:3">
        <span class="tagp"><i class="ring"></i>گارانتی و پشتیبانی</span>
        <div class="dimg"><img src="img/tickets.webp" alt="درخواست‌های پشتیبانی مشتریان با مهلت پاسخ" loading="lazy" width="1760" height="990"></div>
        <h3>هر درخواست مهلت دارد و هیچ‌کدام فراموش نمی‌شود.</h3>
        <ul><li>پلن و اشتراک پشتیبانی</li><li>گواهی گارانتی با مهر و امضا</li><li>صفحهٔ ورود مشتری و دستیار هوشمند</li></ul>
      </article>
    </div>
  </div>
</section>

<!-- ============ CONTROL: white, before / after around an orb ============ -->
<section class="light-sec" id="control">
  <div class="wrap">
    <span class="pill-label rv"><i class="heart">♥</i>اطمینان</span>
    <h2 class="h2 dark center rv" style="--i:1">آشفتگی را کنار بگذارید.<br><span class="grad">با اطمینان کار کنید.</span></h2>

    <div class="ctrl">
      <ul class="col bad">
        <li class="rv" style="--i:0"><i>×</i>فایل‌ها و نامه‌ها در پیام‌رسان‌ها گم می‌شوند</li>
        <li class="rv" style="--i:1"><i>×</i>مشتری‌ها پراکنده در دفترچه و اکسل‌اند</li>
        <li class="rv" style="--i:2"><i>×</i>تماس‌ها بدون سابقه و بدون پروندهٔ مشتری</li>
        <li class="rv" style="--i:3"><i>×</i>وظیفه‌ها شفاهی داده می‌شود و فراموش می‌شود</li>
        <li class="rv" style="--i:4"><i>×</i>گارانتی و پشتیبانی روی کاغذ و بی‌مهلت</li>
      </ul>
      <div class="orb-wrap" aria-hidden="true"><div class="orb"><div class="ring-o"></div><div class="mandala"></div><img src="img/mark.png" alt="" width="84" height="84"></div></div>
      <ul class="col good">
        <li class="rv" style="--i:0"><i>✓</i>همهٔ فایل‌ها و نامه‌ها یک‌جا، با شمارهٔ خودکار</li>
        <li class="rv" style="--i:1"><i>✓</i>هر مشتری یک پرونده با تمام تاریخچه‌اش</li>
        <li class="rv" style="--i:2"><i>✓</i>پاپ‌آپ تماس و سابقهٔ کامل تماس‌ها</li>
        <li class="rv" style="--i:3"><i>✓</i>وظیفه با مسئول، مهلت و اعلان</li>
        <li class="rv" style="--i:4"><i>✓</i>گارانتی و پشتیبانی با مهلت پاسخ مشخص</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ FLOW: staircase timeline with waves ============ -->
<section class="flow-sec" id="flow">
  <div class="wrap">
    <span class="pill-label rv"><i class="spin"></i>روند کار</span>
    <h2 class="h2 dark center rv" style="--i:1">یک سامانهٔ یکپارچه،<br><span class="grad">ارزشی که روزبه‌روز بیشتر می‌شود.</span></h2>
    <p class="sub dark center rv" style="--i:2">هورمند هر چیزی را که شرکت شما برای کار لازم دارد ثبت می‌کند، به هم وصل می‌کند و پیگیری می‌کند.</p>

    <div class="chart" id="chart">
      <svg class="trace" id="trace" aria-hidden="true"></svg>
      <div class="bars">
        <article class="bar-c b1 rv" style="--i:0"><span class="node" aria-hidden="true"></span>
          <div class="bhead"><i>۱</i><h4>ثبت می‌کند</h4></div>
          <p>همه‌چیز از یک‌جا شروع می‌شود.</p>
          <ul><li>مشتری</li><li>تماس</li><li>فایل</li><li>نامه</li></ul></article>
        <article class="bar-c b2 rv" style="--i:1"><span class="node" aria-hidden="true"></span>
          <div class="bhead"><i>۲</i><h4>وصل می‌کند</h4></div>
          <p>هر ثبت به کار بعدی گره می‌خورد.</p>
          <ul><li>فرصت فروش</li><li>پیش‌فاکتور</li><li>پیامک</li><li>ارجاع</li></ul></article>
        <article class="bar-c b3 rv" style="--i:2"><span class="node" aria-hidden="true"></span>
          <div class="bhead"><i>۳</i><h4>پیگیری می‌کند</h4></div>
          <p>چیزی از قلم نمی‌افتد.</p>
          <ul><li>وظیفه</li><li>مهلت</li><li>یادآوری</li><li>اعلان</li></ul></article>
        <article class="bar-c b4 rv" style="--i:3"><span class="node" aria-hidden="true"></span>
          <div class="bhead"><i>۴</i><h4>گزارش می‌دهد</h4></div>
          <p>مدیر وضع شرکت را با یک نگاه می‌بیند.</p>
          <ul><li>فروش</li><li>گارانتی</li><li>پشتیبانی</li><li>نمودار</li></ul></article>
      </div>
    </div>
  </div>
  <svg class="waves" id="waves" viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true"></svg>
</section>

<!-- ============ SHOWCASE (tabs) ============ -->
<section class="dark-sec tabs-sec" id="showcase">
  <div class="glow-top" aria-hidden="true"></div>
  <div class="wrap">
    <span class="pill-label glass rv">از نزدیک ببینید</span>
    <h2 class="h2 center rv" style="--i:1">تصویرهای واقعی از <span class="grad">خود سامانه</span></h2>
    <p class="sub center rv" style="--i:2">این‌ها عکس طراحی نیستند؛ صفحه‌های واقعی سامانه با اطلاعات نمونه‌اند.</p>

    <div class="show rv" style="--i:3">
      <div class="tabs" role="tablist" aria-label="بخش‌های سامانه">
        <button role="tab" aria-selected="true" data-img="files" data-title="امور اداری" data-text="ارسال و دریافت فایل میان همکاران و واحدها، گفتگو، درخواست مرخصی و تابلو اعلانات.">امور اداری</button>
        <button role="tab" aria-selected="false" data-img="editor" data-title="نامه‌نگاری" data-text="کارتابل نامه‌ها با وضعیت امضا، شمارهٔ خودکار، ارجاع و چاپ یا خروجی PDF.">نامه‌نگاری</button>
        <button role="tab" aria-selected="false" data-img="customer" data-title="پروندهٔ مشتری" data-text="تلفن‌ها، سابقهٔ تماس، پیگیری‌ها، فرصت‌ها، گارانتی‌ها و درخواست‌های پشتیبانی هر مشتری در یک صفحه.">پروندهٔ مشتری</button>
        <button role="tab" aria-selected="false" data-img="proforma" data-title="پیش‌فاکتور" data-text="صدور پیش‌فاکتور با سربرگ شرکت، شمارهٔ خودکار و در صورت لزوم تأیید مدیرعامل.">پیش‌فاکتور</button>
        <button role="tab" aria-selected="false" data-img="warranty" data-title="گارانتی" data-text="گارانتی هر کالا با سریال و تاریخ پایان؛ درخواست خرابی مرحله‌به‌مرحله و گواهی چاپی.">گارانتی</button>
        <button role="tab" aria-selected="false" data-img="support" data-title="پشتیبانی" data-text="پلن‌ها، اشتراک مشتریان، درخواست‌ها با مهلت پاسخ و نمودار وضعیت.">پشتیبانی</button>
        <button role="tab" aria-selected="false" data-img="reports" data-title="گزارشات" data-text="فروش، تماس‌های بی‌پاسخ، وظایف عقب‌افتاده، گارانتی و پشتیبانی با نمودار.">گزارشات</button>
        <button role="tab" aria-selected="false" data-img="admin" data-title="کنسول مدیریت" data-text="کاربران و دسترسی‌ها، نام و هویت شرکت، سربرگ نامه‌ها، پیامک، تلفن و پشتیبان‌گیری.">کنسول مدیریت</button>
      </div>
      <div class="stage">
        <div class="dev big">
          <div class="bar"><i></i><i></i><i></i><span id="stageTitle">امور اداری</span></div>
          <div class="imgs" id="stageImgs">
            <img class="on" src="img/files.webp" alt="ارسال و دریافت فایل در امور اداری" data-k="files" loading="lazy" width="1760" height="990">
            <img src="img/editor.webp" alt="ویرایشگر نامه‌نگاری اداری" data-k="editor" loading="lazy" width="1760" height="990">
            <img src="img/customer.webp" alt="پروندهٔ مشتری در CRM" data-k="customer" loading="lazy" width="1760" height="990">
            <img src="img/proforma.webp" alt="صدور پیش‌فاکتور" data-k="proforma" loading="lazy" width="1760" height="990">
            <img src="img/warranty.webp" alt="سامانهٔ ثبت گارانتی" data-k="warranty" loading="lazy" width="1760" height="990">
            <img src="img/support.webp" alt="پلن‌ها و اشتراک پشتیبانی" data-k="support" loading="lazy" width="1760" height="990">
            <img src="img/reports.webp" alt="گزارشات مدیریتی فروش و پشتیبانی" data-k="reports" loading="lazy" width="1760" height="990">
            <img src="img/admin.webp" alt="کنسول مدیریت کاربران و دسترسی‌ها" data-k="admin" loading="lazy" width="1760" height="990">
          </div>
        </div>
        <p class="stage-text" id="stageText" aria-live="polite">ارسال و دریافت فایل میان همکاران و واحدها، گفتگو، درخواست مرخصی و تابلو اعلانات.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ MOBILE ============ -->
<section class="mob-sec" id="mobile">
  <div class="wrap mobile-grid">
    <div class="mob-copy">
      <span class="pill-label rv"><i class="heart">●</i>روی گوشی</span>
      <h2 class="h2 dark rv" style="--i:1">در جیب شما،<br><span class="grad">با اعلان زنده.</span></h2>
      <p class="sub dark rv" style="--i:2">منوی پایین صفحه، دکمه‌های درشت و اعلان موبایل؛ حتی وقتی برنامه بسته است، تماس، وظیفه و نامهٔ تازه به شما می‌رسد.</p>
      <ul class="ticks rv" style="--i:3"><li>ظاهر یکسان روی رایانه و گوشی</li><li>اعلان موبایل و پاپ‌آپ تماس</li><li>ورود با نام کاربری و رمز</li></ul>
    </div>
    <div class="phones" id="phones" aria-hidden="true">
      <div class="phone p1" data-speed="0.10"><img src="img/m-home.webp" alt="سامانه هورمند روی گوشی" loading="lazy" width="600" height="1300"></div>
      <div class="phone p2" data-speed="0.04"><img src="img/m-crm.webp" alt="مدیریت مشتریان روی گوشی" loading="lazy" width="600" height="1300"></div>
      <div class="phone p3" data-speed="0.16"><img src="img/p-home.webp" alt="صفحهٔ ورود مشتری به پشتیبانی" loading="lazy" width="600" height="1300"></div>
    </div>
  </div>
</section>

<!-- ============ CUSTOMER PORTAL + AI ============ -->
<section class="dark-sec portal" id="support">
  <div class="glow-top" aria-hidden="true"></div>
  <div class="wrap split">
    <div class="split-img rv"><div class="phone solo"><img src="img/p-chat.webp" alt="صفحهٔ مشتریان: گفتگو دربارهٔ یک درخواست پشتیبانی" loading="lazy" width="600" height="1300"></div></div>
    <div class="split-copy">
      <span class="pill-label glass rv">پشتیبانی مشتریان</span>
      <h2 class="h2 rv" style="--i:1">مشتری مشکلش را<br><span class="grad">خودش می‌فرستد.</span></h2>
      <p class="sub rv" style="--i:2">مشتری‌هایی که پلن پشتیبانی دارند با شمارهٔ موبایل و چهار رقم آخر کد ملی وارد صفحهٔ مخصوص خودشان می‌شوند، مشکل را می‌نویسند و پاسخ را همان‌جا می‌خوانند. درخواست مستقیم در سامانهٔ شما می‌نشیند.</p>
      <div class="minis rv" style="--i:3">
        <div><b>پاسخ اولیهٔ هوشمند</b><span>اگر بخواهید، یک دستیار هوش مصنوعی جواب اولیه می‌دهد و همکار شما هم درخواست را می‌بیند.</span></div>
        <div><b>مهلت پاسخ</b><span>هر پلن زمان پاسخ و حل دارد و تأخیر همان لحظه دیده می‌شود.</span></div>
      </div>
    </div>
  </div>
</section>


<!-- ============ ABOUT (text for readers and search engines) ============ -->
<section class="light-sec about" id="about">
  <div class="wrap narrow">
    <span class="pill-label rv">هورمند چیست؟</span>
    <h2 class="h2 dark center rv" style="--i:1">نرم‌افزار اتوماسیون اداری و CRM فارسی <span class="grad">برای شرکت‌ها</span></h2>
    <div class="about-text rv" style="--i:2">
      <p><b>هورمند</b> یک <b>سامانهٔ اتوماسیون اداری و بازرگانی</b> کاملاً فارسی است که کارهای روزانهٔ شرکت را یک‌جا جمع می‌کند: <b>نامه‌نگاری اداری</b> با شمارهٔ خودکار، ارجاع و امضای مدیرعامل؛ <b>مدیریت مشتریان (CRM)</b> با پروندهٔ کامل هر مشتری، قیف فروش و پیگیری روزانه؛ <b>صدور پیش‌فاکتور</b> با تأیید مدیرعامل؛ <b>سامانهٔ گارانتی</b> با گواهی چاپی؛ و <b>سیستم پشتیبانی مشتریان</b> با پلن، اشتراک و مهلت پاسخ.</p>
      <p>سامانه به <b>تلفن‌خانهٔ ایزابل (Issabel)</b> وصل می‌شود و هنگام تماس مشتری، نام و پروندهٔ او را روی صفحهٔ همکار نشان می‌دهد. <b>پیامک خودکار به مشتری</b> (با کاوه‌نگار)، <b>تقویم شمسی</b>، اعلان موبایل، وظایف و گزارش روزانه، و گزارشات مدیریتی با نمودار هم در آن هست.</p>
      <p>هورمند روی <b>سرور خودتان</b> نصب می‌شود، هر شب نسخهٔ پشتیبان می‌گیرد و روی رایانه و گوشی کار می‌کند.</p>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="light-sec faq-sec" id="faq">
  <div class="wrap narrow">
    <span class="pill-label rv">پرسش‌ها</span>
    <h2 class="h2 dark center rv" style="--i:1">پاسخ چند <span class="grad">پرسش رایج</span></h2>
    <div class="faq">
      <details class="rv" style="--i:0"><summary>اطلاعات شرکت ما کجا نگه‌داری می‌شود؟</summary><div><p>روی سرور خودتان. سامانه روی سرور شما نصب می‌شود و هر شب از پایگاه داده نسخهٔ پشتیبان می‌گیرد.</p></div></details>
      <details class="rv" style="--i:1"><summary>روی گوشی هم کار می‌کند؟</summary><div><p>بله. صفحه‌ها برای گوشی هم طراحی شده‌اند، با منوی پایین صفحه و اعلان موبایل.</p></div></details>
      <details class="rv" style="--i:2"><summary>به تلفن شرکت وصل می‌شود؟</summary><div><p>بله، به تلفن‌خانهٔ ایزابل وصل می‌شود. وقتی مشتری زنگ بزند، نام و پروندهٔ او روی صفحهٔ همکار می‌آید و تماس‌ها در سابقه می‌مانند.</p></div></details>
      <details class="rv" style="--i:3"><summary>پیامک به مشتری چطور فرستاده می‌شود؟</summary><div><p>با پنل کاوه‌نگار. مدیر مشخص می‌کند کدام پیام‌ها (مثل خوش‌آمد یا صدور پیش‌فاکتور) خودکار برای مشتری برود و نام شرکت یا آدرس سایت زیر هر پیامک نوشته می‌شود.</p></div></details>
      <details class="rv" style="--i:4"><summary>هر همکار همه‌چیز را می‌بیند؟</summary><div><p>نه. مدیر برای هر کاربر تعیین می‌کند کدام منوها را ببیند؛ مثلاً حذف مشتری فقط با مدیر سیستم است.</p></div></details>
      <details class="rv" style="--i:5"><summary>نمایش آزمایشی می‌خواهم.</summary><div><p>از دکمهٔ «نمایش آزمایشی» وارد نسخهٔ نمونه شوید؛ همه‌چیز با اطلاعات نمونه است و هر ساعت به حالت اول برمی‌گردد.</p></div></details>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta" id="contact">
  <div class="rays small" aria-hidden="true"><i class="glow gl"></i><i class="glow gr"></i><i class="fan"></i></div>
  <div class="wrap">
    <h2 class="h2 center rv">هورمند را <span class="grad">از نزدیک ببینید.</span></h2>
    <p class="sub center rv" style="--i:1">یک نمایش آزمایشی با اطلاعات نمونه، یا نصب در شرکت خودتان.</p>
    <div class="hero-cta center rv" style="--i:2" id="contactRow"></div>
  </div>
</section>

</main>

<footer class="foot">
  <div class="wrap foot-in">
    <div class="brand light"><img src="img/mark.png" alt="" width="30" height="30"><b>هورمند</b></div>
    <span>سامانهٔ هوشمند اتوماسیون اداری و بازرگانی</span>
  </div>
</footer>

<script nonce="<?= $nonce ?>">window.HOORMAND_CONTACT = <?= json_encode($contact, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<script src="app.js?v=202610090254" defer></script>
</body>
</html>
