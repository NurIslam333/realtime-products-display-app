<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Products Display</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin: 20px 0;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .product-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }
        .product-card p {
            font-size: 14px;
            color: #555;
        }
        .price {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h1>Real-Time Product List</h1>
    <button class="btn" onclick="fetchProducts()">Fetch Products</button>

    <div class="container">
        <div class="product-grid" id="product-list">
            @foreach($products as $product)
                <div class="product-card">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ Str::limit($product->description, 60) }}</p>
                    <p class="price">${{ $product->price }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function fetchProducts() {
            axios.get('/fetch-products')
                .then(response => console.log(response.data))
                .catch(error => console.error(error));
        }

        Pusher.logToConsole = true;
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "mt1"
        });

        var channel = pusher.subscribe("products");
        channel.bind("App\\Events\\ProductUpdated", function() {
            location.reload();
        });
    </script>

</body>
</html>
