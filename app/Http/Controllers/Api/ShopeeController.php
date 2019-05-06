<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShopeeController extends Controller
{
    
    public  $link                 = 'https://shopee.co.id';
    private $blacklist_categories = [];
    
    public function search ( Request $request )
    {
        $by      = ( $request->get( 'by' ) ) ? $request->get( 'by' ) : 'sales';
        $keyword = ( $request->get( 'keyword' ) ) ? $request->get( 'keyword' ) : 'flash%20disk';
        $newest  = ( $request->get( 'newest' ) ) ? $request->get( 'newest' ) : 0;
        $order   = ( $request->get( 'order' ) ) ? $request->get( 'order' ) : 'desc';
        ini_set( 'max_execution_time', -1 );
        $url      = 'https://shopee.co.id/api/v2/search_items/?by=' . $by . '&keyword=' . $keyword . '&limit=50&newest=' . $newest . '&order=' . $order . '&page_type=search';
        $opt      = [
            'verify'  => false,
            'headers' => [
                'Host'             => 'shopee.co.id',
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0',
                'Accept'           => '*/*',
                'Accept-Language'  => 'en-US,en;q=0.5',
                'Accept-Encoding'  => 'gzip, deflate, br',
                'Referer'          => 'https://shopee.co.id/search?keyword=flash%20disk&page=0&sortBy=sales',
                'X-Requested-With' => 'XMLHttpRequest',
                'X-API-SOURCE'     => 'pc',
                'If-None-Match-'   => '55b03-42f8203158564982513dc0e3e2d9ff6d',
                'Connection'       => 'keep-alive',
                'Cookie'           => 'SPC_IA=-1; SPC_EC=-; SPC_F=XHC4yMQFlDxx6H2LImaYkmwXRUfS85Zd; REC_T_ID=b073442c-6f0c-11e9-a760-525400020fe1; SPC_T_ID="oOPPjCPOrerkcOlzNtyiSwBs6njlxrOKzTu9pupc0OKZi1rmSdo5kypzZe90o4ITb3PJWyrfIpoo5uSicw//nMELFAarf+vmLMK4NoX9n1Q="; SPC_SI=j569uhn4iouo48myvq2ighqsmfatst5b; SPC_U=-; SPC_T_IV="eEJMyo5wGWvE9WDY6V/02Q=="; _gcl_au=1.1.1813856797.1557044376; csrftoken=luFBvMsxFFdWx8gZ1vyounQ0LGgQoRj8; REC_MD_20=1557112518; REC_MD_14=1557112528; welcomePkgShown=true; bannerShown=true; REC_MD_25=1557112545; REC_MD_5_0f5ed6c8=1557112970_0_60_0_62',
                'If-None-Match'    => "db3fe075b73a0e523ec7996b208e4b40;gzip",
                'TE'               => 'Trailers',
            ]
        ];
        $client   = new Client();
        $response = $client->request( 'GET', $url, $opt );
        $body     = $response->getBody()->getContents();
        return response()->json( json_decode( $body, true ), 200 );
        
    }
    
    public function read ( $item_id, $shop_id )
    {
        ini_set( 'max_execution_time', -1 );
        $url      = 'https://shopee.co.id/api/v2/item/get?itemid=' . $item_id . '&shopid=' . $shop_id;
        $opt      = [
            'verify'  => false,
            'headers' => [
                'Host'             => 'shopee.co.id',
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0',
                'Accept'           => '*/*',
                'Accept-Language'  => 'en-US,en;q=0.5',
                'Accept-Encoding'  => 'gzip, deflate, br',
                'Referer'          => 'https://shopee.co.id/search?keyword=flash%20disk&page=0&sortBy=sales',
                'X-Requested-With' => 'XMLHttpRequest',
                'X-API-SOURCE'     => 'pc',
                'If-None-Match-'   => '55b03-42f8203158564982513dc0e3e2d9ff6d',
                'Connection'       => 'keep-alive',
                'Cookie'           => 'SPC_IA=-1; SPC_EC=-; SPC_F=XHC4yMQFlDxx6H2LImaYkmwXRUfS85Zd; REC_T_ID=b073442c-6f0c-11e9-a760-525400020fe1; SPC_T_ID="oOPPjCPOrerkcOlzNtyiSwBs6njlxrOKzTu9pupc0OKZi1rmSdo5kypzZe90o4ITb3PJWyrfIpoo5uSicw//nMELFAarf+vmLMK4NoX9n1Q="; SPC_SI=j569uhn4iouo48myvq2ighqsmfatst5b; SPC_U=-; SPC_T_IV="eEJMyo5wGWvE9WDY6V/02Q=="; _gcl_au=1.1.1813856797.1557044376; csrftoken=luFBvMsxFFdWx8gZ1vyounQ0LGgQoRj8; REC_MD_20=1557112518; REC_MD_14=1557112528; welcomePkgShown=true; bannerShown=true; REC_MD_25=1557112545; REC_MD_5_0f5ed6c8=1557112970_0_60_0_62',
                'If-None-Match'    => "db3fe075b73a0e523ec7996b208e4b40;gzip",
                'TE'               => 'Trailers',
            ]
        ];
        $client   = new Client();
        $response = $client->request( 'GET', $url, $opt );
        $body     = $response->getBody()->getContents();
        return response()->json( json_decode( $body, true ), 200 );
    }
}
