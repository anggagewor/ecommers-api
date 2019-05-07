<?php
/**
 * Licensed under the MIT/X11 License (http://opensource.org/licenses/MIT)
 * Copyright 2019 - Angga Purnama <angga@mifx.com>
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class BukalapakController extends Controller
{
    public function getCategory ()
    {
        ini_set( 'max_execution_time', -1 );
        $opts    = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $context = stream_context_create( $opts );
        $str     = "https://www.bukalapak.com";
        $dom     = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $display = $dom->find( "head meta[name='oauth-access-token']", 0 )->content;;
        $url      = 'https://api.bukalapak.com/categories?access_token=' . $display;
        $opt      = [
            'verify'  => false,
            'headers' => [
                "Host"            => "api.bukalapak.com",
                "User-Agent"      => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0",
                "Accept"          => "application/vnd.bukalapak.v4+json",
                "Accept-Language" => "en-US,en;q=0.5",
                "Accept-Encoding" => "gzip, deflate, br",
                "Referer"         => "https://www.bukalapak.com/products?utf8=%E2%9C%93&source=navbar&from=omnisearch&search_source=omnisearch_organic&search%5Bhashtag%5D=&search%5Bkeywords%5D=redmi+note+3",
                "Origin"          => "https://www.bukalapak.com",
                "Connection"      => "keep-alive",
                "TE"              => "Trailers",
            ]
        ];
        $client   = new Client();
        $response = $client->request( 'GET', $url, $opt );
        $body     = $response->getBody()->getContents();
        return response()->json( json_decode( $body, true ), 200 );
    }
    
    public function getProductByCategory ( $category_id, Request $request )
    {
        ini_set( 'max_execution_time', -1 );
        $limit   = ( $request->get( 'limit' ) ) ? $request->get( 'limit' ) : 20;
        $page    = ( $request->get( 'page' ) ) ? $request->get( 'page' ) : 1;
        $offset  = $page * $limit;
        $opts    = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $context = stream_context_create( $opts );
        $str     = "https://www.bukalapak.com";
        $dom     = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $display = $dom->find( "head meta[name='oauth-access-token']", 0 )->content;;
        $url      = 'https://api.bukalapak.com/products?category_id=' . $category_id . '&limit=' . $limit . '&offset=' . $offset . '&access_token=' . $display;
        $opt      = [
            'verify'  => false,
            'headers' => [
                "Host"            => "api.bukalapak.com",
                "User-Agent"      => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0",
                "Accept"          => "application/vnd.bukalapak.v4+json",
                "Accept-Language" => "en-US,en;q=0.5",
                "Accept-Encoding" => "gzip, deflate, br",
                "Referer"         => "https://www.bukalapak.com/products?utf8=%E2%9C%93&source=navbar&from=omnisearch&search_source=omnisearch_organic&search%5Bhashtag%5D=&search%5Bkeywords%5D=redmi+note+3",
                "Origin"          => "https://www.bukalapak.com",
                "Connection"      => "keep-alive",
                "TE"              => "Trailers",
            ]
        ];
        $client   = new Client();
        $response = $client->request( 'GET', $url, $opt );
        $body     = $response->getBody()->getContents();
        return response()->json( json_decode( $body, true ), 200 );
    }
}
