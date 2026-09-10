# Complete Source Code

This project's entire code already exists in this repository — click a file to open it, copy it as-is into your own Laravel project by following [INSTALLATION.md](INSTALLATION.en.md).

## `app/Contracts`

- [app/Contracts/PaymentGateway.php](app/Contracts/PaymentGateway.php)

## `app/Exceptions`

- [app/Exceptions/PaiementEchoueException.php](app/Exceptions/PaiementEchoueException.php)

## `app/Http/Controllers`

- [app/Http/Controllers/CartController.php](app/Http/Controllers/CartController.php)
- [app/Http/Controllers/OrderController.php](app/Http/Controllers/OrderController.php)
- [app/Http/Controllers/ProductController.php](app/Http/Controllers/ProductController.php)

## `app/Http/Controllers/Admin`

- [app/Http/Controllers/Admin/ProductController.php](app/Http/Controllers/Admin/ProductController.php)

## `app/Models`

- [app/Models/Category.php](app/Models/Category.php)
- [app/Models/Order.php](app/Models/Order.php)
- [app/Models/OrderItem.php](app/Models/OrderItem.php)
- [app/Models/Product.php](app/Models/Product.php)
- [app/Models/User-additions.php](app/Models/User-additions.php)

## `app/Policies`

- [app/Policies/OrderPolicy.php](app/Policies/OrderPolicy.php)

## `app/Providers`

- [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)

## `app/Services`

- [app/Services/CartService.php](app/Services/CartService.php)
- [app/Services/FakePaymentGateway.php](app/Services/FakePaymentGateway.php)
- [app/Services/OrderService.php](app/Services/OrderService.php)

## `database/factories`

- [database/factories/CategoryFactory.php](database/factories/CategoryFactory.php)
- [database/factories/ProductFactory.php](database/factories/ProductFactory.php)

## `database/migrations`

- [database/migrations/2024_05_01_000001_create_categories_table.php](database/migrations/2024_05_01_000001_create_categories_table.php)
- [database/migrations/2024_05_01_000002_create_products_table.php](database/migrations/2024_05_01_000002_create_products_table.php)
- [database/migrations/2024_05_01_000003_create_orders_table.php](database/migrations/2024_05_01_000003_create_orders_table.php)
- [database/migrations/2024_05_01_000004_add_est_admin_to_users_table.php](database/migrations/2024_05_01_000004_add_est_admin_to_users_table.php)

## `database/seeders`

- [database/seeders/EcommerceSeeder.php](database/seeders/EcommerceSeeder.php)

## `resources/views/cart`

- [resources/views/cart/index.blade.php](resources/views/cart/index.blade.php)

## `resources/views/orders`

- [resources/views/orders/confirmation.blade.php](resources/views/orders/confirmation.blade.php)
- [resources/views/orders/historique.blade.php](resources/views/orders/historique.blade.php)

## `resources/views/products`

- [resources/views/products/index.blade.php](resources/views/products/index.blade.php)
- [resources/views/products/show.blade.php](resources/views/products/show.blade.php)

## `routes`

- [routes/web.php](routes/web.php)

## `tests/Feature`

- [tests/Feature/CheckoutTest.php](tests/Feature/CheckoutTest.php)

---

Back to the [project README](README.en.md).
