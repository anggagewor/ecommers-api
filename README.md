# ecommers-api

## Bukalapak API
- [List Categories](#bukalapak-list-categories)
- [Product By Category](#bukalapak-product-by-category)
- [Product Details](#bukalapak-product-details)
- [Seller](#bukalapak-seller)

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