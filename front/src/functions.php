<?php
include('../../../../inc/includes.php');


class SkynetWidget
{

    public static string $script = '<script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#420083&token=&position=bottom_right" defer></script>';


    public static function getWidgetInfo()
    {
        global $CFG_GLPI;

        $username = '';

        if (\Session::getLoginUserID()) {
            $username = $_SESSION['glpiactiveprofile']['name'];
        }

        $full_url = $CFG_GLPI['url_base'];
        $domain = parse_url($full_url, PHP_URL_HOST);

        $now = new DateTime('now', new DateTimeZone('UTC'));
        $dateTime = $now->format('Y-m-d\TH:i:sO');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ada.skynettechnologies.us/api/add-user-domain',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'name'              => $username,
                'company_name'      => '',
                'website'           => base64_encode($domain),
                'package_type'      => 'free-widget',
                'start_date'        => $dateTime,
                'end_date'          => '',
                'price'             => '',
                'discount_price'    => '0',
                'platform'          => 'Craft',
                'api_key'           => '',
                'is_trial_period'   => '',
                'is_free_widget'    => '1',
                'bill_address'      => '',
                'country'           => '',
                'state'             => '',
                'city'              => '',
                'post_code'         => '',
                'transaction_id'    => '',
                'subscr_id'         => '',
                'payment_source'    => ''
            ),
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // ⚠️ Don't use false in production

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public static function fetchWidgetSettings()
    {

        global $CFG_GLPI;

        $full_url = $CFG_GLPI['url_base'];
        $domain = parse_url($full_url, PHP_URL_HOST);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ada.skynettechnologies.us/api/widget-settings',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('website_url' => $domain),
        ));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);

        if (empty($res['Data'])) {
            self::getWidgetInfo();
            sleep(1);
            self::fetchWidgetSettings();
        } else {
            return json_encode($res['Data']);
        }
    }
}
