# Large Project: Minimal E-commerce

> **Status:** ✅ Available

## 🎯 Learning objective

Build a complete but **deliberately minimal** e-commerce site: a catalog with a session-based cart, a transactional checkout flow (simulated payment, atomic stock decrement, rollback on failure), and an admin back-office — a synthesis of nearly every level from 02 through 11.

## 📋 Modules used

- [02.5 — Sessions, Cookies](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.en.md) (session-based cart)
- [04.2 — Advanced SQL: Transactions](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.en.md) (the checkout flow's core)
- [07.4/07.5 — Authentication and Authorization](../../07-laravel-intermediaire/README.en.md) (Breeze, `OrderPolicy`, admin Gate)
- [08.4 — Service Providers](../../08-laravel-avance/04-packages-service-providers-personnalises/README.en.md) (an interchangeable `PaymentGateway`)
- [08.3 — Pest Tests](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md) (testing a transaction and its rollback)

## 🧠 What you'll learn

- Design a session-based cart (not database-backed) to allow purchasing with no account until payment.
- Encapsulate the entire checkout flow (creation, stock decrement, payment) inside a **single transaction** (`DB::transaction()`), guaranteeing that no inconsistent state is ever persisted.
- Deliberately denormalize `nom_produit`/`prix_unitaire` onto `order_items` to preserve an order's historical accuracy, even if the product later changes.
- Inject a **simulated** payment gateway behind an interface, replaceable with a real provider without touching the calling code.
- Explicitly test the rollback scenario: a payment failure must cancel the order AND restore the stock.

## 📂 Project structure

```
grand-projet-02-ecommerce-minimal/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/{migrations,factories,seeders}/
├── app/
│   ├── Models/                 # Category, Product, Order, OrderItem
│   ├── Contracts/PaymentGateway.php
│   ├── Services/                 # CartService, OrderService, FakePaymentGateway
│   ├── Exceptions/PaiementEchoueException.php
│   ├── Policies/OrderPolicy.php
│   └── Http/Controllers/           # public + Admin/ProductController
├── routes/web.php
├── resources/views/
└── tests/Feature/CheckoutTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md) — **start by running `CheckoutTest`**, the project's core.
3. **Before reading the provided code**, try designing `OrderService::passerCommande()`'s transaction yourself.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.

**Next in the path:** [Large Project: Minimal Social Network](../grand-projet-03-reseau-social-minimal/README.en.md)
