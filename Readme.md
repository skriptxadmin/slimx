Here’s a **cleaned-up, more professional version** of your README for the **Slimx PHP framework**, while keeping your voice and structure intact:

---

## 🚀 Welcome to Slimx

**Slimx** is a lightweight, open-source alternative to other PHP frameworks.  
It’s built on top of the [Slim Framework](https://www.slimframework.com/) and uses the powerful [Smarty](https://www.smarty.net/) templating engine.

---

## 📦 Installation

Clone the repository:

```bash
git clone https://github.com/your-username/slimx.git
```

---

## ⚙️ Configuration

Create or modify the `.env` file to set up your environment variables.

---

## 🚀 Getting Started

Currently, Slimx is intended for developers already familiar with MVC-based PHP frameworks. A beginner-friendly tutorial video is coming soon!

---

## 🧱 Creating a Controller

```bash
php slimx/slimx make:controller HomeController
```

This will generate a new controller in the `src/Controllers` directory.

---

## 📜 Creating a Migration

```bash
php slimx/slimx make:migration RolesMigration
```

This creates:

```
src/Database/Migrations/RolesMigration.php
```

✅ **Remember**: Set the table name in the created file.

---

## 🌱 Creating a Seeder

```bash
php slimx/slimx make:seeder RolesSeeder
```

This creates:

```
src/Database/Seeders/RolesSeeder.php
```

✅ **Remember**: Set the table name and seed data.

---

## ⚡ Running Migrations and Seeders

Make sure your `routes/database.php` file is configured.

To run migrations:

```
{$APP_URL}/migrate
```

To run seeders:

```
{$APP_URL}/seed
```

---

## 🧩 Working with Models

Extend the base model and access it using the `modelObj`.  
Check `src/Controllers/HomeController.php` for a working example (see `users()` method).

### Available DB actions:

```php
$model->count($where = NULL);
$model->delete($where);
$model->columns();
$model->select($columns = '*', $where = [], $join = []);
$model->get($columns, $where = [], $join = []);
$model->insert($rows);
$model->update($data, $where);
```

Or define your own methods:

```php
public function migrate()
{
    $this->db->drop($this->table);
    $this->db->create($this->table, $this->columns);
    return true;
}

public function seed()
{
    $this->db->insert($this->table, $this->rows);
    return true;
}
```

You can also run raw queries:

```php
$model->db("SELECT * FROM $table");
```

## Validation

For backend validation, rakit validation is used and refer

src\Controllers\HomeController.php method validation


---

## 🧠 Smarty + Slim Notes

### ⚠️ Pagination & Caching Issue

If you're seeing the **same content on every paginated page**, it’s likely due to Smarty caching the first result.  
To fix this:

```php
return $this->view($request, 'users/index', $data, 'users_page_' . $page);
```

✅ Pass a **unique 4th parameter** to differentiate cached pages.

---

### 📌 Additional Tips

- Use `{nocache}` on meta tags if the content changes per page.
- If you're redirected to a 500 error, try **uncommenting the error handler** in `public/index.php`.
- To access `.env` variables in templates:

```smarty
{env var=APP_TITLE}
```