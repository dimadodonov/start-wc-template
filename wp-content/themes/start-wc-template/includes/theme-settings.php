<?php

if ( ! defined( 'ABSPATH')) {
    exit;
}

## Убираем лишнее из Head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

if ( ! function_exists( 'start_wc_template_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function start_wc_template_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Mochalki, use a find and replace
         * to change 'mochalki' to the name of your theme in all the template files.
         */

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'product', 800, 800, array( 'center', 'center'));
        }


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support( 'woocommerce' );
//        add_theme_support( 'wc-product-gallery-zoom' );
//        add_theme_support( 'wc-product-gallery-lightbox' );
//        add_theme_support( 'wc-product-gallery-slider' );
    }
endif;
add_action( 'after_setup_theme', 'start_wc_template_setup' );


## Убираем слово «Рубрика» на страницах рубрик
add_filter( 'get_the_archive_title', 'artabr_remove_name_cat' );
function artabr_remove_name_cat( $title ){
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	}
	return $title;
}

// Пагинация
function wp_corenavi() {
    global $wp_query, $wp_rewrite;
    $pages = '';
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;

    $total = 0; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = 'Назад'; //текст ссылки "Предыдущая страница"
    $a['next_text'] = 'Вперед'; //текст ссылки "Следующая страница"

    if ($max > 1) echo '<div class="pagination">';
    if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
    echo $pages . paginate_links($a);
    if ($max > 1) echo '</div>';
}

/*
 * Удаляем уведомление об обновлении WordPress для всех кроме админа
 */

add_action( 'admin_head', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
        remove_action( 'admin_notices', 'maintenance_nag', 10 );
    }
} );


/*
 * отменим показ выбранного термина наверху в checkbox списке терминов
 */

add_filter( 'wp_terms_checklist_args', 'set_checked_ontop_default', 10 );
function set_checked_ontop_default( $args ) {
    // изменим параметр по умолчанию на false
    if( ! isset($args['checked_ontop']) )
        $args['checked_ontop'] = false;

    return $args;
}
/*
 * Удаление вкладок «Все рубрики» и «Часто используемые» у метабокса рубрик в админке
 */

add_action('admin_print_footer_scripts', 'hide_tax_metabox_tabs_admin_styles', 99);
function hide_tax_metabox_tabs_admin_styles(){
    $cs = get_current_screen();
    if( $cs->base !== 'post' || empty($cs->post_type) ) return; // не страница редактирования записи
    ?>
    <style>
        /* .postbox div.tabs-panel{ max-height:1200px; border:0; } */
        .category-tabs{ display:none; }
    </style>
    <?php
}

/*
 * Удаление файлов license.txt и readme.html для защиты
 */
if( is_admin() && ! defined('DOING_AJAX') ){
    $license_file = ABSPATH .'/license.txt';
    $readme_file = ABSPATH .'/readme.html';

    if( file_exists($license_file) && current_user_can('manage_options') ){
        $deleted = unlink($license_file) && unlink($readme_file);

        if( ! $deleted  )
            $GLOBALS['readmedel'] = 'Не удалось удалить файлы: license.txt и readme.html из папки `'. ABSPATH .'`. Удалите их вручную!';
        else
            $GLOBALS['readmedel'] = 'Файлы: license.txt и readme.html удалены из из папки `'. ABSPATH .'`.';

        add_action( 'admin_notices', function(){  echo '<div class="error is-dismissible"><p>'. $GLOBALS['readmedel'] .'</p></div>'; } );
    }
}


/*
 * Отключаем все стандартные виджеты WordPress
 */

add_action('widgets_init', 'unregister_basic_widgets' );
function unregister_basic_widgets() {
    unregister_widget('WP_Widget_Pages');            // Виджет страниц
    unregister_widget('WP_Widget_Calendar');         // Календарь
    unregister_widget('WP_Widget_Archives');         // Архивы
    unregister_widget('WP_Widget_Links');            // Ссылки
    unregister_widget('WP_Widget_Meta');             // Мета виджет
    unregister_widget('WP_Widget_Search');           // Поиск
    unregister_widget('WP_Widget_Text');             // Текст
    unregister_widget('WP_Widget_Categories');       // Категории
    unregister_widget('WP_Widget_Recent_Posts');     // Последние записи
    unregister_widget('WP_Widget_Recent_Comments');  // Последние комментарии
    unregister_widget('WP_Widget_RSS');              // RSS
    unregister_widget('WP_Widget_Tag_Cloud');        // Облако меток
    unregister_widget('WP_Nav_Menu_Widget');         // Меню
}


/**
 * Отключаем принудительную проверку новых версий WP, плагинов и темы в админке,
 * чтобы она не тормозила, когда долго не заходил и зашел...
 * Все проверки будут происходить незаметно через крон или при заходе на страницу: "Консоль > Обновления".
 *
 * @see https://wp-kama.ru/filecode/wp-includes/update.php
 * @author Kama (https://wp-kama.ru)
 * @version 1.0
 */
if( is_admin() ){
    // отключим проверку обновлений при любом заходе в админку...
    remove_action( 'admin_init', '_maybe_update_core' );
    remove_action( 'admin_init', '_maybe_update_plugins' );
    remove_action( 'admin_init', '_maybe_update_themes' );

    // отключим проверку обновлений при заходе на специальную страницу в админке...
    remove_action( 'load-plugins.php', 'wp_update_plugins' );
    remove_action( 'load-themes.php', 'wp_update_themes' );

    // оставим принудительную проверку при заходе на страницу обновлений...
    //remove_action( 'load-update-core.php', 'wp_update_plugins' );
    //remove_action( 'load-update-core.php', 'wp_update_themes' );

    // внутренняя страница админки "Update/Install Plugin" или "Update/Install Theme" - оставим не мешает...
    //remove_action( 'load-update.php', 'wp_update_plugins' );
    //remove_action( 'load-update.php', 'wp_update_themes' );

    // событие крона не трогаем, через него будет проверяться наличие обновлений - тут все отлично!
    //remove_action( 'wp_version_check', 'wp_version_check' );
    //remove_action( 'wp_update_plugins', 'wp_update_plugins' );
    //remove_action( 'wp_update_themes', 'wp_update_themes' );

    /**
     * отключим проверку необходимости обновить браузер в консоли - мы всегда юзаем топовые браузеры!
     * эта проверка происходит раз в неделю...
     * @see https://wp-kama.ru/function/wp_check_browser_version
     */
    add_filter( 'pre_site_transient_browser_'. md5( $_SERVER['HTTP_USER_AGENT'] ), '__return_true' );
}

## Страницы Настроек
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Настройки сайта',
		'menu_title'	=> 'Настройки сайта',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
    ));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Баннер',
	// 	'menu_title'	=> 'Баннер',
	// 	'parent_slug'	=> 'theme-general-settings',
    // ));
    
	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Theme Header Settings',
	// 	'menu_title'	=> 'Header',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));
	
}

/**
 * Получение лидов из формы contact fork 7
 *
 * @see https://e-integrate.ru/bitrix24-integraciya-s-saytom/
 * @author Anonim (https://e-integrate.ru/bitrix24-integraciya-s-saytom/)
 * @version 1.0
 */
// Вызываем функцию для перехвата данных
add_action( 'wpcf7_mail_sent', 'your_wpcf7_mail_sent_function' );
function your_wpcf7_mail_sent_function( $contact_form ) {
  // Перехватываем данные из Contact Form 7
  $title = $contact_form->title;
  $posted_data = $contact_form->posted_data;

  //Вместо "Контактная форма 1" необходимо указать название вашей контактной формы
  if ('Запрос прайс-листа' == $title ) {
    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    // Далее перехватываем введенные данные в полях Contact Form 7:
    // 1. Перехватываем поле [your-name]
    $firstName = $posted_data['your-name'];
    // 2. Перехватываем поле [your-message]
    // $message = $posted_data['your-message']; 
    $phone = $posted_data['your-tel']; 
    $email = $posted_data['your-email']; 
    $namecompany = 'Название компании ' . $posted_data['your-company'];
    
    // Формируем URL в переменной $queryUrl для отправки сообщений в лиды Битрикс24, где
    // указываем [ваше_название], [идентификатор_пользователя] и [код_вебхука]
    $queryUrl = 'https://ekoprays.bitrix24.ru/rest/1/0kxsio7ixti3ly5x/crm.lead.add.json';
    // Формируем параметры для создания лида в переменной $queryData
    $queryData = http_build_query(array(
      'fields' => array(
        // Устанавливаем название для заголовка лида
        'TITLE' => 'Лид с сайта (www.eco-price.ru.ru) ' . '['.$title.']',
        'NAME' => $firstName,
        'EMAIL' => Array(
            "n0" => Array(
                "VALUE" => $email,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'PHONE' => Array(
            "n0" => Array(
                "VALUE" => $phone,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'COMMENTS' => $namecompany,
        'SOURCE_ID' => 'WEB',
        
      ),
      'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));
    // Обращаемся к Битрикс24 при помощи функции curl_exec
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $queryUrl,
      CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    if (array_key_exists('error', $result)) echo "Ошибка при сохранении лида: ".$result['error_description']."<br/>";
  }

  if ('Заказать образцы' == $title ) {
    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    // Далее перехватываем введенные данные в полях Contact Form 7:
    // 1. Перехватываем поле [your-name]
    $firstName = $posted_data['your-name'];
    // 2. Перехватываем поле [your-message]
    // $message = $posted_data['your-message']; 
    $phone = $posted_data['your-tel']; 
    $email = $posted_data['your-email'];
    
    // Формируем URL в переменной $queryUrl для отправки сообщений в лиды Битрикс24, где
    // указываем [ваше_название], [идентификатор_пользователя] и [код_вебхука]
    $queryUrl = 'https://ekoprays.bitrix24.ru/rest/1/0kxsio7ixti3ly5x/crm.lead.add.json';
    // Формируем параметры для создания лида в переменной $queryData
    $queryData = http_build_query(array(
      'fields' => array(
        // Устанавливаем название для заголовка лида
        'TITLE' => 'Лид с сайта (www.eco-price.ru.ru) ' . '['.$title.']',
        'NAME' => $firstName,
        'EMAIL' => Array(
            "n0" => Array(
                "VALUE" => $email,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'PHONE' => Array(
            "n0" => Array(
                "VALUE" => $phone,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'COMMENTS' => $namecompany,
        'SOURCE_ID' => 'WEB',
        
      ),
      'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));
    // Обращаемся к Битрикс24 при помощи функции curl_exec
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $queryUrl,
      CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    if (array_key_exists('error', $result)) echo "Ошибка при сохранении лида: ".$result['error_description']."<br/>";
  }

  if ('Купить в один клик' == $title ) {
    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    // Далее перехватываем введенные данные в полях Contact Form 7:
    // 1. Перехватываем поле [your-name]
    $firstName = $posted_data['one_click-name'];
    // 2. Перехватываем поле [your-message]
    // $message = $posted_data['your-message']; 
    $phone = $posted_data['one_click-phone']; 
    $email = $posted_data['one_click-email'];
    $product_url = 'Выбранный товар:' . $posted_data[_url];
    
    // Формируем URL в переменной $queryUrl для отправки сообщений в лиды Битрикс24, где
    // указываем [ваше_название], [идентификатор_пользователя] и [код_вебхука]
    $queryUrl = 'https://ekoprays.bitrix24.ru/rest/1/0kxsio7ixti3ly5x/crm.lead.add.json';
    // Формируем параметры для создания лида в переменной $queryData
    $queryData = http_build_query(array(
      'fields' => array(
        // Устанавливаем название для заголовка лида
        'TITLE' => 'Лид с сайта (www.eco-price.ru.ru) ' . '['.$title.']',
        'NAME' => $firstName,
        'EMAIL' => Array(
            "n0" => Array(
                "VALUE" => $email,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'PHONE' => Array(
            "n0" => Array(
                "VALUE" => $phone,
                "VALUE_TYPE" => "WORK",
            ),
        ),
        'COMMENTS' => $product_url,
        'SOURCE_ID' => 'WEB',
        
      ),
      'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));
    // Обращаемся к Битрикс24 при помощи функции curl_exec
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $queryUrl,
      CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    if (array_key_exists('error', $result)) echo "Ошибка при сохранении лида: ".$result['error_description']."<br/>";
  }

  if ('Форма обратной связи' == $title ) {
    $submission = WPCF7_Submission::get_instance();
    $posted_data = $submission->get_posted_data();
    $arNameForm = $submission->get_posted_data();

    // Далее перехватываем введенные данные в полях Contact Form 7:
    $firstName = $posted_data['feedback-name'];
    $phone = $posted_data['feedback-phone']; 
    $email = $posted_data['feedback-email']; 
        
    $webhook = 'https://ekoprays.bitrix24.ru/rest/1/0kxsio7ixti3ly5x/';
    // $webhook = 'https://b24-ds9ope.bitrix24.ru/rest/1/70mt322ncju61b0y/';

    /* Webhook*/
    $queryUrl = $webhook.'crm.lead.add.json'; // Строка обращения к вебхуку
    if(isset($title)) {
        $sourсe = '['.strtolower($title).']';
    }
    else {
        $sourсe = '';
    }

    // REST Api
    $queryData = http_build_query(array( // Передаем данные
        'fields' => array(
            'TITLE' => 'Лид с сайта (www.eco-price.ru.ru) ' . $sourсe,
            'NAME' => $firstName,
            'PHONE' => array(array("VALUE" => preg_replace("/[^,.0-9]/", '', $phone), "VALUE_TYPE" => "WORK" )),
            'PHONE_WORK' => preg_replace("/[^,.0-9]/", '', $phone),
            'EMAIL' => array(array("VALUE" => $email, "VALUE_TYPE" => "WORK" )),
            'EMAIL_WORK' => $email,
            'COMMENTS' =>  'Имя: ' . $phone . ' email: ' . $email .'<br>Лид сгенерирован автоматически. Источник: www.eco-price.ru.<br> ',
            'SOURCE_ID' => 'WEB',
            'ASSIGNED_BY_ID ' => 7,
        )
    ));

    $curl = curl_init(); // метод cURL
        curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);  curl_close($curl);

    $result = json_decode($result, 1);

    if (array_key_exists('error', $result)) echo "Ошибка при сохранении лида: ".$result['error_description']."<br/>";
  }
}