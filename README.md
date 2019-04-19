# ecommers-api

## Bukalapak API
- [List Categories](#bukalapak-list-categories)
- [Product By Category](#bukalapak-product-by-category)
- [Product Details](#bukalapak-product-details)
- [Seller](#bukalapak-seller)


## Tokopedia API
- [List Categories](#tokopedia-list-categories)
- [Product By Category](#tokopedia-product-by-category)
- [Product Details](#tokopedia-product-details)
- [Seller](#tokopedia-seller)

### Bukalapak List Categories

````
Method : GET
End Point : /api/bukalapak/categories
````

### Bukalapak Product By Category

````
Method : GET
End Point : /api/bukalapak/category
Parameters : path
Eg : http://localhost:8000/api/bukalapak/category?path=/c/elektronik/televisi?from=category_all&amp;section=category_list
````

### Bukalapak Product Details

````
Method : GET
End Point : /api/bukalapak/product
Parameters : path
Eg : http://localhost:8000/api/bukalapak/product?path=/p/elektronik/televisi/1l16s0r-jual-breket-north-bayou-nb-p5
````


### Bukalapak Seller

````
Method : GET
End Point : /api/bukalapak/seller
Parameters : path
Eg : http://localhost:8000/api/bukalapak/seller?path=/u/ypd_putridarwin
````



### Tokopedia List Categories

````
Method : GET
End Point : /api/tokopedia/categories
Eg : http://localhost:8000/api/tokopedia/categories
````

### Tokopedia Product By Category

````
Method : GET
End Point : /api/tokopedia/category
Parameters : path
Eg : http://localhost:8000/api/tokopedia/category?path=/p/handphone-tablet/handphone?page=9&amp;identifier=handphone-tablet_handphone
````

### Tokopedia Product Details

````
Method : GET
End Point : /api/tokopedia/product
Parameters : path
Eg : http://localhost:8000/api/tokopedia/product?path=/androzone777/apple-iphone-xr-64gb-red-garansi-desember-2019-ibox?trkid=f=Ca0000L000P0W0S0Sh,Co0Po0Fr0Cb0_src=other-product_page=1_ob=32_q=_po=1_catid=3055&src=other
````


### Tokopedia Seller

````
TODO
````