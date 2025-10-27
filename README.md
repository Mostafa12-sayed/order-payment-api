# 🧾 Order Payment API (Laravel 12)

This is a simple Laravel 12 API that handles order payment and user point updates using transactions and validation.

---

## 🚀 Installation Steps

### 1️⃣ Clone the project
```bash
- git clone https://github.com/mostafa-sayed12/order-payment-api.git

- cd order-payment-api
```
### 2️⃣ Install dependencies
```bash
- composer install

- php artisan key:generate
```

### 3️⃣ Configure the environment file
```bash
cp .env.example .env
```
### 4️⃣ Generate application key
```bash
php artisan key:generate
```
### 5️⃣ Set up the database
Open the .env file and configure your DB credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_api_db
DB_USERNAME=root
DB_PASSWORD=
```
### 6️⃣ Run migrations
```bash
php artisan migrate
```
### 6️⃣ Run migrations
Use Tinker to create a sample user and order:
```bash
php artisan tinker

$user = App\Models\User::create([
    'name' => 'test',
    'email' => 'test@test.com',
    'password' => bcrypt('123456'),
]);
App\Models\Order::create([
    'user_id' => $user->id,
    'total_price' => 150,
    'status' => 'pending',
]);

exit
```
### ▶️ Run the server
```bash
php artisan serve
```
### ▶️ Test APi
```http
POST http://api/orders/pay
{
  "order_id": order_number
}

```
