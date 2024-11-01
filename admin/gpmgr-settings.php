<?php
/**
* Main Menu
*
* @return string
**/
function gpmgr_menu_page()
{
    add_menu_page(
        'Guest Post Manager', 
        'Guest Post Manager', 
        'manage_options', 
        'guest-post-manager', 
        'gpmgr_callback', 
        'dashicons-star-half', 
        5 
    );
}


function gpmgr_callback()
{
    echo '<div class="wrap"><h1>Settings</h1><form method="post" action="options.php" id="gpmgr-settings-form">';
    settings_fields('wpguestPostManager'); 
    do_settings_sections('wpguestPostManager'); 
    submit_button();
    echo '</form>
    <div class="gpmgr-pro-section">
		         <div class="gpmgr-pro-section-inner">
		        	<h2>'.esc_html__("Upgrade to Pro!","guest-post-manager") .'</h2>
		        	<ul>
		        		<li>'.esc_html__("Premium features","guest-post-manager") .'</li>
		        		<li>'.esc_html__("Dedicated Support","guest-post-manager") .'</li>
		        		<li>'.esc_html__("Active Development","guest-post-manager") .'</li>
		        	</ul>
		        	<a target="_blank" href="https://guestpostplugin.com/">'.esc_html__("UPGRADE NOW","guest-post-manager") .'</a>
		        </div>
		    </div>
    </div>';
}

function gpmgr_register_setting()
{
    register_setting(
        'wpguestPostManager', 
        'gpmgr_options', 
        '' 
    );

    add_settings_section(
        'gpmgr_gereral_settings', 
        'General', 
        '', 
        'wpguestPostManager' 
    );

    

    add_settings_field(
        'gpmgr_currency_country',
        'Currency',
        'gpmgr_currency_country_field_html',
        'wpguestPostManager',
        'gpmgr_gereral_settings'
    );
}



function gpmgr_currency_country_field_html()
{
    $gpmgr_options = get_option('gpmgr_options');
    $currency_code_options = gpmgr_get_currencies();
    $cu = '<select id="gpmgr_currency_country" name="gpmgr_options[gpmgr_currency_country]" class="form-control">';
    foreach ($currency_code_options as $key=>$value) {
        $cu .= '<option value="'. $key .'" ' . selected($gpmgr_options['gpmgr_currency_country'], $key, false) .'>'. $value .'</option>';
    }
    echo $cu;
}

function gpmgr_get_currencies()
{
    $currencies = array(
      'AFN' => __('Afghan afghani', 'guest-post-manager'),
      'ALL' => __('Albanian lek', 'guest-post-manager'),
      'DZD' => __('Algerian dinar', 'guest-post-manager'),
      'AOA' => __('Angolan kwanza', 'guest-post-manager'),
      'ARS' => __('Argentine peso', 'guest-post-manager'),
      'AMD' => __('Armenian dram', 'guest-post-manager'),
      'AWG' => __('Aruban florin', 'guest-post-manager'),
      'AUD' => __('Australian dollar', 'guest-post-manager'),
      'BSD' => __('Bahamian dollar', 'guest-post-manager'),
      'BHD' => __('Bahraini dinar', 'guest-post-manager'),
      'BDT' => __('Bangladeshi taka', 'guest-post-manager'),
      'BBD' => __('Barbadian dollar', 'guest-post-manager'),
      'BYR' => __('Belarusian ruble (old)', 'guest-post-manager'),
      'BYN' => __('Belarusian ruble', 'guest-post-manager'),
      'BZD' => __('Belize dollar', 'guest-post-manager'),
      'BMD' => __('Bermudian dollar', 'guest-post-manager'),
      'BTN' => __('Bhutanese ngultrum', 'guest-post-manager'),
      'BTC' => __('Bitcoin', 'guest-post-manager'),
      'BOB' => __('Bolivian boliviano', 'guest-post-manager'),
      'BAM' => __('Bosnia and Herzegovina convertible mark', 'guest-post-manager'),
      'BWP' => __('Botswana pula', 'guest-post-manager'),
      'BRL' => __('Brazilian real', 'guest-post-manager'),
      'BND' => __('Brunei dollar', 'guest-post-manager'),
      'BGN' => __('Bulgarian lev', 'guest-post-manager'),
      'MMK' => __('Burmese kyat', 'guest-post-manager'),
      'BIF' => __('Burundian franc', 'guest-post-manager'),
      'KHR' => __('Cambodian riel', 'guest-post-manager'),
      'CAD' => __('Canadian dollar', 'guest-post-manager'),
      'CVE' => __('Cape Verdean escudo', 'guest-post-manager'),
      'KYD' => __('Cayman Islands dollar', 'guest-post-manager'),
      'XAF' => __('Central African CFA franc', 'guest-post-manager'),
      'CLP' => __('Chilean peso', 'guest-post-manager'),
      'CNY' => __('Chinese yuan', 'guest-post-manager'),
      'COP' => __('Colombian peso', 'guest-post-manager'),
      'KMF' => __('Comorian franc', 'guest-post-manager'),
      'CDF' => __('Congolese franc', 'guest-post-manager'),
      'CRC' => __('Costa Rican col&oacute;n', 'guest-post-manager'),
      'HRK' => __('Croatian kuna', 'guest-post-manager'),
      'CUC' => __('Cuban convertible peso', 'guest-post-manager'),
      'CUP' => __('Cuban peso', 'guest-post-manager'),
      'CZK' => __('Czech koruna', 'guest-post-manager'),
      'DKK' => __('Danish krone', 'guest-post-manager'),
      'DJF' => __('Djiboutian franc', 'guest-post-manager'),
      'DOP' => __('Dominican peso', 'guest-post-manager'),
      'XCD' => __('East Caribbean dollar', 'guest-post-manager'),
      'EGP' => __('Egyptian pound', 'guest-post-manager'),
      'ERN' => __('Eritrean nakfa', 'guest-post-manager'),
      'ETB' => __('Ethiopian birr', 'guest-post-manager'),
      'EUR' => __('Euro', 'guest-post-manager'),
      'FKP' => __('Falkland Islands pound', 'guest-post-manager'),
      'FJD' => __('Fijian dollar', 'guest-post-manager'),
      'GMD' => __('Gambian dalasi', 'guest-post-manager'),
      'GEL' => __('Georgian lari', 'guest-post-manager'),
      'GHS' => __('Ghana cedi', 'guest-post-manager'),
      'GIP' => __('Gibraltar pound', 'guest-post-manager'),
      'GTQ' => __('Guatemalan quetzal', 'guest-post-manager'),
      'GGP' => __('Guernsey pound', 'guest-post-manager'),
      'GNF' => __('Guinean franc', 'guest-post-manager'),
      'GYD' => __('Guyanese dollar', 'guest-post-manager'),
      'HTG' => __('Haitian gourde', 'guest-post-manager'),
      'HNL' => __('Honduran lempira', 'guest-post-manager'),
      'HKD' => __('Hong Kong dollar', 'guest-post-manager'),
      'HUF' => __('Hungarian forint', 'guest-post-manager'),
      'ISK' => __('Icelandic kr&oacute;na', 'guest-post-manager'),
      'INR' => __('Indian rupee', 'guest-post-manager'),
      'IDR' => __('Indonesian rupiah', 'guest-post-manager'),
      'IRR' => __('Iranian rial', 'guest-post-manager'),
      'IRT' => __('Iranian toman', 'guest-post-manager'),
      'IQD' => __('Iraqi dinar', 'guest-post-manager'),
      'ILS' => __('Israeli new shekel', 'guest-post-manager'),
      'JMD' => __('Jamaican dollar', 'guest-post-manager'),
      'JPY' => __('Japanese yen', 'guest-post-manager'),
      'JEP' => __('Jersey pound', 'guest-post-manager'),
      'JOD' => __('Jordanian dinar', 'guest-post-manager'),
      'KZT' => __('Kazakhstani tenge', 'guest-post-manager'),
      'KES' => __('Kenyan shilling', 'guest-post-manager'),
      'KWD' => __('Kuwaiti dinar', 'guest-post-manager'),
      'KGS' => __('Kyrgyzstani som', 'guest-post-manager'),
      'LAK' => __('Lao kip', 'guest-post-manager'),
      'LBP' => __('Lebanese pound', 'guest-post-manager'),
      'LSL' => __('Lesotho loti', 'guest-post-manager'),
      'LRD' => __('Liberian dollar', 'guest-post-manager'),
      'LYD' => __('Libyan dinar', 'guest-post-manager'),
      'MOP' => __('Macanese pataca', 'guest-post-manager'),
      'MKD' => __('Macedonian denar', 'guest-post-manager'),
      'MGA' => __('Malagasy ariary', 'guest-post-manager'),
      'MWK' => __('Malawian kwacha', 'guest-post-manager'),
      'MYR' => __('Malaysian ringgit', 'guest-post-manager'),
      'MVR' => __('Maldivian rufiyaa', 'guest-post-manager'),
      'MRU' => __('Mauritanian ouguiya', 'guest-post-manager'),
      'MUR' => __('Mauritian rupee', 'guest-post-manager'),
      'MXN' => __('Mexican peso', 'guest-post-manager'),
      'MDL' => __('Moldovan leu', 'guest-post-manager'),
      'MNT' => __('Mongolian t&ouml;gr&ouml;g', 'guest-post-manager'),
      'MAD' => __('Moroccan dirham', 'guest-post-manager'),
      'MZN' => __('Mozambican metical', 'guest-post-manager'),
      'NAD' => __('Namibian dollar', 'guest-post-manager'),
      'NPR' => __('Nepalese rupee', 'guest-post-manager'),
      'ANG' => __('Netherlands Antillean guilder', 'guest-post-manager'),
      'TWD' => __('New Taiwan dollar', 'guest-post-manager'),
      'NZD' => __('New Zealand dollar', 'guest-post-manager'),
      'NIO' => __('Nicaraguan c&oacute;rdoba', 'guest-post-manager'),
      'NGN' => __('Nigerian naira', 'guest-post-manager'),
      'KPW' => __('North Korean won', 'guest-post-manager'),
      'NOK' => __('Norwegian krone', 'guest-post-manager'),
      'OMR' => __('Omani rial', 'guest-post-manager'),
      'PKR' => __('Pakistani rupee', 'guest-post-manager'),
      'PAB' => __('Panamanian balboa', 'guest-post-manager'),
      'PGK' => __('Papua New Guinean kina', 'guest-post-manager'),
      'PYG' => __('Paraguayan guaran&iacute;', 'guest-post-manager'),
      'PHP' => __('Philippine peso', 'guest-post-manager'),
      'PLN' => __('Polish z&#x142;oty', 'guest-post-manager'),
      'GBP' => __('Pound sterling', 'guest-post-manager'),
      'QAR' => __('Qatari riyal', 'guest-post-manager'),
      'RON' => __('Romanian leu', 'guest-post-manager'),
      'RUB' => __('Russian ruble', 'guest-post-manager'),
      'RWF' => __('Rwandan franc', 'guest-post-manager'),
      'STN' => __('S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'guest-post-manager'),
      'SHP' => __('Saint Helena pound', 'guest-post-manager'),
      'SAR' => __('Saudi riyal', 'guest-post-manager'),
      'RSD' => __('Serbian dinar', 'guest-post-manager'),
      'SCR' => __('Seychellois rupee', 'guest-post-manager'),
      'SLL' => __('Sierra Leonean leone', 'guest-post-manager'),
      'SGD' => __('Singapore dollar', 'guest-post-manager'),
      'SBD' => __('Solomon Islands dollar', 'guest-post-manager'),
      'SOS' => __('Somali shilling', 'guest-post-manager'),
      'ZAR' => __('South African rand', 'guest-post-manager'),
      'KRW' => __('South Korean won', 'guest-post-manager'),
      'SSP' => __('South Sudanese pound', 'guest-post-manager'),
      'LKR' => __('Sri Lankan rupee', 'guest-post-manager'),
      'SDG' => __('Sudanese pound', 'guest-post-manager'),
      'SRD' => __('Surinamese dollar', 'guest-post-manager'),
      'SZL' => __('Swazi lilangeni', 'guest-post-manager'),
      'SEK' => __('Swedish krona', 'guest-post-manager'),
      'CHF' => __('Swiss franc', 'guest-post-manager'),
      'SYP' => __('Syrian pound', 'guest-post-manager'),
      'TJS' => __('Tajikistani somoni', 'guest-post-manager'),
      'TZS' => __('Tanzanian shilling', 'guest-post-manager'),
      'THB' => __('Thai baht', 'guest-post-manager'),
      'PRB' => __('Transnistrian ruble', 'guest-post-manager'),
      'TTD' => __('Trinidad and Tobago dollar', 'guest-post-manager'),
      'TND' => __('Tunisian dinar', 'guest-post-manager'),
      'TRY' => __('Turkish lira', 'guest-post-manager'),
      'TMT' => __('Turkmenistan manat', 'guest-post-manager'),
      'UAH' => __('Ukrainian hryvnia', 'guest-post-manager'),
      'AED' => __('United Arab Emirates dirham', 'guest-post-manager'),
      'USD' => __('United States dollar', 'guest-post-manager'),
      'VUV' => __('Vanuatu vatu', 'guest-post-manager'),
      'VEF' => __('Venezuelan bol&iacute;var', 'guest-post-manager'),
      'VND' => __('Vietnamese &#x111;&#x1ed3;ng', 'guest-post-manager'),
      'XOF' => __('West African CFA franc', 'guest-post-manager'),
      'YER' => __('Yemeni rial', 'guest-post-manager'),
      'ZMW' => __('Zambian kwacha', 'guest-post-manager')
    );
    return $currencies;
}
add_action('admin_menu', 'gpmgr_menu_page');
add_action('admin_init', 'gpmgr_register_setting');