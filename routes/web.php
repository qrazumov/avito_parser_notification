<?php

use App\Filter;
use App\Result;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Http\Resources\Filter as FilterResource;
use App\Http\Resources\Result as ResultResource;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home/{any}', 'SpaController@index')->where('any', '.*');




function f($id, $key) {


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
    $pkey = $r;

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

    $output_file = storage_path("app/phones/$id.png");;
    $src = base64_to_jpeg($data, $output_file);

   $tes = (new TesseractOCR($src))->run();
    unlink($src);
    return $tes;


}


function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ count($data) - 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}



Route::get('/surl', function () {

    /*  $url = "http://jcredit-online.ru";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
      curl_setopt($ch, CURLOPT_URL, $url);
      $data = curl_exec($ch);
      curl_close($ch);
  // Установка конфигурации
      $config = array(
          'indent'         => true,
          'output-xhtml'   => true,
          'wrap'           => 200);
  // Tidy
      $tidy = new tidy;
      $tidy->parseString($data, $config, 'utf8');
      $tidy->cleanRepair();
  // Вывод

      $doc = new DOMDocument;
  // Не хотим возиться с пробелами
      $doc->preserveWhiteSpace = false;
      $doc->loadHTML($tidy->value);
      //$container = $doc->getElementById("tooltipsel");
      //dd($container);
     // $container = $doc->getElementById("content");
      $xpath = new DOMXPath($doc);
  // Начинаем с корневого элемента
      $query = '/html[1]/body[1]/div[3]/div[1]/div[3]/div[1]/div[3]/table[1]/tbody[1]/tr/td[3]';
      $entries = $xpath->query($query);
      $string = trim($entries[0]->nodeValue);
      //dd($string);
      $arr  = [];
      foreach ($entries as $entry) {

           $arr[] =  trim($entry->nodeValue);
      }
      // dd($xpath);
      dd($arr);
      */
//
//
    $url = "https://www.avito.ru/moskva/avtomobili/ford/focus?radius=0&sgtd=5&i=1";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        [
           'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.3',
            'authority: www.avito.ru',
            'method: GET',
           'path: scheme',

            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
           'cache-control: max-age=0',
            'cookie: u=2b3vgjxk.1cwbpfr.fv1chopqye; cto_lwid=1a7c35f2-6e2a-4c34-898e-fa5492d38ff9; f=5.673c10cb09ba31f34b5abdd419952845a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e9a68643d4d8df96e94f9572e6986d0c624f9572e6986d0c624f9572e6986d0c62ba029cd346349f36c1e8912fd5a48d02c1e8912fd5a48d0246b8ae4e81acb9fa143114829cf33ca746b8ae4e81acb9fa46b8ae4e81acb9fae992ad2cc54b8aa8baed66fa7192f00c615ab5228c34303140e3fb81381f3591fed88e598638463b2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eab2da10fb74cac1eabfdb229eec3b9ed9a0c79affd4e5f1d11162fe9fd7c8e9767256ca0662a0c8001105947661215734037863d73204ac56663da295dfafc78fb93ac8a6e76285c094ea5c3b0d36cf3596641b13d24a0e6636028692b27942282685428d00dc691fa4b5b030516527c4378ba5f931b08c66a7ad1a5728027cbff5c9369ca3bcdb0323de19da9ed218fe23de19da9ed218fe2f2bb1b48338cc4bccf1620227773a645; _ym_uid=1536330524561471760; _ym_d=1536330524; _ga=GA1.2.1250132584.1536330524; _gid=GA1.2.1416083980.1536330524; buyer_selected_search_radius0=0; __gads=ID=8d9d5531c15df8e9:T=1536351056:S=ALNI_MZGoLfwZXBOPFfcRNb1b-HaAqL64g; sessid=83df9a8909bd27cbd38690603c3f0799.1536362724; dfp_group=82; rheftjdd=rheftjddVal; _ym_isad=2; is_adblock=false; v=1536405319; _nfh=ef048497584fcdfe2a3d9bdf4c193484; nps_sleep=1; _gat_UA-2546784-1=1; sx=H4sIAAAAAAACA2WT0Y6jMAxF%2F4XneTDEUDN%2FQw24JUAAQ8N01H9fIy27nV0JhYdYx773Ot9JdRs1BNxo8RJA7RMhUaLk8zt5JJ9JPYzzXIe8WGIIRB4QvQqTkJJ4TT6SJvlMc1cgQlrS6yNx1ezpPrXDvSDFSKgSNAr6E%2BmG%2BjnI3i59xtG6e284oEiR7SdvyLQoi8KQaebvw%2B2yr8VMrIoavQIFiCeS2nJvhjtcJxse1SPGSBAiqvGt7H9k42jI9z7tOpNjvBgAIpDnE9lvwbW3SbOVIwhbAQZA5RDECuEn8nIIT%2Fvb8oBU91hG8oKHSWz64USmzTOtG%2BvnVzYomzkQhcgsDSL4hiwxK0pDXqdpaOtnt4zRzGdvrjMEz3%2B89NLcr5BX6i23EBgO4ei9QRWQ35Aud%2Fkh%2FNqX2zBiN5UsETFEQPBiuZ5I3efeuUu3j0hoU9otWE2002x%2FR2IJRXokPn5Rxdnslpm9KTeP0Ma0KH8jS3bTCjq3qzVEWweBcFipaJ0D%2FbNEzpDVtj8lkz1fWVkM6dVS0L9edt1zzMd8HS4oJpkk2laCJ2t%2BOP8DWWSZIfOxz8K1ftSEbNEEVhuFbO9O5JTzFq9jtY1oFBMbGW2TVI%2Bnwe%2FCy8w5fL1%2BAYrVX50%2FAwAA; abp=0; bltsr=0',
            'upgrade-insecure-requests: 1',
        ]);
    $data = curl_exec($ch);
    curl_close($ch);
//// Установка конфигурации
//    $config = array(
//        'indent'         => true,
//        'output-xhtml'   => true,
//        'wrap'           => 200);
//// Tidy
//    $tidy = new tidy;
//    $tidy->parseString($data, $config, 'utf8');
//    $tidy->cleanRepair();
//// Вывод
//
//    $doc = new DOMDocument;
//    libxml_use_internal_errors(true);
//// Не хотим возиться с пробелами
//    $doc->preserveWhiteSpace = false;
//    $doc->loadHTML($tidy->value);
//    //$container = $doc->getAttribute('itemprop')->nodeValue;
//    //dd($container);
//    // $container = $doc->getElementById("content");
//    $xpath = new DOMXPath($doc);
//// Начинаем с корневого элемента
//    //$query = '/html[1]/body[1]/div[5]/div[1]/div[5]/div[2]/div[2]/div[1]/div[4]/div[2]/div[2]/div[1]/span[2]';
//    $query = ".//*[@itemprop='price']";
//    $entries = $xpath->query($query);
//    //dd($entries[0]->attributes[2]->value);
//    //$string = trim($entries[0]->parentNode);
//    //dd($entries[0]->parentNode->parentNode);
//    $arr  = [];
//    foreach ($entries as $entry) {
//
//        $arr[] =  trim($entry->attributes[2]->value);
//    }
//    // dd($xpath);
//   // dd($arr);


    $pq = phpQuery::newDocumentHTML($data);

   // dd($pq->find('.item-slider-image[style]')->eq(0)->attr('style'));
    $hentry = $pq->find('.item_table');
    $res = [];

$x = 0;
    foreach ($hentry as $key => $el) {
        $pq = pq($el); // Это аналог $ в jQuery
        $res[$key]['title'] = $pq->find('h3 span')->text();
        $res[$key]['price'] = $pq->find('span.price')->attr('content');
        $res[$key]['desc'] = trim($pq->find('.specific-params')->text());
        $res[$key]['link'] = $pq->find('a.item-description-title-link')->attr('href');


       $data_srcpath = 'data-srcpath';
       $style = 'style';
        $str = $pq->find("[$data_srcpath]")->eq(0)->attr("$data_srcpath") == null
            ? $pq->find(".item-slider-image[$style]")->eq(0)->attr("$style")
            : $pq->find("[$data_srcpath]")->eq(0)->attr("$data_srcpath");

       $re = '/\/\/(.*[^");])/m';
       $str = preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
       $res[$key]['src'] = isset($matches[0][1]) ? $matches[0][1] : 'no image';
        $data_pkey= $pq->attr('data-pkey');
        $data_item_id= $pq->attr('data-item-id');
        if($x == 3) break;
       $res[$key]['phone'] = f($data_item_id, $data_pkey);
$x++;

 //Print the entire match result
    //var_dump($matches);
    }


    dd($res);







});


Route::get('/', function () {
    /*$xx = 5;
    $fsd = $xx + 5;
    dd(extension_loaded('xdebcug'));
    dd(\DB::table('playground')->get()->pluck('type')->toArray());

    */

    return view('welcome');
});


Route::get('/index', function (Faker $faker) {

//    for ($i=0; $i < 10000; $i++) {
//
//        $user = App\User::create(
//            [
//                'name' => $faker->name,
//                'email' => $faker->unique()->safeEmail . rand(1, 99999),
//                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
//                'article_id' => $faker->unique()->numberBetween(15001, 99999),
//            ]
//        );
//
//    }


    //echo \DB::table('users')->whereIn('article_id', [5226, 7508, 99, 2640, 7963, 2671, 14300, 94479, 7494])->get();
//        for ($i=0; $i < 500; $i++) {
//
//            //\DB::table('users')->where('article_id', $faker->unique()->numberBetween(1500, 99999))->get();
//
//
//    }

    //echo \DB::table('users')->where('email', 'stiedemann.derrick@example.org95135')->get();
    // echo \DB::table('users')->where(['email' =>'urath@example.org49568', 'article_id' =>'60556'])->get();


    dd(1 + '12ромаебатьврот');


});


Route::get('/oauth-clients', function () {
    return view('oauth_clients');
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://laravel.d/callback',
        'response_type' => 'code',
        'scope' => 'place-orders check-status',
    ]);

    return redirect('http://laravel.d/oauth/authorize?' . $query);
});


Route::get('/callback', function (Request $request) {
    $http = new \GuzzleHttp\Client;

    $response = $http->post('http://laravel.d/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'frqlvvAdJwP5pYT8gtZpKFzos3AdUxck1DN02o6c',
            'redirect_uri' => 'http://laravel.d/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string)$response->getBody(), true);
});


Route::get('/information', function () {
    echo phpinfo();
});
Route::get('/db', function () {
    //dd(\DB::connection()->getPdo()->query('SELECT one()'));
    //dd(\DB::raw('SELECT one()'));
    dd(\DB::select('SELECT other[2] FROM public.playground where equip_id=1 ORDER BY equip_id ASC ')[0]->other);
    //dd(\DB::table('playground')->get()->pluck('type')->toArray());

});
Route::get('/gzip', function () {

    return view('gzip');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/test', function () {

    //dd(App\User::find(1)->filters);
    //dd(App\User::find(1)->results);
    //dd(\App\Filter::where('status', 'expected')->get(['datas'])->toJson());

//    $arr = [['id' => 1, 'name' => 'sdf'], ['id' => 2, 'name' => 'sdffsdf'], ['id' => 3, 'name' => 'sdsdfdf']];
//    $arr2 = [2, 3];
//    //dd(array_diff($arr, $arr2));
//
//    //dd(array_pluck([ ['id' => 1, 'str' => 'sf'],['id' => 2, 'str' => 'sdsfdf']], 'id'));
//
//    $filtered = array_filter(
//        $arr,
//        function ($key) use ($arr2){
//            return !in_array($key['id'], $arr2);
//        }
//    );
//    dd($filtered);



    //dd(Filter::where('id', 1)->get(['int_process'])->first()->int_process);
    dd(Filter::where('id', 1)->increment('int_process'));
});




Route::get('/filters', function () {
    //return new FilterResource(App\Filter::find(1));
    $user = Auth::user();
    return FilterResource::collection($user->filters);
});


Route::get('results/{id}', function ($id) {
    //return new FilterResource(App\Filter::find(1));
    $user = Auth::user();
    return ResultResource::collection($user->results->where('filter_id', $id));
});