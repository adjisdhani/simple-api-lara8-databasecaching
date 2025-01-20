# Simple Laravel 8 Caching with Database Caching

This is a Simple Laravel 8 Caching with Database Caching with endpoints accessible via RESTful API.

## Features
- View all products (GET `/api/products`)
- Create a new products (POST `/api/products`)

## Requirements
- PHP 7.4 or higher
- Composer
- Laravel 8
- MySQL or MariaDB

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/adjisdhani/simple-api-lara8-databasecaching.git
   ```

2. **Navigate to the project directory**:
   ```bash
   cd simple-api-lara8-databasecaching
   ```

3. **Install dependencies**:
   ```bash
   composer install
   ```
4. **Configure the .env file**:
   ```bash
    DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=yourdatabase
	DB_USERNAME=yourusername
	DB_PASSWORD=yourpassword
   ```

5. **Generate the application key**:
   ```bash
    php artisan key:generate
    ```

6. **Add cache's table**:
   ```bash
    php artisan migrate
    ```

7. **Edit .env for caching**:
   ```bash
    CACHE_DRIVER=database
    ```

8. **Start the development server**:
   ```bash
    php artisan serve
    ```

9. **Access the API**:
   (http://127.0.0.1:8000/api/products)

      ## API Endpoints 
    
    **1. Get All Data**

    - Method: GET
    - Endpoint: /api/products
    - Description: Retrieve a list of all products.

    **Example Response**:
    
         {
		    "from_cache": false,
		    "data": [
		        {
		            "id": 1,
		            "name": "Product A",
		            "price": 10000,
		            "created_at": "2025-01-19T22:52:10.000000Z",
		            "updated_at": "2025-01-19T22:52:10.000000Z"
		        },
		        {
		            "id": 2,
		            "name": "Product B",
		            "price": 15000,
		            "created_at": "2025-01-19T22:59:22.000000Z",
		            "updated_at": "2025-01-19T22:59:22.000000Z"
		        }
		    ]
		}
    
    **2. Create a New Product**
    
    - Method: POST
    - Endpoint: /api/products
    - <b>Body Parameters:</b>
      1. name (string, required)
      2. price (numeric, required)

    **Example Request**:
    
       [
    	    {
	            "name": "Product A",
	            "price": 10000
	        },
       ]
    **Example Response**:
    
       [
    	    {
	            "id": 1,
	            "name": "Product A",
	            "price": 10000,
	            "created_at": "2025-01-19T22:52:10.000000Z",
	            "updated_at": "2025-01-19T22:52:10.000000Z"
	        },
       ]

10. **Penjelasan soal cachingnya**

      **1. di controllernya ketika pertama kali akses method GET , itu di set ke dalam cache terlebih dahulu dengan expired dari cachenya selama 60 detik**
     ```bash
        $products = Cache::remember('products', 60, function () {
            return Product::all();
        });

        return response()->json([
            'from_cache' => false,
            'data' => $products
        ]);
     ```

      **2. pemberian flag 'from_cache' untuk memberikan remark data tersebut balikan dari table product atau cache yang disimpan**
     ```bash
        return response()->json([
            'from_cache' => false,
            'data' => $products
        ]);
     ```

      **3. pengecekan cache tersimpan, jika cache yang sebelumnya berhasil tersimpan, maka akan diberikan flag bahwa data balikannya dari cache**
     ```bash
        if (Cache::has('products')) {
            return response()->json([
                'from_cache' => true,
                'data' => Cache::get('products')
            ]);
        }
     ```

     **4. Jika api untuk menambahkan data di hit , maka cache yang tersimpan akan terhapus**
    ```bash
        $product = Product::create($request->all());

        Cache::forget('products');

        return response()->json($product, 201);
    ```

     **5. selesai untuk caching menggunakan Database Caching, dan jika ingin melihat datanya tersimpan di cache bisa langsung mengakses table 'cache' di databasenya**

## Author
Adjis Ramadhani Utomo

## License
This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).