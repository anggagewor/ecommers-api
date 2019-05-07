<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Sunra\PhpSimple\HtmlDomParser;

class BukalapakController extends Controller
{
    
    public  $link = 'https://www.bukalapak.com';
    private $blacklist_categories
                  = [
            'tentang_bukalapak',
            'aturan_penggunaan',
            'kebijakan_privasi',
            'penghargaan',
            'karir_di_bukalapak',
            'identitas_brand',
            'vulnerability_reports',
            'blog_bukalapak',
            'affiliate_program',
            'timnas_indonesia',
            'f_a_q(_tanya_jawab)',
            'cara_belanja',
            'pembayaran',
            'jaminan_aman',
            'halaman_tag',
            'produk_terkini',
            'jasa_pengadaan',
            'buka_review',
            'cara_berjualan',
            'keuntungan_jualan',
            'indeks_merek',
            'direktori_pelapak',
            'beriklan_di_buka_iklan',
            '{{_c.name}}',
            'e-_voucher&_tiket_b_a_r_u',
            'pulsa_prabayar',
            'pulsa_pascabayar',
            'paket_data',
            'listrik_prabayar',
            'listrik_pascabayar',
            'voucher_game',
            'tiket_kereta',
            'tiket_pesawat',
            'zakat_profesi',
            'b_p_j_s_kesehatan',
            'air_p_d_a_m',
            'event_b_a_r_u',
            'tiket_bus_b_a_r_u',
            'kupon_b_a_r_u',
            'angsuran_kredit_b_a_r_u',
            'telkom_b_a_r_u',
            'e-_samsat(_p_k_b)_jabar_b_a_r_u',
            'pajak_bumi_dan_bangunan_b_a_r_u',
            'promo',
            'buka_mobil',
            'buka_motor',
            'buka_iklan_shopping',
            'buka_iklan_facebook',
            'travel_hiburan',
            'tiket_voucher_lainnya',
        
        ];
    
    public function index ()
    {
        return [ 'Welcome To [Unofficial] Bukalapak Api' ];
    }
    
    public function categories ()
    {
        ini_set( 'max_execution_time', -1 );
        $opts       = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $context    = stream_context_create( $opts );
        $str        = "https://www.bukalapak.com/c?from=navbar_icon";
        $dom        = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $categories = $dom->find( "ul.c-list-ui > li.c-list-ui__item > a.c-list-ui__link" );
        $datas      = [];
        $a          = 0;
        foreach ( $categories as $category ) {
            $a++;
            $cat_name = Str::snake( preg_replace( "/&#?[a-z0-9]{2,8};/i", "", $category->plaintext ) );
            if ( !in_array( $cat_name, $this->blacklist_categories ) ) {
                $datas[ $cat_name ][ 'label' ] = trim( $category->plaintext, ' ' );
                $datas[ $cat_name ][ 'url' ]   = $category->href;
            }
        }
        
        return $datas;
    }
    
    // contoh
    // http://localhost:8000/api/bukalapak/category?path=/c/elektronik/televisi?from=category_all&section=category_list
    public function category ( Request $request )
    {
        ini_set( 'max_execution_time', -1 );
        $opts           = [
            'http' => [
                'header'     => "Accept-language: en-US,en;q=0.5\r\n" . "Cookie: identity=5b23dd7f5b4c1bf66724c57aa30dcf81; browser_id=7ee48ad813e5798c1240920a28bec32f; _gcl_au=1.1.838346444.1555320378; __auc=7300045b16a8b666b0ef0eec21b; session_id=2bd83cb1b128e90c7d3d9fcf80d9222d; lskjfewjrh34ghj23brjh234=TlUyTXpCRVZIV1IrbXFYdm1hUk9vbnNHOGJ6a3VOS2RUcWxIVUdlVUI3Sm9paDV0R0pEZGJIU2dDS0lKTUpyUjJLUnBjMmJBU3VJRU9JamlkRHAydFdnbGJubG85RkgzcGNFVFdkbzVDb0QvNXRreEVraThZNUx5UkJwUzJOVWZFWEdadWxiN3c4bXRtWDMvVXluZk1QVWFhVDIwQXVXT25kS2NCeEdLWTlnMGYxQjNrMy91MUVyLzZMYTFsMVBoNGl6cUxJdXVrVjNmcFhZdVp4ekhZZHBPZU5UNDJta2dwQUxqNktWUEg3TT0tLWhMRXRLTC9PU2FoSDNCWkFCZ3llK1E9PQ%3D%3D--6f9218968a130a152e98384765de6f53e88c802c; __asc=dcf0b5ac16a911f4a34280fdc60\r\n",
                'user_agent' => 'Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10.4; en-US; rv:1.9.2.28) Gecko/20120306 Firefox/3.6.28'
            ]
        ];
        $adds = 'utf8=✓&search[new]=0&search[new]=1&search[used]=0&search[used]=1&search[free_shipping_coverage]=&search[province]=&search[city]=&search[courier]=&search[price_min]=&search[price_max]=&search[rating_gte]=5&search[rating_lte]=5&search[todays_deal]=0&search[installment]=0&search[wholesale]=0&search[top_seller]=0&search[premium_seller]=0&search[brand_seller]=0';
        $context        = stream_context_create( $opts );
        $str            = "https://www.bukalapak.com" . $request->get( 'path' ).'&'.$adds;
        $dom            = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $display        = $dom->find( "article.product-display" );
        $thumbnail      = $dom->find( "img.product-media__img" );
        $price          = $dom->find( "div.product-price" );
        $penjual        = $dom->find( "h5.user__name > a" );
        $lokasi_penjual = $dom->find( "span.user-city__txt" );
        $kondisi        = $dom->find( "span.product__condition" );
        $paginations    = $dom->find( "div.pagination > a" );
        $last_page      = $dom->find( "div.pagination > span.last-page" );
        $datas          = [];
        $a              = 0;
        foreach ( $display as $value ) {
            $a++;
            $datas[ $a ][ 'display' ] = [
                "source_id" => $value->getAttribute( 'data-id' ),
                "name"      => $value->getAttribute( 'data-name' ),
                "url"       => $value->getAttribute( 'data-url' ),
            ];
        }
        $b = 0;
        foreach ( $thumbnail as $thumb ) {
            $b++;
            $datas[ $b ][ 'thumbnail' ] = $thumb->getAttribute( 'data-src' );
        }
        $c = 0;
        foreach ( $price as $harga ) {
            $c++;
            $datas[ $c ][ 'price' ] = $harga->getAttribute( 'data-reduced-price' );
        }
        $d = 0;
        foreach ( $penjual as $seller ) {
            $d++;
            $datas[ $d ][ 'seller' ] = $seller->plaintext;
        }
        $e = 0;
        foreach ( $lokasi_penjual as $lokasi ) {
            $e++;
            $datas[ $e ][ 'seller_city' ] = trim( $lokasi->plaintext );
        }
        $f = 0;
        foreach ( $kondisi as $condition ) {
            $f++;
            $datas[ $f ][ 'product_condition' ] = trim( $condition->plaintext );
        }
        
        $newData = [];
        foreach ( $datas as $data ) {
            $source_id            = trim( $data[ 'display' ][ 'source_id' ] );
            $name                 = $data[ 'display' ][ 'name' ];
            $url                  = $data[ 'display' ][ 'url' ];
            $thumbnail            = $data[ 'thumbnail' ];
            $price                = $data[ 'price' ];
            $seller               = $data[ 'seller' ];
            $seller_city          = $data[ 'seller_city' ];
            $product_condition    = $data[ 'product_condition' ];
            $newData[ 'items' ][] = [
                'source_id'         => $source_id,
                'name'              => $name,
                'url'               => $url,
                'thumbnail'         => $thumbnail,
                'price'             => $price,
                'seller'            => $seller,
                'seller_city'       => $seller_city,
                'product_condition' => $product_condition,
            ];
        }
        foreach ( $paginations as $pagination ) {
            $newData[ 'paginations' ][ 'pages' ][ $pagination->plaintext ] = $pagination->href;
        }
        foreach ( $last_page as $lp ) {
            $newData[ 'paginations' ][ 'last_page' ] = trim( $lp->plaintext, ' ' );
        }
        return $newData;
    }
    
    // contoh
    // http://localhost:8000/api/bukalapak/product?path=/p/elektronik/televisi/1l16s0r-jual-breket-north-bayou-nb-p5
    public function product ( Request $request )
    {
        ini_set( 'max_execution_time', -1 );
        $opts        = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $context     = stream_context_create( $opts );
        $str         = "https://www.bukalapak.com" . $request->get( 'path' );
        $dom         = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $seen        = $dom->find( 'dd.qa-pd-seen-value' );
        $favorited   = $dom->find( 'dd.qa-pd-favorited-value' );
        $specs       = $dom->find( 'dl.c-product-spec' );
        $description = $dom->find( 'div.qa-pd-description' );
        $terjual     = $dom->find( 'dd.qa-pd-sold-value' );
        $stock       = $dom->find( 'div.qa-pd-stock' );
        $galleries   = $dom->find( 'a.js-product-image-gallery__image' );
        $datas       = [];
        $i           = 0;
        $j           = 0;
        $k           = 0;
        foreach ( $specs as $spec ) {
            $i++;
            foreach ( $spec->find( 'dt.c-deflist__label' ) as $label ) {
                $k++;
                $datas[ $i ][ $k ] = [
                    'id'        => $k,
                    'attribute' => Str::snake( $label->plaintext ),
                    'label'     => $label->plaintext
                ];
            }
            foreach ( $spec->find( 'dd.c-deflist__value' ) as $value ) {
                $j++;
                $datas[ $i ][ 'values' ][ $j ] = $value->plaintext;
            }
            foreach ( $description as $desc ) {
                $datas[ $i ][ 'description' ] = $desc->plaintext;
            }
            foreach ( $seen as $see ) {
                $datas[ $i ][ 'seen' ] = $see->plaintext;
            }
            foreach ( $favorited as $favorite ) {
                $datas[ $i ][ 'favorited' ] = $favorite->plaintext;
            }
            foreach ( $terjual as $jual ) {
                $datas[ $i ][ 'terjual' ] = $jual->plaintext;
            }
            foreach ( $stock as $stok ) {
                foreach ( $stok->find( 'span' ) as $s ) {
                    $datas[ $i ][ 'stock' ] = $s->plaintext;
                }
            }
            foreach ( $galleries as $gallery ) {
                $src                          = $gallery->href;
                $datas[ $i ][ 'galleries' ][] = $src;
            }
        }
        
        $newData = [];
        foreach ( $datas as $data ) {
            foreach ( $data as $d ) {
                if ( is_array( $d ) ) {
                    if ( isset( $d[ 'attribute' ] ) ) {
                        $newData[ $d[ 'attribute' ] ] = trim( $data[ 'values' ][ $d[ 'id' ] ], ' ' );
                    }
                }
            }
            $newData[ 'galleries' ]   = json_encode( $data[ 'galleries' ] );
            $newData[ 'seen' ]        = isset( $data[ 'seen' ] ) ? trim( $data[ 'seen' ], ' ' ) : 0;
            $newData[ 'favorited' ]   = isset( $data[ 'favorited' ] ) ? trim( $data[ 'favorited' ], ' ' ) : 0;
            $newData[ 'terjual' ]     = isset( $data[ 'terjual' ] ) ? trim( $data[ 'terjual' ], ' ' ) : 0;
            $newData[ 'stock' ]       = isset( $data[ 'stock' ] ) ? trim( $data[ 'stock' ], ' ' ) : 0;
            $newData[ 'description' ] = $data[ 'description' ];
        }
        
        return $newData;
    }
    //contoh
    // http://localhost:8000/api/bukalapak/seller?path=/u/ypd_putridarwin
    public function seller ( Request $request )
    {
        ini_set( 'max_execution_time', -1 );
        $opts    = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $context = stream_context_create( $opts );
        $str     = "https://www.bukalapak.com" . $request->get( 'path' );
        $dom     = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $etalase = $dom->find( "a.product-label-nav__link" );
        $cards   = $dom->find( "div.product-card > article.product-display" );
        $pages   = $dom->find( "a.c-pagination__link" );
        $data    = [];
        $a       = 0;
        foreach ( $etalase as $eta ) {
            $data[ 'etalase' ][] = [
                'url'   => $eta->href,
                'label' => $eta->plaintext
            ];
        }
        //dump($cards);
        foreach ( $cards as $card ) {
            $data[ 'products' ][] = [
                'id'        => $card->getAttribute( 'data-id' ),
                'name'      => $card->getAttribute( 'data-name' ),
                'url'       => $card->getAttribute( 'data-url' ),
                'thumbnail' => $card->find( "img.product-media__img", 0 )->src
            ];
        }
        foreach ( $pages as $page ) {
            $data[ 'pages' ][ $page->plaintext ] = [
                'url' => $page->href
            ];
        }
        return $data;
    }
    
    public function search ( Request $request )
    {
        ini_set( 'max_execution_time', -1 );
        $opts = [
            'http' => [
                'header' => "User-Agent:" . $this->user_agent . "\r\n"
            ]
        ];
        $page = '';
        if ( $request->get( 'page' ) ) {
            $page = '&page=' . $request->get( 'page' );
        }
        $context        = stream_context_create( $opts );
        $str            = 'https://www.bukalapak.com/products?utf8=✓&source=navbar&from=omnisearch&search_source=omnisearch_organic&search[hashtag]=&search[keywords]=' . $request->get( 'q' ) . $page;
        $dom            = HtmlDomParser::file_get_html( $str, false, $context, 0 );
        $display        = $dom->find( "article.product-display" );
        $thumbnail      = $dom->find( "img.product-media__img" );
        $price          = $dom->find( "div.product-price" );
        $penjual        = $dom->find( "h5.user__name > a" );
        $lokasi_penjual = $dom->find( "span.user-city__txt" );
        $kondisi        = $dom->find( "span.product__condition" );
        $paginations    = $dom->find( "div.pagination > a" );
        $last_page      = $dom->find( "div.pagination > span.last-page" );
        $datas          = [];
        $a              = 0;
        foreach ( $display as $value ) {
            $a++;
            $datas[ $a ][ 'display' ] = [
                "source_id" => $value->getAttribute( 'data-id' ),
                "name"      => $value->getAttribute( 'data-name' ),
                "url"       => $value->getAttribute( 'data-url' ),
            ];
        }
        $b = 0;
        foreach ( $thumbnail as $thumb ) {
            $b++;
            $datas[ $b ][ 'thumbnail' ] = $thumb->getAttribute( 'data-src' );
        }
        $c = 0;
        foreach ( $price as $harga ) {
            $c++;
            $datas[ $c ][ 'price' ] = $harga->getAttribute( 'data-reduced-price' );
        }
        $d = 0;
        foreach ( $penjual as $seller ) {
            $d++;
            $datas[ $d ][ 'seller' ] = $seller->plaintext;
        }
        $e = 0;
        foreach ( $lokasi_penjual as $lokasi ) {
            $e++;
            $datas[ $e ][ 'seller_city' ] = trim( $lokasi->plaintext );
        }
        $f = 0;
        foreach ( $kondisi as $condition ) {
            $f++;
            $datas[ $f ][ 'product_condition' ] = trim( $condition->plaintext );
        }
        
        $newData = [];
        foreach ( $datas as $data ) {
            $source_id         = trim( $data[ 'display' ][ 'source_id' ] );
            $name              = $data[ 'display' ][ 'name' ];
            $url               = $data[ 'display' ][ 'url' ];
            $thumbnail         = $data[ 'thumbnail' ];
            $price             = $data[ 'price' ];
            $seller            = $data[ 'seller' ];
            $seller_city       = $data[ 'seller_city' ];
            $product_condition = $data[ 'product_condition' ];
            $newData[]         = [
                'source_id'         => $source_id,
                'name'              => $name,
                'url'               => $url,
                'thumbnail'         => $thumbnail,
                'price'             => $price,
                'seller'            => $seller,
                'seller_city'       => $seller_city,
                'product_condition' => $product_condition,
            ];
        }
        foreach ( $paginations as $pagination ) {
            $newData[ 'paginations' ][ 'pages' ][ $pagination->plaintext ] = $pagination->href;
        }
        foreach ( $last_page as $lp ) {
            $newData[ 'paginations' ][ 'last_page' ] = trim( $lp->plaintext, ' ' );
        }
        return $newData;
    }
    
    public function getCategories ()
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
}
