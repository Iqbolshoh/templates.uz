DROP DATABASE templates;

CREATE DATABASE templates;

USE templates;

CREATE TABLE languages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    language_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin') NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS active_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    device_name VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    image VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    button_text VARCHAR(100) NOT NULL,
    button_link VARCHAR(255) NOT NULL
);

CREATE TABLE features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    icon VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    icon VARCHAR(50),
    count INT,
    title VARCHAR(100),
    description VARCHAR(255)
);

CREATE TABLE about_section (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    details TEXT NOT NULL,
    image_url VARCHAR(255)
);

CREATE TABLE about_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    about_id INT,
    list_item TEXT NOT NULL,
    FOREIGN KEY (about_id) REFERENCES about_section(id)
);

CREATE TABLE service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) NOT NULL
);

CREATE TABLE service_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    subtitle TEXT NOT NULL,
    additional_info TEXT NOT NULL
);

CREATE TABLE team_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    service_name VARCHAR(255) NOT NULL,
    skill_level INT NOT NULL
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telegram VARCHAR(255),
    instagram VARCHAR(255),
    youtube VARCHAR(255),
    github VARCHAR(255)
);

CREATE TABLE contact_box (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    title VARCHAR(255),
    value VARCHAR(255),
    icon VARCHAR(255)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('no_checked', 'checked') DEFAULT 'no_checked',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lang_id INT,
    FOREIGN KEY (lang_id) REFERENCES languages(id),
    category_id INT,
    project_name VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL,
    description TEXT,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE
);

CREATE TABLE project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

INSERT INTO
    languages (language_name)
VALUES
    ('Eng'),
    ('Ru'),
    ('Uz');

-- ==============================  
-- 📥 DATA INSERTION (COMPLETE)  
-- ==============================  
-- DEFAULT PASSWORD: "IQBOLSHOH" (HASHED FOR SECURITY)  
-- ==============================  

INSERT INTO
    users (
        first_name,
        last_name,
        email,
        username,
        password,
        role
    )
VALUES
    (
        'Iqbolshoh',
        'Ilhomjonov',
        'iilhomjonov777@gmail.com',
        'iqbolshoh',
        '52be5ff91284c65bac56f280df55f797a5c505f7ef66317ff358e34791507027',
        'admin'
    );

INSERT INTO
    banners (
        lang_id,
        image,
        title,
        description,
        button_text,
        button_link
    )
VALUES
    (
        1,
        'hero-carousel-1.jpg',
        'Welcome to Iqbolshoh',
        'Modern Web-Sites Creation',
        'Start',
        'about.php'
    ),
    (
        2,
        'hero-carousel-1.jpg',
        'Добро пожаловать в Икболшох',
        'Создание современных веб-сайтов',
        'Начать',
        'about.php'
    ),
    (
        3,
        'hero-carousel-1.jpg',
        'Iqbolshoh ga xush kelibsiz',
        'Zamonaviy veb-saytlar yaratish',
        'Boshlash',
        'about.php'
    ),
    (
        1,
        'hero-carousel-2.jpg',
        'Change Your Life with Us',
        'Grow yourself with new ideas and creative solutions.',
        'Start',
        'about.php'
    ),
    (
        2,
        'hero-carousel-2.jpg',
        'Измените свою жизнь с нами',
        'Развивайтесь с новыми идеями и креативными решениями.',
        'Начать',
        'about.php'
    ),
    (
        3,
        'hero-carousel-2.jpg',
        'Hayotingizni biz bilan o‘zgartiring',
        'Yangi g‘oyalar va kreativ yechimlar bilan o‘zingizni rivojlantiring.',
        'Boshlash',
        'about.php'
    ),
    (
        1,
        'hero-carousel-3.jpg',
        'Our Offers',
        'We offer the best services for you.',
        'Start',
        'about.php'
    ),
    (
        2,
        'hero-carousel-3.jpg',
        'Наши предложения',
        'Мы предлагаем лучшие услуги для вас.',
        'Начать',
        'about.php'
    ),
    (
        3,
        'hero-carousel-3.jpg',
        'Bizning takliflarimiz',
        'Biz sizga eng yaxshi xizmatlarni taqdim etamiz.',
        'Boshlash',
        'about.php'
    );

INSERT INTO
    features (lang_id, icon, title, description)
VALUES
    (
        1,
        'bi bi-bounding-box-circles',
        'Innovative Solutions',
        'Our innovative solutions can change your life.'
    ),
    (
        2,
        'bi bi-bounding-box-circles',
        'Инновационные решения',
        'Наши инновационные решения могут изменить вашу жизнь.'
    ),
    (
        3,
        'bi bi-bounding-box-circles',
        'Innovatsion yechimlar',
        'Bizning innovatsion yechimlarimiz hayotingizni o‘zgartirishi mumkin.'
    ),
    (
        1,
        'bi bi-calendar4-week',
        'Free Consultations',
        'Get free advice from our experts and grow.'
    ),
    (
        2,
        'bi bi-calendar4-week',
        'Бесплатные консультации',
        'Получите бесплатные советы от наших экспертов и развивайтесь.'
    ),
    (
        3,
        'bi bi-calendar4-week',
        'Bepul maslahatlar',
        'Bizning mutaxassislarimizdan bepul maslahatlar oling va rivojlaning.'
    ),
    (
        1,
        'bi bi-broadcast',
        'Strong Network',
        'Gain access to numerous opportunities through our network.'
    ),
    (
        2,
        'bi bi-broadcast',
        'Сильная сеть',
        'Получите доступ к множеству возможностей через нашу сеть.'
    ),
    (
        3,
        'bi bi-broadcast',
        'Kuchli tarmoq',
        'Bizning tarmog‘imiz orqali ko‘plab imkoniyatlarga ega bo‘ling.'
    );

INSERT INTO
    statistics (lang_id, icon, count, title, description)
VALUES
    (
        1,
        'bi bi-emoji-smile',
        232,
        'Happy Clients',
        'Our success'
    ),
    (
        2,
        'bi bi-emoji-smile',
        232,
        'Счастливые клиенты',
        'Наш успех'
    ),
    (
        3,
        'bi bi-emoji-smile',
        232,
        'Baxtli mijozlar',
        'Bizning muvaffaqiyatimiz'
    ),
    (
        1,
        'bi bi-journal-richtext',
        521,
        'Projects',
        'Our creativity'
    ),
    (
        2,
        'bi bi-journal-richtext',
        521,
        'Проекты',
        'Наше творчество'
    ),
    (
        3,
        'bi bi-journal-richtext',
        521,
        'Loyihalar',
        'Bizning ijodkorligimiz'
    ),
    (
        1,
        'bi bi-headset',
        1453,
        'Support Hours',
        'We are always there for clients'
    ),
    (
        2,
        'bi bi-headset',
        1453,
        'Часы поддержки',
        'Мы всегда рядом с клиентами'
    ),
    (
        3,
        'bi bi-headset',
        1453,
        'Qo‘llab-quvvatlash soatlari',
        'Biz mijozlar uchun har doim mavjudmiz'
    ),
    (1, 'bi bi-people', 32, 'Workers', 'Our team'),
    (
        2,
        'bi bi-people',
        32,
        'Работники',
        'Наша команда'
    ),
    (
        3,
        'bi bi-people',
        32,
        'Ishchilar',
        'Bizning jamoamiz'
    );

INSERT INTO
    about_section (lang_id, title, description, details, image_url)
VALUES
    (
        1,
        'Our Services',
        'Our team always strives to achieve the best results. We continue to improve our skills and provide the most effective solutions for our clients.',
        'Building long-term and trustworthy partnerships with our clients is our main goal.',
        'assets/img/about.jpg'
    ),
    (
        2,
        'Наши Услуги',
        'Наша команда всегда стремится достичь наилучших результатов. Мы продолжаем улучшать свои навыки и предоставлять самые эффективные решения для наших клиентов.',
        'Создание долгосрочных и надежных партнерских отношений с нашими клиентами — наша главная цель.',
        'assets/img/about.jpg'
    ),
    (
        3,
        'Bizning Xizmatlarimiz',
        'Jamoamiz har doim eng yaxshi natijalarga erishishga intiladi. Biz o‘z malakalarimizni yaxshilashda davom etamiz va mijozlarimiz uchun eng samarali yechimlarni taqdim etamiz.',
        'Mijozlarimiz bilan uzoq muddatli va ishonchli hamkorlikni o‘rnatish bizning asosiy maqsadimizdir.',
        'assets/img/about.jpg'
    );

INSERT INTO
    about_details (lang_id, about_id, list_item)
VALUES
    (
        1,
        1,
        'We provide quality service to our clients and aim to meet their needs.'
    ),
    (
        2,
        1,
        'Мы предоставляем качественные услуги нашим клиентам и стремимся удовлетворить их потребности.'
    ),
    (
        3,
        1,
        'Biz mijozlarimizga sifatli xizmatlar ko‘rsatamiz va ularning ehtiyojlarini qondirishni maqsad qilganmiz.'
    ),
    (
        1,
        1,
        'We develop innovative solutions and apply modern technologies.'
    ),
    (
        2,
        1,
        'Мы разрабатываем инновационные решения и применяем современные технологии.'
    ),
    (
        3,
        1,
        'Biz innovatsion yechimlar ishlab chiqamiz va zamonaviy texnologiyalarni qo‘llaymiz.'
    ),
    (
        1,
        1,
        'We approach each project individually and offer new solutions.'
    ),
    (
        2,
        1,
        'Мы подходим к каждому проекту индивидуально и предлагаем новые решения.'
    ),
    (
        3,
        1,
        'Har bir loyihaga alohida yondashamiz va yangi yechimlar taklif etamiz.'
    ),
    (
        1,
        1,
        'Our experienced professionals assist with any issues.'
    ),
    (
        2,
        1,
        'Наши опытные специалисты помогут с любыми вопросами.'
    ),
    (
        3,
        1,
        'Bizning tajribali mutaxassislarimiz har qanday masalada yordam beradi.'
    ),
    (
        1,
        1,
        'Our support service is always open for our clients.'
    ),
    (
        2,
        1,
        'Наша служба поддержки всегда открыта для наших клиентов.'
    ),
    (
        3,
        1,
        'Bizning qo‘llab-quvvatlash xizmati mijozlarimiz uchun har doim ochiq.'
    ),
    (
        1,
        1,
        'We improve service quality through innovative approaches.'
    ),
    (
        2,
        1,
        'Мы улучшаем качество обслуживания с помощью инновационных подходов.'
    ),
    (
        3,
        1,
        'Biz xizmat sifatini innovatsion yondashuvlar orqali yaxshilaymiz.'
    ),
    (
        1,
        1,
        'We create special strategies for each project.'
    ),
    (
        2,
        1,
        'Мы разрабатываем специальные стратегии для каждого проекта.'
    ),
    (
        3,
        1,
        'Har bir loyiha uchun maxsus strategiyalar ishlab chiqamiz.'
    ),
    (
        1,
        1,
        'We help our clients unlock new opportunities.'
    ),
    (
        2,
        1,
        'Мы помогаем нашим клиентам открыть новые возможности.'
    ),
    (
        3,
        1,
        'Biz mijozlarimizga yangi imkoniyatlarni kashf qilishda yordam beramiz.'
    );

INSERT INTO
    service (lang_id, title, description, icon)
VALUES
    (
        1,
        'Our Services',
        'We provide tailored solutions for each client. Discover our reliable and effective services.',
        'bi-activity'
    ),
    (
        2,
        'Наши Услуги',
        'Мы предоставляем индивидуальные решения для каждого клиента. Ознакомьтесь с нашими надежными и эффективными услугами.',
        'bi-activity'
    ),
    (
        3,
        'Bizning Xizmatlarimiz',
        'Har bir mijoz uchun moslashtirilgan yechimlar taqdim etamiz. Ishonchli va samarali xizmatlarimiz bilan tanishing.',
        'bi-activity'
    ),
    (
        1,
        'Customized Solutions',
        'Our services are designed to meet each client’s needs. We provide the best solution for you.',
        'bi-broadcast'
    ),
    (
        2,
        'Индивидуальные решения',
        'Наши услуги разработаны с учетом потребностей каждого клиента. Мы предлагаем лучшее решение для вас.',
        'bi-broadcast'
    ),
    (
        3,
        'Maxsus Yechimlar',
        'Xizmatlarimiz har bir mijozning ehtiyojlariga mos ravishda ishlab chiqilgan. Siz uchun eng yaxshi yechimni taqdim etamiz.',
        'bi-broadcast'
    ),
    (
        1,
        'Innovative Approaches',
        'We solve your problems with innovative approaches. Every service offers creative solutions.',
        'bi-easel'
    ),
    (
        2,
        'Инновационные подходы',
        'Мы решаем ваши проблемы с помощью инновационных подходов. Каждая услуга предлагает творческие решения.',
        'bi-easel'
    ),
    (
        3,
        'Innovatsion Yondashuvlar',
        'Muammolaringizni innovatsion yondashuvlar orqali hal qilamiz. Har bir xizmat ijodiy yechimlar taklif etadi.',
        'bi-easel'
    ),
    (
        1,
        'Fast and Efficient Services',
        'Our services are fast and efficient, with a strong focus on quality. Your needs come first.',
        'bi-bounding-box-circles'
    ),
    (
        2,
        'Быстрое и эффективное обслуживание',
        'Наши услуги быстрые и эффективные, с акцентом на качество. Ваши потребности на первом месте.',
        'bi-bounding-box-circles'
    ),
    (
        3,
        'Tez va Samarali Xizmatlar',
        'Xizmatlarimiz tez va samarali, sifatga kuchli e’tibor qaratiladi. Sizning ehtiyojlaringiz birinchi o‘rinda.',
        'bi-bounding-box-circles'
    ),
    (
        1,
        'Expert Advice',
        'Our experts are ready to provide the best advice. Feel free to reach out with any questions or concerns.',
        'bi-calendar4-week'
    ),
    (
        2,
        'Экспертные консультации',
        'Наши эксперты готовы предоставить лучшие советы. Не стесняйтесь обращаться с любыми вопросами или проблемами.',
        'bi-calendar4-week'
    ),
    (
        3,
        'Mutaxassis Maslahati',
        'Bizning mutaxassislarimiz eng yaxshi maslahatlarni taqdim etishga tayyor. Har qanday savollar yoki muammolar bilan murojaat qiling.',
        'bi-calendar4-week'
    ),
    (
        1,
        'Client Communication',
        'We maintain open and friendly communication with clients. Your feedback and suggestions are very important to us.',
        'bi-chat-square-text'
    ),
    (
        2,
        'Связь с клиентами',
        'Мы поддерживаем открытую и дружелюбную коммуникацию с клиентами. Ваши отзывы и предложения очень важны для нас.',
        'bi-chat-square-text'
    ),
    (
        3,
        'Mijozlar Bilan Aloqa',
        'Biz mijozlar bilan ochiq va do‘stona aloqa o‘rnatamiz. Sizning fikr-mulohazalaringiz va takliflaringiz biz uchun juda muhim.',
        'bi-chat-square-text'
    );

INSERT INTO
    service_details (
        lang_id,
        title,
        description,
        image,
        subtitle,
        additional_info
    )
VALUES
    (
        1,
        'Our Services',
        'Our experience and skills help us to deliver the best projects to you.',
        'skills.jpg',
        'Our project Development Skills',
        'We use modern technologies to create our projects.'
    ),
    (
        2,
        'Наши Услуги',
        'Наши опыт и навыки помогают нам предоставить вам лучшие проекты.',
        'skills.jpg',
        'Наши навыки разработки проектов',
        'Мы используем современные технологии для создания наших проектов.'
    ),
    (
        3,
        'Bizning Xizmatlarimiz',
        'Bizning tajribamiz va malakalarimiz sizga eng yaxshi loyihalarni taqdim etishda yordam beradi.',
        'skills.jpg',
        'Bizning loyiha ishlab chiqish ko‘nikmalarimiz',
        'Biz zamonaviy texnologiyalarni loyihalarimizni yaratish uchun ishlatamiz.'
    );

INSERT INTO
    team_services (lang_id, service_name, skill_level)
VALUES
    (1, 'Web Development', 90),
    (1, 'Mobile Development', 85),
    (1, 'Cybersecurity', 80),
    (1, 'Database', 95),
    (1, 'UI/UX Design', 75),
    (2, 'Веб-разработка', 90),
    (2, 'Мобильная разработка', 85),
    (2, 'Кибербезопасность', 80),
    (2, 'База данных', 95),
    (2, 'UI/UX Дизайн', 75),
    (3, 'Veb Rivojlantirish', 90),
    (3, 'Mobil Dasturlash', 85),
    (3, 'Kiberxavfsizlik', 80),
    (3, 'Ma’lumotlar Bazasi', 95),
    (3, 'UI/UX Dizayni', 75);

INSERT INTO
    category (category_name)
VALUES
    ('App'),
    ('project'),
    ('Branding'),
    ('Book');

INSERT INTO
    contact (telegram, instagram, youtube, github)
VALUES
    (
        'iqbolshoh_777',
        'iqbolshoh_777',
        'iqbolshoh_dev',
        'iqbolshoh'
    );

INSERT INTO
    contact_box (lang_id, title, value, icon)
VALUES
    (1, 'Address', 'Samarkand City', 'bi bi-geo-alt'),
    (
        1,
        'Contact Us',
        '+998 99 779 93 33',
        'bi bi-telephone'
    ),
    (
        1,
        'Send Us an Email',
        'iilhomjonov777@gmail.com',
        'bi bi-envelope'
    ),
    (2, 'Адрес', 'Город Самарканд', 'bi bi-geo-alt'),
    (
        2,
        'Связаться с нами',
        '+998 99 779 93 33',
        'bi bi-telephone'
    ),
    (
        2,
        'Отправьте нам письмо',
        'iilhomjonov777@gmail.com',
        'bi bi-envelope'
    ),
    (3, 'Manzil', 'Samarqand Shahri', 'bi bi-geo-alt'),
    (
        3,
        'Biz bilan bog‘laning',
        '+998 99 779 93 33',
        'bi bi-telephone'
    ),
    (
        3,
        'Bizga Email yuboring',
        'iilhomjonov777@gmail.com',
        'bi bi-envelope'
    );

INSERT INTO
    projects (
        lang_id,
        category_id,
        project_name,
        link,
        description
    )
VALUES
    (
        1,
        1,
        'App 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        2,
        'Project 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        3,
        'Branding 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        4,
        'Books 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        1,
        'App 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        2,
        'Project 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        3,
        'Branding 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        4,
        'Books 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        1,
        'App 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        2,
        'Project 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        3,
        'Branding 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        4,
        'Books 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        1,
        'Приложение 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        2,
        'Проект 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        3,
        'Брендинг 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        4,
        'Книги 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        1,
        'Приложение 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        2,
        'Проект 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        3,
        'Брендинг 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        4,
        'Книги 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        1,
        'Приложение 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        2,
        'Проект 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        3,
        'Брендинг 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        4,
        'Книги 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        1,
        'Ilova 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        2,
        'Loyiha 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        3,
        'Brending 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        4,
        'Kitoblar 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        1,
        'Ilova 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        2,
        'Loyiha 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        3,
        'Brending 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        4,
        'Kitoblar 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        1,
        'Ilova 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        2,
        'Loyiha 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        3,
        'Brending 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        4,
        'Kitoblar 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    );

INSERT INTO
    project_images (project_id, image_url)
VALUES
    (1, 'app-1.jpg'),
    (2, 'product-1.jpg'),
    (3, 'branding-1.jpg'),
    (4, 'books-1.jpg'),
    (5, 'app-2.jpg'),
    (6, 'product-2.jpg'),
    (7, 'branding-2.jpg'),
    (8, 'books-2.jpg'),
    (9, 'app-3.jpg'),
    (10, 'product-3.jpg'),
    (11, 'branding-3.jpg'),
    (12, 'books-3.jpg'),
    (1, 'product-1.jpg'),
    (1, 'branding-1.jpg');

INSERT INTO
    messages (name, email, subject, message, status)
VALUES
    (
        'Shodmon Abdurahimov',
        'shodmon.abdurahimov@example.com',
        'Code Review Request',
        'Hi Iqbolshoh, could you review my recent code and give feedback? I trust your insights will help me improve!',
        'no_checked'
    ),
    (
        'Kamola Ergasheva',
        'kamola.ergasheva@example.com',
        'Platform Assistance',
        'Dear Iqbolshoh, I need some guidance with navigating your platform. Can you assist me with the features?',
        'no_checked'
    );
