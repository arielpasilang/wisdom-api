# Goal of this project

## BASIC APP WHERE A USER CAN ADD BOOK TO READ AND UPDATE STATUS

### Features

1. Register User
2. Login as a User
3. User can view books to read
4. User can add book to read
5. User can update status of books to read

-   Status (Pending, Completed)

6. User can logout

### Implementation

1. Implement Laravel Sanctum for Authentication
   https://codelapan.com/post/laravel-8-rest-api-authentication-with-sanctum
2. Create Migration

---

-   **_ A. Migration Command _**

```
php artisan make:migration create_books_table
```

-   **_ B. Modify create_books_table _**

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

-   **_ C. Run Migration _**

```
php artisan migrate
```

-   **_ D. Verify the table books were created to the database _**
    If you are using xampp, go to localhost/phpmyadmin

3. Create A Model

---
