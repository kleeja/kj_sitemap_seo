<?php
// Kleeja Plugin
// kj_sitemap_seo
// Version: 2.0.0
// Developer: Kleeja team

// Prevent illegal run
if (!defined('IN_PLUGINS_SYSTEM')) {
    exit();
}

// Plugin Basic Information
$kleeja_plugin['kj_sitemap_seo']['information'] = [
    // The casual name of this plugin, anything can a human being understands
    'plugin_title' => [
        'en' => 'Sitemap SEO',
        'ar' => 'خريطة الموقع لمحركات البحث',
    ],
    // Who wrote this plugin?
    'plugin_developer' => 'Kleeja.net',
    // This plugin version
    'plugin_version' => '2.0.0',
    // Explain what is this plugin, why should I use it?
    'plugin_description' => [
        'en' => 'Publish an XML sitemap of your latest uploads, so search engines find new files and images sooner.',
        'ar' => 'تنشر خريطة موقع بصيغة XML لأحدث الملفات المرفوعة، لتصل محركات البحث إلى الملفات والصور الجديدة أسرع.',
    ],
    // Min version of Kleeja that's requiered to run this plugin
    'plugin_kleeja_version_min' => '4.0.0',
    // Max version of Kleeja that support this plugin, use 0 for unlimited
    'plugin_kleeja_version_max' => '4.9',
    // Should this plugin run before others?, 0 is normal, and higher number has high priority
    'plugin_priority' => 0,
];

// the address of the sitemap in the messages below, $config is loaded when the control panel installs the plugin
$kj_sitemap_seo_address = htmlspecialchars(($GLOBALS['config']['siteurl'] ?? '') . 'go.php?go=sitemap');

//after installation message, you can remove it, it's not requiered
$kleeja_plugin['kj_sitemap_seo']['first_run']['ar'] = "
تنشر هذه الإضافة خريطة موقع بصيغة XML لأحدث 100 ملف مرفوع، وتضع رابطها في ترويسة كل صفحة.
أضف السطر التالي إلى ملف robots.txt في جذر نطاقك، لتجد محركات البحث خريطة الموقع:
<br>
<code dir='ltr'>Sitemap: {$kj_sitemap_seo_address}</code>
<br>
<a href='{$kj_sitemap_seo_address}' target='_blank' rel='noopener'>عرض خريطة الموقع</a> -
<a href='./index.php?cp=s_help#help-kj_sitemap_seo'>دليل الإضافة</a> -
<a href='https://github.com/kleeja/kj_sitemap_seo/issues' target='_blank' rel='noopener'>الإبلاغ عن مشكلة</a>
";

$kleeja_plugin['kj_sitemap_seo']['first_run']['en'] = "
This plugin publishes an XML sitemap of the 100 latest uploads, and links to it in the head of every page.
Add the line below to the robots.txt file at the root of your domain, so search engines find the sitemap:
<br>
<code>Sitemap: {$kj_sitemap_seo_address}</code>
<br>
<a href='{$kj_sitemap_seo_address}' target='_blank' rel='noopener'>Open the sitemap</a> -
<a href='./index.php?cp=s_help#help-kj_sitemap_seo'>Read the guide</a> -
<a href='https://github.com/kleeja/kj_sitemap_seo/issues' target='_blank' rel='noopener'>Report a problem</a>
";

unset($kj_sitemap_seo_address);

// Plugin Installation function
$kleeja_plugin['kj_sitemap_seo']['install'] = function ($plg_id) {
    kj_sitemap_seo_add_rule();
};

// 2.0.0 deletes the setting of the notification of search engines and its words, with queries of its own:
// delete_config(), delete_olang() and delete_cache() run hooks, or need the groups, and the plugins are still loading.
// $kleeja_plugin isn't a global, Kleeja includes this file in a method, so the closure takes the information above with it
$kleeja_plugin['kj_sitemap_seo']['update'] = function ($old_version, $new_version) use ($kleeja_plugin) {
    global $SQL, $dbprefix;

    if (version_compare($old_version, '2.0.0', '<')) {
        kj_sitemap_seo_delete_old_data();

        // the developer and the description that versions before 2.0.0 were installed with,
        // the list of plugins shows them while the plugin is disabled
        $SQL->build([
            'UPDATE' => "{$dbprefix}plugins",
            'SET' => 'plg_author = :author, plg_dsc = :description',
            'WHERE' => 'plg_name = :name',
            'BIND' => [
                'author' => 'Kleeja.net',
                'description' => kleeja_html_encode(
                    $kleeja_plugin['kj_sitemap_seo']['information']['plugin_description']['en'],
                ),
                'name' => 'kj_sitemap_seo',
            ],
        ]);

        // the cached settings and words still have the ones that were deleted
        $cached = array_merge(glob(PATH . 'cache/data_lang*.php') ?: [], glob(PATH . 'cache/data_config.php') ?: []);

        foreach ($cached as $file) {
            if (file_exists($file)) {
                @unlink($file);
            }
        }
    }

    // sitemap.xml, for a site where the plugin was installed by a Kleeja that couldn't add it
    kj_sitemap_seo_add_rule();
};

// Plugin Uninstallation, function to be called at unistalling
$kleeja_plugin['kj_sitemap_seo']['uninstall'] = function ($plg_id) {
    kj_sitemap_seo_remove_rule();

    // a version before 2.0.0 that was disabled before its files were replaced was never updated
    kj_sitemap_seo_delete_old_data();
};

// Plugin functions
$kleeja_plugin['kj_sitemap_seo']['functions'] = [
    // go.php?go=sitemap, and sitemap.xml with the rule of serve.php
    'default_go_page' => function ($args) {
        global $SQL;

        if (g('go') !== 'sitemap') {
            return;
        }

        kj_sitemap_seo_show();

        $SQL->close();

        exit();
    },

    // the link to the sitemap, in the head that Saaheader() prints
    'Saaheader_links_func' => function ($args) {
        $extra =
            $args['extra'] .
            "\n    " .
            '<link rel="sitemap" type="application/xml" title="Sitemap" href="' .
            htmlspecialchars(kj_sitemap_seo_url()) .
            '">' .
            "\n";

        return compact('extra');
    },

    // the guide of the plugin on the help page of the control panel, its words are in language/help_{code}.php
    'admin_help_guides' => function ($args) {
        $help_guides = $args['help_guides'];
        $words = kj_sitemap_seo_help_words();

        // the name of the plugin is the key, so Kleeja knows that the plugin has its guide, and shows its icon.
        // The plugin has no page of its own, the link of the guide opens the sitemap
        $help_guides['kj_sitemap_seo'] = [
            'group' => 'plugins',
            'title' => $words['KJ_SITEMAP_SEO_HELP_TITLE'],
            'intro' => $words['KJ_SITEMAP_SEO_HELP_INTRO'],
            'link' => htmlspecialchars(kj_sitemap_seo_url()),
            'link_title' => $words['KJ_SITEMAP_SEO_HELP_LINK'],
            // tips and warnings are shown beside the others on wide screens
            'sections' => [
                kj_sitemap_seo_help_section($words, 'features', 'FEATURE'),
                kj_sitemap_seo_help_section($words, 'steps', 'STEP'),
                kj_sitemap_seo_help_section($words, 'faq', 'FAQ'),
                kj_sitemap_seo_help_section($words, 'tips', 'TIP'),
                kj_sitemap_seo_help_section($words, 'warnings', 'WARNING'),
            ],
        ];

        return compact('help_guides');
    },
];

/**
 * special functions
 */

if (!function_exists('kj_sitemap_seo_url')) {
    /**
     * the address of the sitemap that works on every server, sitemap.xml needs the .htaccess of Kleeja
     * @return string
     */
    function kj_sitemap_seo_url()
    {
        global $config;

        return $config['siteurl'] . 'go.php?go=sitemap';
    }

    /**
     * print the sitemap: the 100 latest uploads, with the link that Kleeja gives each of them,
     * and the thumbnail of the images in the image extension of Google
     * @return void
     */
    function kj_sitemap_seo_show()
    {
        global $SQL, $dbprefix;

        $result = $SQL->build([
            'SELECT' => 'f.id, f.name, f.real_filename, f.folder, f.type, f.time',
            'FROM' => "{$dbprefix}files f",
            'ORDER BY' => 'f.id DESC',
            'LIMIT' => '100',
        ]);

        $urls = '';

        while ($file = $SQL->fetch($result)) {
            $is_image = in_array(strtolower(trim($file['type'])), ['gif', 'jpg', 'jpeg', 'bmp', 'png']);

            // Kleeja keeps the names encoded for HTML, a link needs them as they are
            $file_info = [
                '::ID::' => $file['id'],
                '::NAME::' => kleeja_html_decode($file['name']),
                '::DIR::' => kleeja_html_decode($file['folder']),
                '::FNAME::' => kleeja_html_decode($file['real_filename']),
            ];

            $urls .= "  <url>\n";
            $urls .=
                '    <loc>' .
                kj_sitemap_seo_xml_url(kleeja_get_link($is_image ? 'image' : 'file', $file_info)) .
                "</loc>\n";

            if ((int) $file['time'] > 0) {
                $urls .= '    <lastmod>' . date('c', (int) $file['time']) . "</lastmod>\n";
            }

            // after lastmod, the schema of sitemaps puts the extensions last.
            // An image without a thumbnail would be shown as images/not_exists.jpg
            if ($is_image && is_file(PATH . $file_info['::DIR::'] . '/thumbs/' . $file_info['::NAME::'])) {
                $urls .=
                    '    <image:image><image:loc>' .
                    kj_sitemap_seo_xml_url(kleeja_get_link('thumb', $file_info)) .
                    "</image:loc></image:image>\n";
            }

            $urls .= "  </url>\n";
        }

        $SQL->freeresult($result);

        header('Content-Type: application/xml; charset=UTF-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>' .
            "\n" .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' .
            "\n" .
            $urls .
            '</urlset>' .
            "\n";
    }

    /**
     * a link of Kleeja for the sitemap: percent-encoded, as sitemaps want every space and every letter outside of ASCII,
     * then escaped for XML
     * @param  string $url a link written for HTML, as kleeja_get_link() gives it
     * @return string
     */
    function kj_sitemap_seo_xml_url($url)
    {
        $url = preg_replace_callback(
            '/[^A-Za-z0-9\-._~:\/?#@!$&\'()*+,;=%]+/',
            fn($match) => rawurlencode($match[0]),
            htmlspecialchars_decode($url, ENT_QUOTES),
        );

        return htmlspecialchars($url, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    /**
     * the rule of serve.php that answers sitemap.xml, in plugins_rules.php in the folder of Kleeja.
     * Without the rule, or a folder that can't be written, the sitemap is still at go.php?go=sitemap
     * @return void
     */
    function kj_sitemap_seo_add_rule()
    {
        $file = PATH . 'plugins_rules.php';

        // added already, or a file or a folder that can't be written
        if (file_exists($file)) {
            if (!is_writable($file) || str_contains((string) file_get_contents($file), '#start_kj_sitemap_seo')) {
                return;
            }
        } elseif (!is_writable(PATH)) {
            return;
        }

        add_to_serve_rules("'^sitemap\\.xml$' => ['file' => 'go.php', 'args' => 'go=sitemap'],", 'kj_sitemap_seo');
    }

    /**
     * remove the rule of sitemap.xml
     * @return void
     */
    function kj_sitemap_seo_remove_rule()
    {
        // remove_from_serve_rules() writes an empty plugins_rules.php when there is none, and serve.php fails on it
        if (file_exists(PATH . 'plugins_rules.php') && is_writable(PATH . 'plugins_rules.php')) {
            remove_from_serve_rules('kj_sitemap_seo');
        }
    }

    /**
     * the setting, the time and the words of the notification of search engines, which 2.0.0 removed:
     * Google and Bing closed the addresses that it called, and the other services are gone.
     * Direct queries, so it can run while the plugins are loading
     * @return void
     */
    function kj_sitemap_seo_delete_old_data()
    {
        global $SQL, $dbprefix;

        $SQL->build([
            'DELETE' => "{$dbprefix}config",
            'WHERE' => 'name IN (:names)',
            'BIND' => ['names' => ['kj_sitemap_seo_sitemap_ping_enable', 'kj_sitemap_seo_sitemap_ping_time']],
        ]);

        $SQL->build([
            'DELETE' => "{$dbprefix}lang",
            'WHERE' => 'word IN (:words)',
            'BIND' => ['words' => ['KJ_SITEMAP_SEO_SITEMAP_PING_ENABLE', 'CONFIG_KLJ_MENUS_KJ_SITEMAP_SEO']],
        ]);
    }

    /**
     * the words of the guide on the help page, in the language of the admin,
     * a word that the translation misses is shown in English.
     * {sitemap_url} and {robots_url} in them are the addresses of this site
     * @return array
     */
    function kj_sitemap_seo_help_words()
    {
        global $config;

        $words = (array) require __DIR__ . '/language/help_en.php';
        $language = preg_replace('/[^a-z0-9_-]/i', '', (string) ($config['language'] ?? ''));
        $translation = __DIR__ . "/language/help_{$language}.php";

        if ($language !== '' && $language !== 'en' && file_exists($translation)) {
            // in its own line, Prettier drops the brackets of (require $translation) + $words
            $translated = require $translation;
            $words = (array) $translated + $words;
        }

        // robots.txt is read only at the root of the domain, whatever folder Kleeja is in
        $site = parse_url($config['siteurl']);
        $robots_url = empty($site['host'])
            ? '/robots.txt'
            : ($site['scheme'] ?? 'http') .
                '://' .
                $site['host'] .
                (isset($site['port']) ? ':' . $site['port'] : '') .
                '/robots.txt';

        return str_replace(
            ['{sitemap_url}', '{robots_url}'],
            [htmlspecialchars(kj_sitemap_seo_url()), htmlspecialchars($robots_url)],
            $words,
        );
    }

    /**
     * a section of the guide from its numbered words, like KJ_SITEMAP_SEO_HELP_TIP_1, KJ_SITEMAP_SEO_HELP_TIP_2 ..
     * its title, when it has its own, is KJ_SITEMAP_SEO_HELP_TIP_TITLE
     * @param  array  $words
     * @param  string $type  how Kleeja shows it: features, steps, tips, warnings or faq
     * @param  string $name  the name of its words, KJ_SITEMAP_SEO_HELP_{name}_1
     * @return array
     */
    function kj_sitemap_seo_help_section($words, $type, $name)
    {
        $prefix = 'KJ_SITEMAP_SEO_HELP_' . $name;
        $section = ['type' => $type, 'title' => $words[$prefix . '_TITLE'] ?? '', 'items' => []];

        for ($n = 1; isset($words[$prefix . ($type === 'faq' ? '_Q_' : '_') . $n]); $n++) {
            $section['items'][] =
                $type === 'faq'
                    ? ['q' => $words[$prefix . '_Q_' . $n], 'a' => $words[$prefix . '_A_' . $n] ?? '']
                    : $words[$prefix . '_' . $n];
        }

        return $section;
    }
}
