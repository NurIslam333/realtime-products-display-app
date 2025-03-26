# Laravel 12 Real-Time Product Display App

This is a Laravel 12 application that fetches product data from a free public API (**Fake Store API**) and displays it in real-time using **Pusher**. The app ensures that all users viewing the page automatically see new products without refreshing.

---

## 🚀 Demo

🎥 **Screen Recorded Result:**  
[Watch on Loom](https://www.loom.com/share/956929837cd14fe9b414bf1c9583c5c4?sid=ac60894c-2961-49e9-ae3a-72d10845d2f9)

---

## Features
✅ **Fetch products from Fake Store API**  
✅ **Store products in a database**  
✅ **Display products in real-time using Pusher**  
✅ **Laravel broadcasting for live updates**  
✅ **Blade and JavaScript frontend**  

---

## 1. Installation Guide

### Step 1: Clone the Repository

```
git clone https://github.com/NurIslam333/realtime-products.git
cd realtime-products
```
### Step 2: Install Dependencies
```
composer install
npm install
```
### Step 3: Configure Environment
Copy the example .env file:
```
cp .env.example .env
```
Set your database details in .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=realtime_products
DB_USERNAME=root
DB_PASSWORD=
```
Set up Pusher in .env (Get credentials from Pusher):
```
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME="https"
PUSHER_APP_CLUSTER=mt1
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=database
```
### Step 4: Run Migrations
```
php artisan migrate
```
### Step 5: Start Laravel Queue
```
php artisan queue:work
```
### Step 6: Serve the Application
```
php artisan serve
```
Visit: http://127.0.0.1:8000/

### 2. Usage Guide
Click the "Fetch Products" button to retrieve products from the Fake Store API.

Open multiple browser tabs to see real-time updates.

Whenever a new product is added, all connected users will see it instantly.

### 3. How Pusher is Integrated
Backend (Laravel)
Set up broadcasting in config/broadcasting.php:
```
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
    ],
],
```
Create an event ProductUpdated.php to broadcast updates:

```
class ProductUpdated implements ShouldBroadcastNow
{
    public function broadcastOn()
    {
        return new Channel('products');
    }
}
```

Fire the event when new products are added:
```
event(new ProductUpdated());
Frontend (Blade + JavaScript)
```
Include Pusher in Blade file:
```
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
```

Listen for events and update the UI dynamically:
```
var pusher = new Pusher({{ env('PUSHER_APP_KEY') }}, { cluster: "ap1" });
var channel = pusher.subscribe("products");
channel.bind("App\\Events\\ProductUpdated", function() {
    location.reload();
});
```
### 4. API Reference
This project uses Fake Store API to fetch products.

### Example API Response:
```
[
  {
    "id": 1,
    "title": "Product Name",
    "price": 19.99,
    "description": "Product description..."
  }
]
```

### SCreen Recorded result:

https://www.loom.com/share/956929837cd14fe9b414bf1c9583c5c4?sid=ac60894c-2961-49e9-ae3a-72d10845d2f9