<?php
//
// kj_sitemap_seo, its guide on the help page of the control panel
// Arabic
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
// The keys are the ones of help_en.php, a key that is missing here is shown in English.
//  - {sitemap_url} and {robots_url} are replaced with the addresses of the site
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/ar/
//  - a <code> that starts or ends with a symbol, like a link, has dir="ltr"
//

return [
    'KJ_SITEMAP_SEO_HELP_TITLE' => 'خريطة الموقع لمحركات البحث',
    'KJ_SITEMAP_SEO_HELP_INTRO' =>
        'ساعد محركات البحث على الوصول إلى الملفات الجديدة أسرع. تنشر الإضافة خريطة موقع بصيغة XML لأحدث 100 ملف وصورة مع تاريخ رفع كل منها، وتضع رابطها في ترويسة كل صفحة.',
    'KJ_SITEMAP_SEO_HELP_LINK' => 'عرض خريطة الموقع',

    //
    // what the plugin does
    //
    'KJ_SITEMAP_SEO_HELP_FEATURE_1' =>
        'تُبنى خريطة الموقع عند كل طلب من أحدث الملفات المرفوعة، فهي محدّثة دائمًا دون حاجة إلى إنشائها أو جدولتها.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_2' =>
        'يُدرَج كل ملف بالرابط الذي يمنحه له كليجا: صفحة التحميل للملف ورابط الصورة للصورة، بالشكل المختار في <strong>شكل روابط الملفات</strong> و<strong>شكل روابط الصور</strong>.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_3' => 'تُدرَج الصور مع صورها المصغّرة، بصيغة خرائط الصور التي يقرؤها Google.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_4' =>
        'خريطة الموقع متاحة على <code dir="ltr">{sitemap_url}</code> في أي خادم، ومتاحة أيضًا على <code>sitemap.xml</code> في مجلد كليجا عند تثبيت ملف <code dir="ltr">.htaccess</code> الخاص بكليجا.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_5' =>
        'تشير كل صفحة إلى خريطة الموقع بوسم <code dir="ltr">&lt;link rel="sitemap"&gt;</code> في ترويستها.',

    //
    // how to use it
    //
    'KJ_SITEMAP_SEO_HELP_STEP_TITLE' => 'أرسل خريطة الموقع إلى محركات البحث',
    'KJ_SITEMAP_SEO_HELP_STEP_1' =>
        'اضغط <strong>عرض خريطة الموقع</strong> في الأعلى، وتأكد أنها تعرض أحدث الملفات المرفوعة.',
    'KJ_SITEMAP_SEO_HELP_STEP_2' =>
        'أضف السطر التالي إلى <code dir="ltr">{robots_url}</code>، أو أنشئ الملف وضع فيه هذا السطر: <code dir="ltr">Sitemap: {sitemap_url}</code>',
    'KJ_SITEMAP_SEO_HELP_STEP_3' =>
        'أرسل العنوان نفسه مرة واحدة من قسم <strong>Sitemaps</strong> في <a href="https://search.google.com/search-console" target="_blank" rel="noopener">Google Search Console</a> وفي <a href="https://www.bing.com/webmasters" target="_blank" rel="noopener">Bing Webmaster Tools</a>.',
    'KJ_SITEMAP_SEO_HELP_STEP_4' =>
        'لا شيء آخر عليك فعله: تعود محركات البحث إلى خريطة الموقع من تلقاء نفسها وتجد فيها الملفات الجديدة.',

    //
    // common questions
    //
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_1' => 'لماذا لم تعد الإضافة تُبلغ محركات البحث بعد كل عملية رفع؟',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_1' =>
        'كان في الإصدارات السابقة للإصدار 2.0.0 خيار يُرسل تنبيهًا (Ping) إلى Google وBing وخدمات أخرى عند رفع ملفات جديدة. أغلقت Google وBing عناوين التنبيه هذه، ولم تعد الخدمات الأخرى موجودة، لذا أزال الإصدار 2.0.0 هذا الخيار. تصل محركات البحث إلى خريطة الموقع عبر ملف <code>robots.txt</code> والعنوان الذي ترسله إليها.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_2' => 'لماذا تعرض خريطة الموقع 100 ملف فقط؟',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_2' =>
        'خريطة الموقع موجودة للملفات التي لم تعرفها محركات البحث بعد، أما الملفات الأقدم فكانت فيها حين كانت جديدة، وتحتفظ محركات البحث بالروابط التي وصلت إليها. كما تُبقي القائمة القصيرة خريطة الموقع سريعة في المواقع كثيرة الرفع.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_3' => 'لماذا يعرض العنوان <code>sitemap.xml</code> صفحة خطأ؟',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_3' =>
        'يحتاج هذا العنوان إلى ملف <code dir="ltr">.htaccess</code> الخاص بكليجا (يأتي باسم <code>htaccess.txt</code>)، وإلى قاعدة تكتبها الإضافة عند تثبيتها في الملف <code>plugins_rules.php</code> في مجلد كليجا. إن لم يتمكن الخادم من الكتابة في هذا الملف فامنحه صلاحية الكتابة، ثم ألغِ تثبيت الإضافة وثبّتها من جديد. وإلى ذلك الحين استخدم <code dir="ltr">{sitemap_url}</code>، فهو يعمل في أي خادم.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_4' => 'هل تقرأ محركات البحث الرابط الموجود في ترويسة الصفحات؟',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_4' =>
        'لا يقرؤه Google ولا Bing، فهما يعتمدان على ملف <code>robots.txt</code> وخرائط المواقع المرسلة إليهما، لذا لا تتجاوز الخطوات السابقة. يفيد هذا الرابط أدوات أخرى في الوصول إلى خريطة الموقع.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_5' => 'لماذا تظهر صورة في خريطة الموقع دون صورة مصغّرة؟',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_5' =>
        'لم تُنشأ صورتها المصغّرة، كأن يكون الخادم بلا مكتبة GD وقت رفعها. تتجاهل الإضافة الصور المصغّرة المفقودة، حتى لا تفهرس محركات البحث الصورة البديلة التي يعرضها كليجا مكانها.',

    //
    // beside the guide
    //
    'KJ_SITEMAP_SEO_HELP_TIP_1' =>
        'يعرض قسم <strong>Sitemaps</strong> في Search Console آخر موعد قرأ فيه Google خريطة موقعك، وعدد الروابط التي وجدها فيها.',
    'KJ_SITEMAP_SEO_HELP_TIP_2' =>
        'تتبع خريطة الموقع إعدادات الروابط في كليجا، فإذا غيّرت <strong>Mod Rewrite</strong> أو <strong>شكل روابط الملفات</strong> أو <strong>شكل روابط الصور</strong> عرضت الروابط الجديدة فورًا.',

    'KJ_SITEMAP_SEO_HELP_WARNING_1' =>
        'تعرض خريطة الموقع أحدث ما رفعه الأعضاء والزوار لكل من يفتحها، ومنهم محركات البحث. لا تستخدم الإضافة في موقع يُفترض ألا يرى ملفاته إلا من أُعطي روابطها.',
    'KJ_SITEMAP_SEO_HELP_WARNING_2' =>
        'لا تقرأ محركات البحث ملف <code>robots.txt</code> إلا من جذر النطاق، وتتجاهل أي نسخة منه في مجلد فرعي، مثل مجلد كليجا.',
];
