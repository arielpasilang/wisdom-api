# Goal of this project

BASIC APP WHERE A USER CAN ADD BOOK TO READ AND UPDATE STATUS

## Features

1. Register User
2. Login as a User
3. User can view books to read
4. User can add book to read
5. User can update status of books to read

-   Status (Pending, Completed)

6. User can logout

## Implementation

### 1. Implement Laravel Sanctum for Authentication

    https://codelapan.com/post/laravel-8-rest-api-authentication-with-sanctum

### 2. Create Migration

---

**1. Create Migration Command**

```
php artisan make:migration create_books_table
```

**2. Modify create_books_table**

```
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); //Automatically detects users table id
            $table->longText('book');
            $table->text('status');
            $table->timestamps();
        });
    }
```

**3. Run Migration**

```
php artisan migrate
```

**4. Verify the table books were created to the database**
If you are using xampp, go to localhost/phpmyadmin

---

### 3. Create A Model

---

**Create Model Command**

```
php artisan make:model Book
```

---

### 4. Create BookController

```
php artisan make:controller BookController --resource
```

### 5. Create group of routes for books

```
    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index');
        Route::post('/books', 'store');
    });
```

### 6. Modify Book Model

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'book', 'status'
    ];
}

```

### 7. Modify BookController.php index and store function

```
    public function index()
    {
        //
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'book' => 'required|unique:books|max:255',
            // 'status' => [new Enum(ServerStatus::class)],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::create($request->all());
        return response()->json($book, 201);


    }
```

Notes on HTTPS Codes
A Note on HTTP Status Codes and the Response Format
We’ve also added the response()->json() call to our endpoints. This lets us explicitly return JSON data as well as send an HTTP code that can be parsed by the client. The most common codes you’ll be returning will be:

200: OK. The standard success code and default option.
201: Object created. Useful for the store actions.
204: No content. When an action was executed successfully, but there is no content to return.
206: Partial content. Useful when you have to return a paginated list of resources.
400: Bad request. The standard option for requests that fail to pass validation.
401: Unauthorized. The user needs to be authenticated.
403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
404: Not found. This will be returned automatically by Laravel when the resource is not found.
500: Internal server error. Ideally you're not going to be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
503: Service unavailable. Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.
