<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Str;

class TokopediaController extends Controller
{

    public    $link = 'https://www.tokopedia.com';
    private $blacklist_categories = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['Welcome To [Unofficial] Tokopedia Api'];
    }
    // contoh
    // http://localhost:8000/api/tokopedia/categories
    public function categories()
    {
        ini_set('max_execution_time', -1);
        $opts = [
            'http'=>[
                'header'=>"User-Agent:".$this->user_agent."\r\n"
            ]
        ];
        $context            = stream_context_create($opts);
        $str                = "https://www.tokopedia.com/p?nref=chead";
        $dom                = HtmlDomParser::file_get_html( $str, false, $context, 0);
        $links              = $dom->find("a._2xS5-_VI");
        $datas              = [];
        $a                  = 0;
        foreach($links as $link){
            $datas[] = [
                'url' => $link->href,
                'label' => $link->plaintext
            ];
        }
        return $datas;
    }

    // contoh
    // http://localhost:8000/api/tokopedia/category?path=/p/handphone-tablet/handphone?page=9&amp;identifier=handphone-tablet_handphone
    public function category(Request $request)
    {
        ini_set('max_execution_time', -1);
        $opts = [
            'http'=>[
                'header'=>"User-Agent:".$this->user_agent."\r\n"
            ]
        ];
        $context            = stream_context_create($opts);
        $str                = "https://www.tokopedia.com".$request->get('path');
        $dom                = HtmlDomParser::file_get_html( $str, false, $context, 0);
        $cards              = $dom->find("div._33JN2R1i");
        $pages              = $dom->find("div.z8han1fd > span._2AsEdCKK > a.GUHElpkt");
        $datas              = [];
        $a                  = 0;

        foreach($cards as $card)
        {
            $a++;
            $datas[$a] = [
                'name'          => $card->find('h3._18f-69Qp',0)->plaintext,
                'price'         => $card->find('span._3PlXink_ > span',0)->plaintext,
                'seller'        => $card->find('span._2rQtYSxg',0)->plaintext,
                'seller_city'   => $card->find('span._3ME2eGXf',0)->plaintext,
                'url'           => explode('https://www.tokopedia.com',$card->find('a',0)->href)[1],
                'thumbnail'     => null
            ];
        }

        foreach($pages as $page)
        {
            $datas['pages'][] = [
                'url' => $page->href,
                'label' => $page->plaintext
            ];
        }

        return $datas;
    }

    // contoh
    // http://localhost:8000/api/tokopedia/product?path=/androzone777/apple-iphone-xr-64gb-red-garansi-desember-2019-ibox?trkid=f=Ca0000L000P0W0S0Sh,Co0Po0Fr0Cb0_src=other-product_page=1_ob=32_q=_po=1_catid=3055&src=other
    public function product(Request $request)
    {
        ini_set('max_execution_time', -1);
        $opts = [
            'http'=>[
                'header'=>"User-Agent:".$this->user_agent."\r\n"
            ]
        ];
        $context                    = stream_context_create($opts);
        $str                        = "https://www.tokopedia.com".$request->get('path');
        $dom                        = HtmlDomParser::file_get_html( $str, false, $context, 0);
        $description                = $dom->find("div.product-summary__content",0);
        $galleries                  = $dom->find("div.content-img-relative > img");
        $product_infos              = $dom->find("div.rvm-product-info--item_content");
        $product_info_values        = $dom->find("div.rvm-product-info--item_value");
        $datas                      = [];
        $a                          = 0;

        foreach($galleries as $gallery)
        {
            $datas['galleries'][] =  $gallery->src;
        }
        $datas['description']       = trim(preg_replace("/&#?[a-z0-9]{2,8};/i","",$description->plaintext),' ');
        
        foreach($product_infos as $product_info)
        {
            $datas['info'][] =  $product_info->plaintext;
        }
        foreach($product_info_values as $product_info_value)
        {
            $datas['value'][] =  preg_replace("/&#?[a-z0-9]{2,8};/i","",$product_info_value->plaintext);
        }

        $newData = [];
        foreach($datas as $data)
        {
            $newData['name']        = trim($dom->find("h1.rvm-product-title",0)->plaintext,' ');
            $newData['price']        = trim($dom->find("span[itemprop='price']",0)->plaintext,' ');
            $newData['seller']        = trim($dom->find("span[id='shop-name-info']",0)->plaintext,' ');
            $newData['seller_city']        = trim($dom->find("span[itemprop='addressLocality']",0)->plaintext,' ');
            $newData['galleries']   = $datas['galleries'];
            foreach($datas['info'] as $index => $info)
            {
                $newData[$info] = $datas['value'][$index];
            }
            $newData['description'] = $datas['description'];
        }
        return $newData;

    }
    //contoh
    // http://localhost:8000/api/bukalapak/seller?path=/u/ypd_putridarwin
    public function seller(Request $request)
    {
        ini_set('max_execution_time', -1);
        $opts = [
            'http'=>[
                'header'=>"User-Agent:".$this->user_agent."\r\n"
            ]
        ];
        $context           = stream_context_create($opts);
        $str               = "https://www.bukalapak.com".$request->get('path');
        $dom               = HtmlDomParser::file_get_html( $str, false, $context, 0);
    }
}
