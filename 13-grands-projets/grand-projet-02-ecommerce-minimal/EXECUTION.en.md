# Running the Application

## Run the tests (do this first)

```bash
php artisan test --filter=CheckoutTest
```

The three tests cover: a successful order (stock decremented, cart emptied), insufficient stock (nothing persisted), and a full rollback on payment failure.

## Launch the application

```bash
php artisan serve
```

## Using the shop

1. Browse `/produits`, filter by category or search.
2. Add products to the cart (`/panier`) — works **with no login**.
3. Log in to complete the order (payment always simulated as successful, except for an amount ≤ 0, unreachable through the normal interface).
4. Check `/mes-commandes` for order history.

## Using the admin panel

Log in with the account promoted to admin, visit `/admin/products`: full product CRUD (create, edit, delete), protected by the `acceder-admin` Gate.

## Verifying the transaction under real conditions

Temporarily modify `FakePaymentGateway::payer()` to systematically throw `PaiementEchoueException`. Place an order from the interface: the page shows the error, and **no row** appears in `orders`/`order_items`, the product's stock stays unchanged — verifiable via `php artisan tinker`.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
