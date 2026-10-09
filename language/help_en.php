<?php
//
// kj_sitemap_seo, its guide on the help page of the control panel
// English
//
// The guide is built by the admin_help_guides hook in init.php, the texts here can have HTML.
//  - a list is numbered: KJ_SITEMAP_SEO_HELP_TIP_1, KJ_SITEMAP_SEO_HELP_TIP_2 ... it ends at the first missing number,
//    so an item can be added or removed without touching the code
//  - KJ_SITEMAP_SEO_HELP_{LIST}_TITLE is the title of the list, a list without it takes the title that Kleeja gives its type
//  - questions and answers are KJ_SITEMAP_SEO_HELP_FAQ_Q_1 and KJ_SITEMAP_SEO_HELP_FAQ_A_1
//  - {sitemap_url} and {robots_url} are replaced with the addresses of the site
//  - names in <strong> are written as the control panel shows them, the words of Kleeja are in lang/en/
//

return [
    'KJ_SITEMAP_SEO_HELP_TITLE' => 'Sitemap SEO',
    'KJ_SITEMAP_SEO_HELP_INTRO' =>
        'Help search engines find new uploads sooner. The plugin publishes an XML sitemap of the 100 latest files and images, with the date of each upload, and links to it in the head of every page.',
    'KJ_SITEMAP_SEO_HELP_LINK' => 'Open the sitemap',

    //
    // what the plugin does
    //
    'KJ_SITEMAP_SEO_HELP_FEATURE_1' =>
        'The sitemap is built at every request from the latest uploads, so it is always up to date, with nothing to generate or schedule.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_2' =>
        'Each upload is listed with the link that Kleeja gives it: the download page of a file and the link of an image, in the forms chosen in <strong>Files URLs form</strong> and <strong>Images URLs form</strong>.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_3' =>
        'Images are listed with their thumbnail, in the image sitemap format that Google reads.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_4' =>
        'The sitemap is at <code>{sitemap_url}</code> on every server. When the <code>.htaccess</code> file of Kleeja is installed, it is also at <code>sitemap.xml</code> in the folder of Kleeja.',
    'KJ_SITEMAP_SEO_HELP_FEATURE_5' =>
        'Every page links to the sitemap with a <code>&lt;link rel="sitemap"&gt;</code> tag in its head.',

    //
    // how to use it
    //
    'KJ_SITEMAP_SEO_HELP_STEP_TITLE' => 'Submit the sitemap to search engines',
    'KJ_SITEMAP_SEO_HELP_STEP_1' =>
        'Click <strong>Open the sitemap</strong> above, and check that it lists your latest uploads.',
    'KJ_SITEMAP_SEO_HELP_STEP_2' =>
        'Add this line to <code>{robots_url}</code>, or create the file with it: <code>Sitemap: {sitemap_url}</code>',
    'KJ_SITEMAP_SEO_HELP_STEP_3' =>
        'Submit the same address once in the <strong>Sitemaps</strong> report of <a href="https://search.google.com/search-console" target="_blank" rel="noopener">Google Search Console</a> and of <a href="https://www.bing.com/webmasters" target="_blank" rel="noopener">Bing Webmaster Tools</a>.',
    'KJ_SITEMAP_SEO_HELP_STEP_4' =>
        'There is nothing more to do: search engines come back to the sitemap on their own and find the new uploads in it.',

    //
    // common questions
    //
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_1' => 'Why does the plugin no longer notify search engines after each upload?',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_1' =>
        'Versions before 2.0.0 had a setting that pinged Google, Bing and other services about new uploads. Google and Bing have closed those ping addresses, and the other services no longer exist, so version 2.0.0 removed the setting. Search engines find the sitemap through <code>robots.txt</code> and the address you submit to them.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_2' => 'Why does the sitemap list only 100 uploads?',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_2' =>
        'The sitemap is there for the uploads that search engines don\'t know yet. Older files were in it when they were new, and search engines keep the links they have found. A short list also keeps the sitemap fast on a busy site.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_3' => 'Why does <code>sitemap.xml</code> show an error page?',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_3' =>
        'That address needs the <code>.htaccess</code> file of Kleeja (shipped as <code>htaccess.txt</code>) and a rule that the plugin writes in <code>plugins_rules.php</code>, in the folder of Kleeja, when it is installed. If the web server could not write that file, allow it, then uninstall and install the plugin again. Until then, use <code>{sitemap_url}</code>, which works on every server.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_4' => 'Do search engines read the link in the head of the pages?',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_4' =>
        'Google and Bing don\'t: they read <code>robots.txt</code> and the sitemaps submitted to them, so don\'t skip the steps above. The link helps other tools find the sitemap.',
    'KJ_SITEMAP_SEO_HELP_FAQ_Q_5' => 'Why is an image listed without a thumbnail?',
    'KJ_SITEMAP_SEO_HELP_FAQ_A_5' =>
        'Its thumbnail was never created, for example when the server had no GD library at upload time. The plugin skips missing thumbnails, so search engines don\'t index the image that Kleeja shows in their place.',

    //
    // beside the guide
    //
    'KJ_SITEMAP_SEO_HELP_TIP_1' =>
        'The <strong>Sitemaps</strong> report of Search Console shows when Google last read your sitemap and how many links it found in it.',
    'KJ_SITEMAP_SEO_HELP_TIP_2' =>
        'The sitemap follows the link settings of Kleeja. After you change <strong>Mod Rewrite</strong>, <strong>Files URLs form</strong> or <strong>Images URLs form</strong>, it lists the new links at once.',

    'KJ_SITEMAP_SEO_HELP_WARNING_1' =>
        'The sitemap shows the latest uploads of every user and guest to anyone who opens it, search engines included. Don\'t use the plugin on a site where files are meant to be seen only by the people who were given their link.',
    'KJ_SITEMAP_SEO_HELP_WARNING_2' =>
        'Search engines read <code>robots.txt</code> only at the root of the domain. A copy in a subfolder, like the folder of Kleeja, is ignored.',
];
