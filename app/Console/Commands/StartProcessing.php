<?php

namespace App\Console\Commands;

use App\Filter;
use App\Result;
use Illuminate\Console\Command;
use App\Tools\Useful;
use phpQuery;

class StartProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start_processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    protected function getDom($url)
    {

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

        return $data;

    }

    protected function getDatas($dom)
    {

        $pq = phpQuery::newDocumentHTML($dom);

        $hentry = $pq->find('.item_table');

        $res = [];
        $x = 0;
        foreach ($hentry as $key => $el) {
            //if ($x == 3) break;

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
            $data_pkey = $pq->attr('data-pkey');
            $data_item_id = $pq->attr('data-item-id');

            $res[$key]['phone'] = Useful::getPhone($data_item_id, $data_pkey);
            $res[$key]['ads_id'] = $data_item_id;
            $x++;
        }

        return $res;

    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // \Log::info('User failed to login.', ['sdfsdf' => 'sdfdsf']);


//        $DBData = Filter::where('status', 'expected')->get(['datas'])->toArray();
//
//
//        foreach ($DBData as $k => $v) {
//
//        }


        //$url = 'https://www.avito.ru/moskva/avtomobili/ford/focus?radius=0&sgtd=5&i=1';
        $query = [
            'brand' => 'ford',
            'model' => 'focus',
            'pmax' => '700000',
            'pmin' => '100000',
        ];
        $page = Filter::where('id', 1)->get(['int_process'])->first()->int_process;

        $url = "https://www.avito.ru/moskva/avtomobili/{$query['brand']}/{$query['model']}?pmax={$query['pmax']}&pmin={$query['pmin']}&radius=0&s_trg=4&i=1&p={$page}&s=1";


        $dom = $this->getDom($url);
        $datas = $this->getDatas($dom);


        \Log::info('$inc' . $page);
        \Log::info('$datas' , $datas);
        \Log::info('$url' . $url);


        if ($datas == null) {
            \Log::info('$datas == null');
            return;
        }

        $inc = Filter::where('id', 1)->increment('int_process');

        $DBData = Result::where([
            'status' => 'yes',
            'user_id' => 1,
            'filter_id' => 1
        ])
            ->get(['ads_id'])->pluck('ads_id')->toArray();


        // ищем новые айдишники
        $diff = array_diff(array_pluck($datas, 'ads_id'), $DBData);

/*
        // оставляем только новые
        $filtered = array_filter(
            $datas,
            function ($key) use ($diff) {
                return in_array($key['ads_id'], $diff);
            }
        );
*/
$filtered = $datas;

        if ($filtered != null) {





            foreach ($filtered as $k => $v)

                $result = Result::create(
                    [
                        'user_id' => '1',
                        'filter_id' => '1',
                        'title' => $v['title'],
                        'desc' => $v['desc'],
                        'link' => 'https://' . $v['src'],
                        'phone' => $v['phone'],
                        'price' => $v['price'],
                        'src' => 'https://avito.ru' . $v['link'],
                        'status' => 'yes',
                        'ads_id' => $v['ads_id'],
                    ]
                );
        }





    }
}
