# Build Journal

## Step 1 — The cart in session, never in the database

A defining decision: `CartService` touches NO table. A logged-out visitor must be able to freely build their cart — requiring an account from the very first item added would be unnecessary friction, and would have required managing "orphan" carts in the database for visitors who never came back. [Module 02.5](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.en.md) provides exactly the mechanism suited to this ephemeral, per-visitor data.

## Step 2 — The schema: deliberate denormalization on `order_items`

`order_items.nom_produit` and `prix_unitaire` DUPLICATE information already present on `products`. This is a **deliberate** denormalization (a reminder of [module 04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.en.md)'s modeling trade-offs): an order must remain a **faithful historical document**, immutable even if the product is later renamed, has its price changed, or is deleted (`restrictOnDelete()` on `product_id` also prevents this deletion as long as an order references it — but the name/price stay preserved independently either way).

## Step 3 — `OrderService::passerCommande()`, the project's core

All order logic is encapsulated inside **a single transaction** (`DB::transaction()`, module 04.2): stock check, order creation, line-item creation, stock decrement (`decrement()`, an atomic SQL-side operation), then the payment call. If **any** of these steps fails (insufficient stock, payment declined), Laravel automatically cancels everything done within that transaction — no "half-created" order, no stock decremented without a valid order behind it.

## Step 4 — `PaymentGateway`, an interface from the start

`FakePaymentGateway` is NOT a shameful shortcut: it's a **complete** implementation of an interface (`PaymentGateway`) designed from the outset to be replaceable (module 08.4). Switching to a real provider (Stripe, for example) in production would only change one line in `AppServiceProvider::register()` — `OrderService`, the controllers, and the tests would stay identical.

## Step 5 — Testing the rollback, not just success

`CheckoutTest` deliberately dedicates more than half its tests to failure cases (insufficient stock, declined payment), not just the happy path. The rollback test binds a fake gateway **specific to the test** (`$this->app->bind(...)`, reusing module 08.4's injection mechanism) that systematically fails, to unambiguously prove that stock and the order return to their original state after the failure.

## Going further (out of scope for this project)

No discount coupon handling, no shipping fees, no product variants (size, color) — the catalog deliberately stays flat. The admin panel only covers products (not order or category management), left as a free exercise following the pattern of the already-provided `Admin\ProductController`.
