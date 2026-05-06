# GymTrack - Equipment Orders + ML Sentiment Analysis
### ITEL 203 – Web Systems and Technologies

---

## 🚀 How to Set Up (XAMPP + InfinityFree)

### Step 1: Import the Database
1. Go to your **phpMyAdmin** on InfinityFree
2. Select `if0_41715287_db_gymtrack`
3. Click **Import** → choose `database.sql` → click **Go**

> ⚠️ If you have an existing database with the old `sessions` table, drop it first or import to a fresh database.

---

### Step 2: Install ML Package (Composer)

Open **VS Code terminal** and navigate to your project folder:

```bash
cd C:\xampp\htdocs\gymtrackersing
```

Install the packages:

```bash
composer require davmixcool/php-sentiment-analyzer
composer require stichoza/google-translate-php
```

This creates a `vendor/` folder — **upload this folder too** to InfinityFree.

---

### Step 3: Upload to InfinityFree
Upload all files including the `vendor/` folder to your InfinityFree File Manager under `htdocs/`.

---

## 📁 New Files Added

| File | Description |
|------|-------------|
| `orders.php` | List all equipment orders |
| `order_create.php` | Add new order |
| `order_edit.php` | Edit existing order |
| `order_feedback.php` | Submit feedback + ML sentiment analysis ⭐ |
| `order_delete.php` | Delete an order |
| `classes/Order.php` | OOP class for orders |
| `database.sql` | Updated DB with `orders` table |
| `composer.json` | ML package dependencies |

## 🤖 ML Package Used
**`davmixcool/php-sentiment-analyzer`** from [Packagist.org](https://packagist.org/packages/davmixcool/php-sentiment-analyzer)

- Detects if a review is **Positive**, **Neutral**, or **Negative**
- Works best with English text
- Optional: `stichoza/google-translate-php` translates Filipino feedback to English first

## 🔑 Default Login
| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | Admin |
| staff1 | staff123 | Staff |
