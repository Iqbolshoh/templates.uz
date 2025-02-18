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
        '1f254bb82e64bde20137a2922989f6f57529c98e34d146b523a47898702b7231',
        'admin'
    );

INSERT INTO
    languages (language_name)
VALUES
    ('Eng'),
    ('Ru'),
    ('Uz');

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
    about (title, p1, p2, image)
VALUES
    (
        'Our Services',
        'Our team always strives to achieve the best results. We continue to improve our skills and provide the most effective solutions for our clients.',
        'Building long-term and trustworthy partnerships with our clients is our main goal.',
        'assets/img/about.jpg'
    );

INSERT INTO
    about_ul_items (about_id, list_item)
VALUES
    (
        1,
        'We provide quality service to our clients and aim to meet their needs.'
    ),
    (
        1,
        'We develop innovative solutions and apply modern technologies.'
    ),
    (
        1,
        'We approach each project individually and offer new solutions.'
    ),
    (
        1,
        'Our experienced professionals assist with any issues.'
    ),
    (
        1,
        'Our support service is always open for our clients.'
    ),
    (
        1,
        'We improve service quality through innovative approaches.'
    ),
    (
        1,
        'We create special strategies for each project.'
    ),
    (
        1,
        'We help our clients unlock new opportunities.'
    );

INSERT INTO
    bioServices (h2, p1, image, h3, p2)
VALUES
    (
        'Our Services',
        'Our experience and skills help us to deliver the best projects to you.',
        'skills.jpg',
        'Our project Development Skills',
        'We use modern technologies to create our projects.'
    );

INSERT INTO
    category (category_name)
VALUES
    ('App'),
    ('project'),
    ('Branding'),
    ('Book');

INSERT INTO
    contact (twitter, facebook, instagram, linkedin)
VALUES
    (
        'iqbolshoh_777',
        '',
        'iqbolshoh_777',
        'iiqbolshoh'
    );

INSERT INTO
    contact_box (title, value, icon)
VALUES
    ('Address', 'Samarkand City', 'bi bi-geo-alt'),
    (
        'Contact Us',
        '+998 99 779 93 33',
        'bi bi-telephone'
    ),
    (
        'Send Us an Email',
        'iilhomjonov777@gmail.com',
        'bi bi-envelope'
    );

INSERT INTO
    ourServices (service_name, skill_level)
VALUES
    ('Web Development', 90),
    ('Mobile Development', 85),
    ('Cybersecurity', 80),
    ('Database', 95),
    ('UI/UX Design', 75);

INSERT INTO
    projects (category_id, project_name, link, description)
VALUES
    (
        1,
        'App 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        'project 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        'Branding 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        4,
        'Books 1',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        'App 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        'project 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        'Branding 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        4,
        'Books 2',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        1,
        'App 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        2,
        'project 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        3,
        'Branding 3',
        'https://iqbolshoh.uz',
        'Lorem ipsum, dolor sit amet consectetur'
    ),
    (
        4,
        'Books 3',
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
    services (title, description, icon)
VALUES
    (
        'Our Services',
        'We provide tailored solutions for each client. Discover our reliable and effective services.',
        'bi-activity'
    ),
    (
        'Customized Solutions',
        'Our services are designed to meet each client’s needs. We provide the best solution for you.',
        'bi-broadcast'
    ),
    (
        'Innovative Approaches',
        'We solve your problems with innovative approaches. Every service offers creative solutions.',
        'bi-easel'
    ),
    (
        'Fast and Efficient Services',
        'Our services are fast and efficient, with a strong focus on quality. Your needs come first.',
        'bi-bounding-box-circles'
    ),
    (
        'Expert Advice',
        'Our experts are ready to provide the best advice. Feel free to reach out with any questions or concerns.',
        'bi-calendar4-week'
    ),
    (
        'Client Communication',
        'We maintain open and friendly communication with clients. Your feedback and suggestions are very important to us.',
        'bi-chat-square-text'
    );

INSERT INTO
    statistics (icon, count, title, description)
VALUES
    (
        'bi bi-emoji-smile',
        232,
        'Happy Clients',
        'our success'
    ),
    (
        'bi bi-journal-richtext',
        521,
        'Projects',
        'our creativity'
    ),
    (
        'bi bi-headset',
        1453,
        'Support Hours',
        'we are always there for clients'
    ),
    (
        'bi bi-people',
        32,
        'Workers',
        'our team'
    );

INSERT INTO
    messages (name, email, subject, message, status)
VALUES
    (
        'Aliya Karimova',
        'aliya.karimova@example.com',
        'New Project',
        'Hello Iqbolshoh, I am very interested in collaborating with you on a new project. Please let me know if we can discuss the details.',
        'no_checked'
    ),
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
    ),
    (
        'Farhod Yusupov',
        'farhod.yusupov@example.com',
        'Partnership Inquiry',
        'Greetings Iqbolshoh, I am reaching out to explore a potential partnership between our teams. I believe we have mutual goals that can benefit us both. Looking forward to your response.',
        'no_checked'
    );