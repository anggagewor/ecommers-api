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

class TokopediaController extends Controller
{
    public function search ( Request $request )
    {
        $scheme       = ( $request->get( 'scheme' ) ) ? $request->get( 'scheme' ) : 'https';
        $device       = ( $request->get( 'device' ) ) ? $request->get( 'device' ) : 'desktop';
        $related      = ( $request->get( 'related' ) ) ? $request->get( 'related' ) : true;
        $catalog_rows = ( $request->get( 'catalog_rows' ) ) ? $request->get( 'catalog_rows' ) : 5;
        $source       = ( $request->get( 'source' ) ) ? $request->get( 'source' ) : 'universe';
        $ob           = ( $request->get( 'ob' ) ) ? $request->get( 'ob' ) : 23;
        $st           = ( $request->get( 'st' ) ) ? $request->get( 'st' ) : 'product';
        $rows         = ( $request->get( 'rows' ) ) ? $request->get( 'rows' ) : 60;
        $start        = ( $request->get( 'page' ) ) ? $request->get( 'page' ) : 1;
        $q            = ( $request->get( 'q' ) ) ? $request->get( 'q' ) : 'redmi note 7';
        $unique_id    = ( $request->get( 'unique_id' ) ) ? $request->get( 'unique_id' ) : '299e303a45174743962ddac3df575815';
        $safe_search  = ( $request->get( 'safe_search' ) ) ? $request->get( 'safe_search' ) : false;
        $url          = 'https://ace.tokopedia.com/search/product/v3?scheme=' . $scheme . '&device=' . $device . '&related=' . $related . '&catalog_rows=' . $catalog_rows . '&source=' . $source . '&ob=' . $ob . '&st=' . $st . '&rows=' . $rows . '&start=' . ( $start * $rows ) . '&q=' . $q . '&unique_id=' . $unique_id . '&safe_search=' . $safe_search;
        ini_set( 'max_execution_time', -1 );
        $opt      = [
            'verify'  => false,
            'headers' => [
                'Host'            => 'ace.tokopedia.com',
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0',
                'Accept'          => 'application/json, text/plain, */*',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Referer'         => 'https://www.tokopedia.com/search?q=redmi+note+7&source=universe&st=product',
                'Origin'          => 'https://www.tokopedia.com',
                'Connection'      => 'keep-alive',
                'TE'              => 'Trailers'
            ]
        ];
        $client   = new Client();
        $response = $client->request( 'GET', $url, $opt );
        $body     = $response->getBody()->getContents();
        return response()->json( json_decode( $body, true ), 200 );
    }
}
