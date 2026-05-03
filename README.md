# HotTours — Вебзастосунок туристичного агентства

Вебзастосунок для туристичного агентства, що дозволяє переглядати каталог турів, оформлювати заявки на бронювання та керувати контентом через адміністративну панель.

## Технологічний стек

| Компонент | Технологія |
|-----------|-----------|
| Backend | PHP 8.2, Laravel 12 |
| Frontend | Blade Templates, Bootstrap 5.3.2 |
| СКБД | MySQL 8.0 |
| Автентифікація | Laravel UI (session-based) |
| Збирач ресурсів | Vite |
| Пакетний менеджер PHP | Composer 2.x |
| Пакетний менеджер JS | NPM |

## Функціональність

- Каталог турів із фільтрацією (напрямок, ціна, тривалість, гарячі пропозиції)
- Детальні сторінки турів із фотогалереєю
- Система замовлень із особистим кабінетом користувача
- Форма зворотного зв'язку для авторизованих користувачів
- Адміністративна панель: управління турами, заявками, повідомленнями та статистикою
- Рольова система доступу (user / admin)

## Системні вимоги

| Компонент | Мінімальна версія |
|-----------|------------------|
| PHP | 8.2 |
| MySQL | 5.7 / 8.0 |
| Composer | 2.x |
| Node.js | 18.x |
| NPM | 9.x |
| Вебсервер | Apache / Nginx |

**Обов'язкові PHP-розширення:** `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `json`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `bcmath`

## Розгортання проєкту

### 1. Клонування репозиторію

```bash
git clone https://github.com/VladyslavMurava/HotTours.git
cd HotTours
```

### 2. Встановлення PHP-залежностей

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Налаштування середовища

```bash
cp .env.example .env
php artisan key:generate
```

Відредагуйте файл `.env` — вкажіть параметри підключення до бази даних:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hottours_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Збірка фронтенд-ресурсів

```bash
npm install
npm run build
```

### 5. Ініціалізація бази даних

```bash
php artisan migrate --force
php artisan db:seed --class=TourSeeder
```

### 6. Призначення ролі адміністратора

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'your@email.com')->first();
$role = App\Models\Role::where('name', 'admin')->first();
$user->roles()->attach($role);
```

### 7. Налаштування прав доступу до директорій

```bash
chmod -R 775 storage bootstrap/cache
```

## Структура проєкту

```
app/
├── Http/
│   ├── Controllers/     # TourController, PagesController, TourImageController
│   └── Middleware/      # AdminMiddleware
├── Models/              # Tour, Destination, Order, Message, User, Role
database/
├── migrations/          # 12 файлів міграцій
└── seeders/             # TourSeeder, OrderSeeder
resources/views/
├── tours/               # index, show, create, edit
├── admin/               # orders, messages, stats
└── layout.blade.php     # головний шаблон
```

## Ліцензія

MIT
