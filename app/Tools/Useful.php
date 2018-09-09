<?php
namespace App\Tools;

use thiagoalessio\TesseractOCR\TesseractOCR;


class Useful
{

    protected static function getPkey($id, $key) {

        preg_match_all("/[\da-f]+/", $key, $pre);
        $pre = $id % 2 == 0 ? array_reverse($pre[0]) : $pre[0];
        $mixed = join('', $pre);
        $s = strlen($mixed);
        $r = '';
        for ($k = 0; $k < $s; ++$k) {
            if ($k % 3 == 0) {
                $r .= substr($mixed, $k, 1);
            }
        }
        return $pkey = $r;

    }

    protected static function recognizeText($id, $data) {

        $output_file = storage_path("app/phones/$id.png");;
        $src = self::base64_to_jpeg($data, $output_file);

        $tes = (new TesseractOCR($src))->run();
        unlink($src);
        return $tes;

    }



    protected static function sendReq($id, $pkey) {

        $url = "https://www.avito.ru/items/phone/$id?pkey=$pkey&h=36&vsrc=s";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.3',
                'authority: www.avito.ru',
                'method: GET',
                "path: /items/phone/$id?pkey=$pkey&h=36&vsrc=s",
                'scheme: https',
                'accept: */*',
                'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'cache-control: max-age=0',
                'cookie: u=2b3vgjxk.1cwbpfr.fv1chopqye; cto_lwid=1a7c35f2-6e2a-4c34-898e-fa5492d38ff9; f=5.673c10cb09ba31f34b5abdd419952845a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e94f9572e6986d0c624f9572e6986d0c624f9572e6986d0c62ba029cd346349f36c1e8912fd5a48d02c1e8912fd5a48d0246b8ae4e81acb9fa143114829cf33ca746b8ae4e81acb9fa46b8ae4e81acb9fae992ad2cc54b8aa8baed66fa7192f00c615ab5228c34303140e3fb81381f3591fed88e598638463b2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eabfdb229eec3b9ed9a0c79affd4e5f1d11162fe9fd7c8e9767256ca0662a0c8001105947661215734037863d73204ac56663da295dfafc78fb93ac8a6e76285c094ea5c3b0d36cf3596641b13d24a0e6636028692b27942282685428d00dc691fa4b5b030516527c4378ba5f931b08c66a7ad1a5728027cbff5c9369ca3bcdb0323de19da9ed218fe23de19da9ed218fe2f2bb1b48338cc4bccf1620227773a645; _ym_uid=1536330524561471760; _ym_d=1536330524; _ga=GA1.2.1250132584.1536330524; _gid=GA1.2.1416083980.1536330524; buyer_selected_search_radius0=0; __gads=ID=8d9d5531c15df8e9:T=1536351056:S=ALNI_MZGoLfwZXBOPFfcRNb1b-HaAqL64g; sessid=83df9a8909bd27cbd38690603c3f0799.1536362724; dfp_group=82; rheftjdd=rheftjddVal; _ym_isad=2; is_adblock=false; v=1536405319; _nfh=ef048497584fcdfe2a3d9bdf4c193484; nps_sleep=1; _gat_UA-2546784-1=1; sx=H4sIAAAAAAACA2WT0Y6jMAxF%2F4XneTDEUDN%2FQw24JUAAQ8N01H9fIy27nV0JhYdYx773Ot9JdRs1BNxo8RJA7RMhUaLk8zt5JJ9JPYzzXIe8WGIIRB4QvQqTkJJ4TT6SJvlMc1cgQlrS6yNx1ezpPrXDvSDFSKgSNAr6E%2BmG%2BjnI3i59xtG6e284oEiR7SdvyLQoi8KQaebvw%2B2yr8VMrIoavQIFiCeS2nJvhjtcJxse1SPGSBAiqvGt7H9k42jI9z7tOpNjvBgAIpDnE9lvwbW3SbOVIwhbAQZA5RDECuEn8nIIT%2Fvb8oBU91hG8oKHSWz64USmzTOtG%2BvnVzYomzkQhcgsDSL4hiwxK0pDXqdpaOtnt4zRzGdvrjMEz3%2B89NLcr5BX6i23EBgO4ei9QRWQ35Aud%2Fkh%2FNqX2zBiN5UsETFEQPBiuZ5I3efeuUu3j0hoU9otWE2002x%2FR2IJRXokPn5Rxdnslpm9KTeP0Ma0KH8jS3bTCjq3qzVEWweBcFipaJ0D%2FbNEzpDVtj8lkz1fWVkM6dVS0L9edt1zzMd8HS4oJpkk2laCJ2t%2BOP8DWWSZIfOxz8K1ftSEbNEEVhuFbO9O5JTzFq9jtY1oFBMbGW2TVI%2Bnwe%2FCy8w5fL1%2BAYrVX50%2FAwAA; abp=0; bltsr=0',
                'referer: https://www.avito.ru/moskva/avtomobili/ford/focus?radius=0&sgtd=5&i=1 ',
            ]);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;


    }


   protected static function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen( $output_file, 'wb' );
        $data = explode( ',', $base64_string );
        fwrite( $ifp, base64_decode( $data[ count($data) - 1 ] ) );
        fclose( $ifp );
        return $output_file;
    }



    /**
     * @param $data_item_id
     * @param $data_pkey
     *
     * Точка входа
     */
    public static function getPhone($data_item_id, $data_pkey) {

        $pkey = self::getPkey($data_item_id, $data_pkey);

        $data = self::sendReq($data_item_id, $pkey);

        $strPhone = self::recognizeText($data_item_id, $data);

        return $strPhone;


    }



}