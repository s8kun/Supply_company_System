# تشغيل المشروع باستخدام Docker | Running the Project with Docker

هذا الإعداد يسمح لك بتشغيل المشروع بسهولة دون الحاجة لتثبيت PHP أو MySQL على جهازك.
This setup allows you to run the project easily without needing to install PHP or MySQL on your machine.

## المتطلبات | Requirements
- Docker
- Docker Compose

## طريقة التشغيل | How to Run

1. **قم ببناء وتشغيل الحاويات:**
   **Build and run the containers:**
   ```bash
   docker-compose up -d --build
   ```

2. **الدخول إلى التطبيق:**
   **Access the application:**
   - رابط الموقع (The Website): [http://localhost:8000](http://localhost:8000)
   - قاعدة البيانات (The Database): `localhost:3306`

3. **إيقاف التشغيل:**
   **Stop the project:**
   ```bash
   docker-compose down
   ```

## ملاحظات هامة | Important Notes
- سيقوم Docker تلقائياً بإنشاء ملف `.env` وتثبيت المكتبات (Composer) وعمل الـ Migrations في المرة الأولى.
- Docker will automatically create the `.env` file, install dependencies, and run migrations on the first start.
- تأكد من أن منفذ 8000 و 3306 غير مستخدمين من قبل برامج أخرى.
- Ensure ports 8000 and 3306 are not being used by other applications.
