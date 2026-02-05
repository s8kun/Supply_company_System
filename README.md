# نظام إدارة شركة التوريد الذكي

مشروع لإدارة المبيعات والمخزون والطلبات للعملاء مع ربط الرصيد بالعمليات، وإدارة تسليم الطلبات، وإشعارات إعادة الطلب، وبطاقات شحن الرصيد (Redeem Codes).

## المميزات الأساسية
- إدارة العملاء والمنتجات والطلبات وعناصر الطلب.
- خصم الرصيد تلقائيًا عند إنشاء الطلب وإرجاعه عند الإلغاء.
- خصم المخزون فقط عند التسليم (وليس عند إنشاء الطلب).
- إشعار إعادة الطلب عند انخفاض المخزون عن الحد الأدنى.
- شحن الرصيد عبر كود استخدام واحد.
- صور متعددة للمنتج (3 إلى 4 صور) على شكل مصفوفة.

## المتطلبات
- PHP 8.2 أو أحدث
- Composer
- قاعدة بيانات (MySQL أو SQLite)
- (اختياري) Node.js/NPM إذا كنت ستشغل الواجهة أو تبني الأصول

## التشغيل السريع
1) تثبيت الاعتمادات:
```
composer install
```

2) إعداد ملف البيئة:
```
cp .env.example .env
php artisan key:generate
```

3) ضبط قاعدة البيانات:

### خيار MySQL
عدّل القيم في `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=SupplyCompany
DB_USERNAME=...
DB_PASSWORD=...
```

### خيار SQLite
```
touch database/database.sqlite
```
وفي `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database/database.sqlite
```

4) تشغيل المايجريشن وملء البيانات الوهمية:
```
php artisan migrate
php artisan db:seed
```

5) إنشاء رابط التخزين للصور:
```
php artisan storage:link
```

6) تشغيل السيرفر:
```
php artisan serve
```

الـ API سيكون على:
```
http://localhost:8000/api/v1
```

## تشغيل الجدولة (Reorder Notices)
النظام ينشئ إشعارات إعادة الطلب عبر جدولة دورية:
```
php artisan schedule:work
```
وفي بيئة الإنتاج يُفضّل تفعيل cron:
```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## ملفات الاختبار
تجد طلبات جاهزة في:
```
tests/TestApi
```
يمكن فتحها في أي HTTP client يدعم ملفات `.http`.

## توثيق الـ API
التوثيق الكامل موجود هنا:
```
docs/api.md
```
