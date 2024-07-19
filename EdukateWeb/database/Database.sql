CREATE TABLE IF NOT EXISTS Users
(
    user_id       INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(255) UNIQUE NOT NULL,
    password      VARCHAR(255)        NOT NULL,
    email         VARCHAR(255) UNIQUE NOT NULL,
    full_name     VARCHAR(255)        NOT NULL,
    user_type     ENUM('Student', 'Instructor', 'Admin') NOT NULL,
    photo_address VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Instructors
(
    instructor_id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT UNIQUE,
    bio            TEXT,
    specialization VARCHAR(255),
    facebook       VARCHAR(255),
    youtube        VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES Users (user_id)
);

CREATE TABLE IF NOT EXISTS Categories
(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) UNIQUE,
    description TEXT
);

CREATE TABLE IF NOT EXISTS Courses
(
    course_id     INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(255) NOT NULL,
    description   TEXT,
    instructor_id INT,
    category_id   INT,
    level         ENUM('Beginner', 'Intermediate', 'Advanced'),
    photo_address VARCHAR(255),
    rating        DECIMAL(3, 2),
    lessons_count INT,
    duration_hour INT,
    language      VARCHAR(50),
    price         DECIMAL(10, 2),
    FOREIGN KEY (instructor_id) REFERENCES Instructors (instructor_id),
    FOREIGN KEY (category_id) REFERENCES Categories (category_id)
);

CREATE TABLE IF NOT EXISTS Enrollments
(
    enrollment_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT,
    course_id         INT,
    enrollment_date   DATE,
    completion_status ENUM('in progress', 'completed'),
    grade             DECIMAL(5, 2),
    FOREIGN KEY (user_id) REFERENCES Users (user_id),
    FOREIGN KEY (course_id) REFERENCES Courses (course_id),
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Add Categories
INSERT INTO Categories (name, description)
VALUES
    ('Web Design', 'Courses related to web design principles and practices.'),
    ('Apps Design', 'Courses focusing on designing applications for various platforms.'),
    ('Marketing', 'Courses covering marketing strategies and techniques.'),
    ('Research', 'Courses involving research methodologies and practices.'),
    ('SEO', 'Courses on Search Engine Optimization for websites.');

-- Add Admin
INSERT INTO Users (username, password, email, full_name, user_type, photo_address)
VALUES ('admin', '1234', 'adminisss@gmail.com', 'Ali Badiee', 'admin', 'admin_photo.jpg');

-- Add Instructors
INSERT INTO Users (username, password, email, full_name, user_type, photo_address)
VALUES
    ('ins1', '123^3210', 'john_love@example.com', 'John Love', 'instructor', 'instructor1_photo.jpg'),
    ('ins2', '123^3211', 'jane_komkat@example.com', 'Jane Komkat', 'instructor', 'instructor2_photo.jpg'),
    ('ins3', '123^3212', 'alex_mentori@example.com', 'Alex Mentori', 'instructor', 'instructor3_photo.jpg'),
    ('ins4', '123^3213', 'emma_tupak@example.com', 'Emma Tupak', 'instructor', 'instructor4_photo.jpg'),
    ('ins5', '123^3214', 'ali_burak@example.com', 'Ali Burak', 'instructor', 'default.jpg'),
    ('ins6', '123^3215', 'ommar_katup@example.com', 'Ommar J. Katup', 'instructor', 'default.jpg'),
    ('ins7', '123^3216', 'david_doost@example.com', 'David Doost', 'instructor', 'default.jpg'),
    ('ins8', '123^3217', 'mary_janne@example.com', 'Mary Janne', 'instructor', 'default.jpg');

-- Add Instructors
INSERT INTO Instructors (user_id, bio, specialization, facebook, youtube)
VALUES
    (2, 'With over a decade of experience, John Love is an accomplished web design instructor known for his dynamic teaching style. His expertise extends to user interface design, creating visually stunning websites that blend aesthetics with functionality. John is dedicated to nurturing the next generation of web designers and instilling a deep understanding of design principles.', 'Web Design', 'https://www.facebook.com/john_love', 'https://www.youtube.com/john_love'),
    (3, 'As an authority in application design and development, Jane Komkat brings a wealth of knowledge to the classroom. With a proven track record of successful app projects, Jane is passionate about guiding students through the intricacies of app design. Her commitment to staying updated on the latest industry trends ensures that her students are well-prepared for the ever-evolving world of mobile applications.', 'Apps Design', 'https://www.facebook.com/jane_komkat', 'https://www.youtube.com/jane_komkat'),
    (4, 'A seasoned marketing professional, Alex Mentori is a true guru in the field. With a career spanning diverse industries, Alex has a unique perspective on crafting effective marketing strategies. His classes go beyond theory, providing practical insights drawn from years of hands-on experience. Students under Alex''s mentorship gain a comprehensive understanding of the marketing landscape.', 'Marketing', 'https://www.facebook.com/alex_mentori', 'https://www.youtube.com/alex_mentori'),
    (5, 'Specializing in SEO research, Emma Tupak is a dedicated expert committed to advancing knowledge in search engine optimization. Her research contributions have made a significant impact in the SEO community. Emma''s classes delve into the intricacies of SEO algorithms and techniques, empowering students to optimize digital content for maximum visibility and impact.', 'Research', 'https://www.facebook.com/emma_tupak', 'https://www.youtube.com/emma_tupak'),
    (6, 'Renowned as an SEO specialist, Ali Burak is on a mission to enhance online visibility. His courses focus on the technical and strategic aspects of SEO, equipping students with the tools to navigate the competitive online landscape. Ali''s hands-on approach ensures that students not only understand SEO theory but also gain practical skills applicable in real-world scenarios.', 'SEO', 'https://www.facebook.com/ali_burak', 'https://www.youtube.com/ali_burak'),
    (7, 'Passionate about optimizing web content for search engines, Ommar Katup is a dedicated SEO enthusiast. With a keen eye for detail, Ommar guides students in the art of crafting content that resonates with both users and search algorithms. His classes emphasize the importance of ethical SEO practices and staying ahead in the ever-evolving world of search engine optimization.', 'SEO', 'https://www.facebook.com/ommar_katup', 'https://www.youtube.com/ommar_katup'),
    (8, 'A creative force in web design, David Doost is a visionary dedicated to enhancing user experiences. His portfolio showcases a diverse range of visually appealing and user-friendly websites. David''s classes blend creativity with practical skills, encouraging students to think outside the box while mastering the technical aspects of web design.', 'Web Design', 'https://www.facebook.com/david_doost', 'https://www.youtube.com/david_doost'),
    (9, 'A marketing professional with a digital focus, Mary Janne brings strategic expertise to the classroom. Her classes cover the intricacies of digital marketing, from social media strategies to data-driven decision-making. Mary''s industry insights and case studies provide students with a holistic understanding of the rapidly evolving digital marketing landscape.', 'Marketing', 'https://www.facebook.com/mary_janne', 'https://www.youtube.com/mary_janne');

-- Add Students
INSERT INTO Users (username, password, email, full_name, user_type, photo_address)
VALUES
    ('std1', '123@1230', 'Michael_Student@example.com', 'Michael Student', 'student', 'default.jpg'),
    ('std2', '123@1231', 'Olivia_Learner@example.com', 'Olivia Learner', 'student', 'default.jpg'),
    ('std3', '123@1232', 'Liam_Apprentice@example.com', 'Liam Apprentice', 'student', 'default.jpg'),
    ('std4', '123@1233', 'Ava_Trainee@example.com', 'Ava Trainee', 'student', 'default.jpg'),
    ('std5', '123@1234', 'Noah_Pupil@example.com', 'Noah Pupil', 'student', 'default.jpg'),
    ('std6', '123@1235', 'Isabella_Scholar@example.com', 'Isabella Scholar', 'student', 'default.jpg'),
    ('std7', '123@1237', 'Sophia_Apprentice@example.com', 'Sophia Apprentice', 'student', 'default.jpg'),
    ('std8', '123@1238', 'Lucas_Learner@example.com', 'Lucas Learner', 'student', 'default.jpg'),
    ('std9', '123@1239', 'Amelia_Student@example.com', 'Amelia Student', 'student', 'default.jpg'),
    ('std10', '123@1240', 'Mia_Trainee@example.com', 'Mia Trainee', 'student', 'default.jpg'),
    ('std11', '123@1241', 'Ethan_Pupil2@example.com', 'Ethan Pupil', 'student', 'default.jpg'),
    ('std12', '123@1242', 'Harper_Scholar@example.com', 'Harper Scholar', 'student', 'default.jpg'),
    ('std13', '123@1243', 'William_Learner@example.com', 'William Learner', 'student', 'default.jpg'),
    ('std14', '123@1244', 'Abigail_Trainee@example.com', 'Abigail Trainee', 'student', 'default.jpg'),
    ('std15', '123@1245', 'Logan_Pupil@example.com', 'Logan Pupil', 'student', 'default.jpg'),
    ('std16', '123@1246', 'Emma_Student@example.com', 'Emma Student', 'student', 'default.jpg'),
    ('std17', '123@1247', 'Jackson_Learner@example.com', 'Jackson Learner', 'student', 'default.jpg'),
    ('std18', '123@1248', 'Sophie_Apprentice@example.com', 'Sophie Apprentice', 'student', 'default.jpg'),
    ('std19', '123@1249', 'Aiden_Trainee@example.com', 'Aiden Trainee', 'student', 'default.jpg'),
    ('std20', '123@1250', 'Scarlett_Pupil@example.com', 'Scarlett Pupil', 'student', 'default.jpg'),
    ('std21', '123@1251', 'Liam_Student@example.com', 'Liam Student', 'student', 'default.jpg'),
    ('std22', '123@1252', 'Ava_Learner@example.com', 'Ava Learner', 'student', 'default.jpg'),
    ('std23', '123@1253', 'Noah_Apprentice@example.com', 'Noah Apprentice', 'student', 'default.jpg'),
    ('std24', '123@1254', 'Olivia_Trainee@example.com', 'Olivia Trainee', 'student', 'default.jpg'),
    ('std25', '123@1255', 'Ethan_Pupil@example.com', 'Ethan Pupil', 'student', 'default.jpg'),
    ('std26', '123@1256', 'Isabella_Student@example.com', 'Isabella Student', 'student', 'default.jpg'),
    ('std27', '123@1257', 'Mason_Learner@example.com', 'Mason Learner', 'student', 'default.jpg'),
    ('std28', '123@1258', 'Ella_Apprentice@example.com', 'Ella Apprentice', 'student', 'default.jpg'),
    ('std29', '123@1259', 'Logan_Trainee@example.com', 'Logan Trainee', 'student', 'default.jpg'),
    ('std30', '123@1260', 'Avery_Pupil@example.com', 'Avery Pupil', 'student', 'default.jpg');

-- Add Web Design Courses
INSERT INTO Courses (title, description, instructor_id, category_id, level, photo_address, rating, lessons_count, duration_hour, language, price)
VALUES
    ('Web Design Fundamentals', 'Embark on your web design journey with this beginner-level course introducing you to the basic principles and practices of creating visually appealing websites. Explore foundational concepts such as layout, color theory, and typography. Acquire essential skills to kickstart your web design endeavors.', 1, 1, 'beginner', 'web_design_course1.jpg', 4.5, 10, 20, 'English', 49.99),
    ('Responsive Web Design', 'Dive into the world of responsive web design and learn how to create websites that work seamlessly on various devices. This intermediate-level course explores techniques for designing adaptive and user-friendly interfaces. Master the art of building websites that deliver a consistent experience across desktops, tablets, and mobile devices.', 1, 1, 'intermediate', 'web_design_course2.jpg', 4.2, 15, 25, 'English', 79.99),
    ('Advanced Web Design Techniques', 'Take your web design skills to the next level with this advanced-level course. Explore cutting-edge techniques for achieving a professional look in your designs. Delve into advanced layout strategies, graphic optimization, and interactive elements to create visually stunning and functional websites.', 1, 1, 'advanced', 'web_design_course3.jpg', 4.8, 20, 30, 'English', 99.99),
    ('Web Design Basics', 'Build a strong foundation in web design with this beginner-level course covering foundational concepts and principles. Explore essential elements such as color schemes, typography, and layout structures. Gain practical insights into creating visually appealing websites that engage users effectively.', 7, 1, 'beginner', 'web_design_course4.jpg', 4.0, 12, 18, 'English', 59.99),
    ('Interactive Web Design', 'Learn to create engaging and interactive user interfaces for web applications in this intermediate-level course. Explore the principles of interactivity, user engagement, and intuitive design. Acquire the skills to craft web interfaces that captivate users and enhance their overall experience.', 1, 1, 'intermediate', 'web_design_course5.jpg', 4.4, 18, 22, 'English', 69.99),
    ('Advanced CSS Styling', 'Take a deep dive into advanced CSS techniques for modern web design in this advanced-level course. Explore CSS3 features, animations, and styling methodologies. Master the art of crafting visually stunning and responsive layouts to elevate your web design projects.', 7, 1, 'advanced', 'web_design_course6.jpg', 4.7, 25, 35, 'English', 89.99),
    ('UX/UI Design Principles', 'Gain a comprehensive understanding of user experience (UX) and user interface (UI) design principles in this intermediate-level course. Explore the fundamentals of creating effective and user-friendly web solutions. Acquire skills in wireframing, prototyping, and design thinking for optimal user interactions.', 7, 1, 'intermediate', 'web_design_course7.jpg', 4.6, 20, 28, 'English', 74.99),
    ('Web Design for E-commerce', 'Explore design considerations and best practices for creating effective e-commerce websites in this advanced-level course. Dive into the unique challenges and opportunities of designing for online retail. Learn to optimize product pages, enhance user experience, and drive conversions in the e-commerce space.', 1, 1, 'advanced', 'web_design_course8.jpg', 4.9, 22, 32, 'English', 109.99),
    ('Mobile-First Design', 'Learn the principles and techniques of designing websites with a mobile-first approach in this intermediate-level course. Explore the importance of mobile optimization and responsive design. Acquire skills to create websites that deliver a seamless and engaging experience on various mobile devices.', 7, 1, 'intermediate', 'web_design_course9.jpg', 4.3, 16, 24, 'English', 64.99),
    ('Web Design Portfolio Building', 'Receive practical guidance on building a strong portfolio showcasing your web design skills in this advanced-level course. Explore effective portfolio presentation, project selection, and storytelling. Learn to create a compelling portfolio that highlights your expertise and attracts potential clients or employers.', 7, 1, 'advanced', 'web_design_course10.jpg', 4.8, 30, 40, 'English', 119.99);


-- Add App Design Courses
INSERT INTO Courses (title, description, instructor_id, category_id, level, photo_address, rating, lessons_count, duration_hour, language, price)
VALUES
    ('Mobile App Design Basics', 'Embark on the journey of designing captivating user interfaces for mobile applications with this beginner-level course. Explore the foundational principles of mobile app design, covering essential elements such as layout, navigation, and visual aesthetics. Acquire the skills needed to create user-friendly and visually appealing mobile interfaces.', 2, 2, 'beginner', 'apps_design_course1.jpg', 4.2, 12, 18, 'English', 59.99),
    ('UI/UX for Android Apps', 'Delve into the principles of creating engaging UI/UX for Android apps in this intermediate-level course. Gain insights into Android design guidelines, user experience considerations, and best practices for designing intuitive interfaces. Elevate your skills in crafting visually appealing and user-centric Android applications.', 2, 2, 'intermediate', 'apps_design_course2.jpg', 4.6, 18, 22, 'English', 69.99),
    ('iOS App Design Mastery', 'Master the art of designing user-friendly interfaces for iOS applications with this advanced-level course. Explore iOS design principles, human interface guidelines, and advanced UI/UX techniques specific to Apples ecosystem. Acquire the expertise to create seamless and visually stunning experiences for iOS users.', 2, 2, 'advanced', 'apps_design_course3.jpg', 4.9, 24, 28, 'English', 89.99),
    ('Cross-Platform App Design', 'Dive into the world of cross-platform mobile application design in this intermediate-level course. Explore design principles and strategies for creating applications that run seamlessly on multiple platforms. Learn to optimize the user experience across various devices and operating systems for maximum reach.', 2, 2, 'intermediate', 'apps_design_course4.jpg', 4.3, 15, 20, 'English', 64.99),
    ('User-Centered Design for Apps', 'Discover the importance of user-centered design in creating successful mobile applications in this advanced-level course. Explore user research methodologies, usability testing, and iterative design processes. Learn how to prioritize user needs and preferences to create apps that resonate with and delight your target audience.', 2, 2, 'advanced', 'apps_design_course5.jpg', 4.7, 20, 25, 'English', 79.99);


-- Add Marketing Courses
INSERT INTO Courses (title, description, instructor_id, category_id, level, photo_address, rating, lessons_count, duration_hour, language, price)
VALUES
    ('Digital Marketing Essentials', 'Dive into the fundamental aspects of digital marketing and unravel the core online promotion strategies that drive success. This beginner-level course equips you with the foundational knowledge needed to navigate the dynamic landscape of digital marketing. Explore key concepts, tools, and tactics essential for building a strong online presence.', 3, 3, 'beginner', 'marketing_course1.jpg', 4.7, 14, 20, 'English', 69.99),
    ('Social Media Marketing', 'Learn the art of creating impactful marketing campaigns on popular social media platforms. This intermediate-level course delves into the intricacies of social media marketing, providing insights into content creation, audience engagement, and campaign optimization. Elevate your social media marketing skills for effective brand promotion.', 3, 3, 'intermediate', 'marketing_course2.jpg', 4.4, 20, 25, 'English', 79.99),
    ('Advanced Marketing Analytics', 'Embark on a journey into the world of data-driven marketing strategies designed for better decision-making. This advanced-level course explores the power of analytics in shaping marketing decisions. Gain expertise in interpreting data, extracting actionable insights, and optimizing marketing campaigns for maximum impact.', 8, 3, 'advanced', 'marketing_course3.jpg', 4.8, 25, 30, 'English', 99.99),
    ('Content Marketing Fundamentals', 'Uncover the basics of content marketing and storytelling in this beginner-level course. Understand how to create compelling content that resonates with your target audience. Explore the art of storytelling to captivate and engage your audience effectively, laying the groundwork for successful content marketing strategies.', 8, 3, 'beginner', 'marketing_course4.jpg', 4.5, 18, 22, 'English', 74.99),
    ('Email Marketing Mastery', 'Master the craft of creating effective email marketing campaigns with this intermediate-level course. Explore email marketing strategies, campaign design, and audience segmentation. Acquire the skills to create personalized and impactful email campaigns that drive engagement and conversions.', 8, 3, 'intermediate', 'marketing_course5.jpg', 4.6, 15, 18, 'English', 64.99),
    ('Influencer Marketing Strategies', 'Unlock the potential of leveraging influencers in your marketing campaigns with this advanced-level course. Explore influencer marketing strategies, identification of key influencers, and collaboration techniques. Learn how to integrate influencers seamlessly into your marketing initiatives for enhanced reach and credibility.', 3, 3, 'advanced', 'marketing_course6.jpg', 4.2, 20, 28, 'English', 89.99),
    ('SEO Optimization Techniques', 'Optimize websites for search engines and enhance online visibility in this intermediate-level course. Explore SEO best practices, on-page and off-page optimization, and keyword strategies. Acquire the skills to improve search engine rankings and drive organic traffic to your website.', 8, 3, 'intermediate', 'marketing_course7.jpg', 4.9, 22, 25, 'English', 84.99),
    ('Video Marketing for Brands', 'Harness the power of video content to elevate brand visibility and engagement. This advanced-level course explores video marketing strategies, content creation, and platform optimization. Learn how to create compelling video content that resonates with your target audience and enhances your brand presence.', 3, 3, 'advanced', 'marketing_course8.jpg', 4.7, 18, 20, 'English', 79.99),
    ('Social Media Advertising', 'Discover effective strategies for advertising on various social media platforms with this intermediate-level course. Explore social media advertising techniques, ad creation, and audience targeting. Gain insights into optimizing your social media advertising campaigns for maximum impact and return on investment.', 3, 3, 'intermediate', 'marketing_course9.jpg', 4.3, 20, 30, 'English', 94.99),
    ('Marketing Funnel Optimization', 'Optimize marketing funnels for better conversion rates and customer retention in this advanced-level course. Explore the stages of a marketing funnel, customer journey mapping, and conversion optimization strategies. Acquire the skills to fine-tune your marketing funnels for increased efficiency and success.', 3, 3, 'advanced', 'marketing_course10.jpg', 4.8, 25, 35, 'English', 109.99),
    ('Mobile Marketing Strategies', 'Uncover strategies for marketing effectively on mobile platforms and apps in this intermediate-level course. Explore mobile marketing best practices, app promotion techniques, and mobile advertising strategies. Gain insights into reaching and engaging mobile audiences for successful marketing campaigns.', 8, 3, 'intermediate', 'marketing_course11.jpg', 4.4, 16, 22, 'English', 74.99),
    ('E-commerce Marketing Tactics', 'Explore marketing tactics tailored to promoting products and services in the e-commerce space. This advanced-level course delves into e-commerce marketing strategies, product promotion, and customer acquisition techniques. Learn how to navigate the unique challenges of marketing within the e-commerce ecosystem.', 8, 3, 'advanced', 'marketing_course12.jpg', 4.6, 22, 28, 'English', 99.99);

-- Add Research Courses
INSERT INTO Courses (title, description, instructor_id, category_id, level, photo_address, rating, lessons_count, duration_hour, language, price)
VALUES
    ('Research Methodologies', 'Embark on a comprehensive journey into the world of research methodologies. This beginner-level course introduces you to various research methodologies and their practical applications. Explore the foundations of research, setting the stage for your academic and professional exploration. Gain insights into choosing the right methodology for different research contexts.', 4, 4, 'beginner', 'research_course1.jpg', 4.5, 12, 18, 'English', 59.99),
    ('Qualitative Research Techniques', 'Immerse yourself in the realm of qualitative research with this intermediate-level course. Acquire in-depth knowledge of qualitative research methods and analysis techniques. Learn how to conduct meaningful qualitative studies and extract valuable insights from qualitative data. Enhance your skills in interpreting and presenting qualitative research findings.', 4, 4, 'intermediate', 'research_course2.jpg', 4.3, 18, 22, 'English', 69.99),
    ('Quantitative Data Analysis', 'Delve into the world of advanced quantitative data analysis techniques in this course designed for the advanced researcher. Explore statistical methods and tools for analyzing quantitative data effectively. Master the art of deriving meaningful conclusions from numerical data, adding depth to your research endeavors.', 4, 4, 'advanced', 'research_course3.jpg', 4.7, 24, 28, 'English', 89.99),
    ('Experimental Design in Research', 'Gain a profound understanding of experimental design and its application in research studies. This intermediate-level course provides insights into designing experiments, controlling variables, and ensuring the validity of research outcomes. Learn how to apply experimental design principles for robust and reliable research results.', 4, 4, 'intermediate', 'research_course4.jpg', 4.2, 15, 20, 'English', 64.99),
    ('Survey Research Methods', 'Unlock the principles and methods of conducting effective survey research with this advanced-level course. Explore survey design, sampling techniques, and data collection strategies. Master the art of crafting surveys that yield valuable and actionable insights. Elevate your expertise in utilizing surveys as a powerful research tool.', 4, 4, 'advanced', 'research_course5.jpg', 4.8, 20, 25, 'English', 79.99),
    ('Ethnographic Research Practices', 'Embark on a journey of exploration with this intermediate-level course on ethnographic research practices. Delve into immersive study techniques, participant observation, and cultural understanding. Acquire the skills to conduct ethnographic research for in-depth insights and a rich understanding of diverse communities and contexts.', 4, 4, 'intermediate', 'research_course6.jpg', 4.6, 18, 22, 'English', 69.99),
    ('Research Ethics and Integrity', 'Navigate the ethical considerations inherent in the research process with this advanced-level course. Understand the principles of research ethics, including informed consent, confidentiality, and responsible conduct. Gain insights into maintaining integrity throughout the research journey for ethical and responsible research practices.', 4, 4, 'advanced', 'research_course7.jpg', 4.4, 16, 18, 'English', 59.99),
    ('Case Study Analysis', 'Master the methods and techniques for conducting and analyzing case studies in this intermediate-level course. Explore the intricacies of case study design, data collection, and analysis. Learn how to draw meaningful conclusions from individual cases and apply case study findings to broader research contexts.', 4, 4, 'intermediate', 'research_course8.jpg', 4.7, 22, 30, 'English', 84.99),
    ('Systematic Literature Review', 'Embark on the journey of conducting a systematic review of literature in research with this advanced-level course. Learn systematic literature review methodologies, database searching, and critical analysis of existing literature. Acquire the skills to synthesize and present comprehensive literature reviews for your research endeavors.', 4, 4, 'advanced', 'research_course9.jpg', 4.5, 25, 35, 'English', 99.99),
    ('Action Research for Change', 'Apply action research methodologies for positive organizational change in this intermediate-level course. Explore the principles of action research, collaborative problem-solving, and intervention strategies. Learn how to leverage research to drive positive change within organizations and communities.', 4, 4, 'intermediate', 'research_course10.jpg', 4.3, 20, 28, 'English', 79.99),
    ('Mixed Methods Research', 'Integrate qualitative and quantitative methods in research studies with this advanced-level course. Explore the synergies between qualitative and quantitative approaches, fostering a holistic understanding of research topics. Learn how to combine methodologies for comprehensive research insights.', 4, 4, 'advanced', 'research_course11.jpg', 4.9, 30, 40, 'English', 109.99),
    ('Research Publication Strategies', 'Uncover strategies for successfully publishing research findings in academic journals. This intermediate-level course guides you through the publication process, from manuscript preparation to submission. Learn the intricacies of navigating the academic publishing landscape and enhancing the visibility of your research contributions.', 4, 4, 'intermediate', 'research_course12.jpg', 4.8, 18, 22, 'English', 69.99),
    ('Experimental Psychology Research', 'Apply research methods in experimental psychology studies with this advanced-level course. Explore experimental design, data collection, and statistical analysis specific to psychology research. Gain insights into conducting experiments that contribute to the understanding of human behavior and psychological phenomena.', 4, 4, 'advanced', 'research_course13.jpg', 4.6, 22, 25, 'English', 74.99),
    ('GIS and Spatial Analysis in Research', 'Utilize GIS and spatial analysis techniques in research projects with this intermediate-level course. Explore geographic information systems (GIS) and spatial data analysis for research applications. Acquire the skills to incorporate spatial analysis into your research projects for enhanced insights and visual representation of data.', 4, 4, 'intermediate', 'research_course14.jpg', 4.2, 16, 20, 'English', 64.99),
    ('Research Data Management', 'Master the effective management and organization of research data with this advanced-level course. Learn data management best practices, data organization strategies, and tools for maintaining data integrity. Enhance your skills in handling and documenting research data throughout the research lifecycle.', 4, 4, 'advanced', 'research_course15.jpg', 4.7, 25, 30, 'English', 89.99),
    ('Health Research Methods', 'Explore methods and approaches specific to health-related research studies in this intermediate-level course. Gain insights into designing and conducting health-related research, including epidemiological studies and clinical research methodologies. Elevate your expertise in contributing to the field of health research.', 4, 4, 'intermediate', 'research_course16.jpg', 4.4, 20, 25, 'English', 79.99),
    ('Business Research Strategies', 'Dive into strategies and methods for conducting research in the business domain with this advanced-level course. Explore business research methodologies, market research techniques, and data analysis for business insights. Acquire the skills to make informed business decisions based on robust research.', 4, 4, 'advanced', 'research_course17.jpg', 4.8, 22, 28, 'English', 99.99),
    ('Educational Research Design', 'Design and implement research studies in the field of education with this intermediate-level course. Explore educational research methodologies, curriculum evaluation, and assessment techniques. Learn how to contribute to the improvement of educational practices through rigorous and meaningful research.', 4, 4, 'intermediate', 'research_course18.jpg', 4.5, 18, 22, 'English', 69.99),
    ('Environmental Research Techniques', 'Uncover research techniques for studying environmental issues and concerns in this advanced-level course. Explore environmental sampling, data collection, and analysis methods. Acquire the skills to contribute to the understanding and preservation of the environment through impactful research.', 4, 4, 'advanced', 'research_course19.jpg', 4.3, 20, 25, 'English', 79.99),
    ('Psychological Research Analysis', 'Enhance your skills in analyzing and interpreting data in psychological research studies with this intermediate-level course. Explore statistical analysis specific to psychology, interpretation of psychological data, and drawing meaningful conclusions. Gain the expertise to contribute to the field of psychology through robust research analysis.', 4, 4, 'intermediate', 'research_course20.jpg', 4.9, 24, 28, 'English', 89.99);

-- Add SEO Courses
INSERT INTO Courses (title, description, instructor_id, category_id, level, photo_address, rating, lessons_count, duration_hour, language, price)
VALUES
    ('SEO Fundamentals', 'Explore the foundational principles and essential strategies for mastering Search Engine Optimization. This beginner-level course equips you with the fundamental knowledge to enhance your websites visibility on search engines. Dive into the world of SEO and optimize your online presence effectively.', 5, 5, 'beginner', 'seo_course1.jpg', 4.2, 14, 20, 'English', 69.99),
    ('Advanced SEO Techniques', 'Take your SEO skills to the next level with this intermediate course on advanced techniques. Learn cutting-edge strategies to boost your websites visibility and improve search engine rankings. Gain insights into advanced SEO practices that can elevate your online presence and drive organic traffic.', 5, 5, 'intermediate', 'seo_course2.jpg', 4.6, 20, 25, 'English', 79.99),
    ('Local SEO Mastery', 'Master the art of optimizing websites for local search results in this advanced SEO course. Delve into location-based strategies and techniques to enhance your websites visibility within specific geographic areas. Acquire the skills to dominate local search rankings and attract targeted audiences to your business.', 6, 5, 'advanced', 'seo_course3.jpg', 4.9, 25, 30, 'English', 99.99),
    ('SEO Content Creation', 'Uncover effective strategies for creating SEO-optimized content that resonates with search engines. This intermediate-level course provides insights into content creation techniques that align with SEO best practices. Enhance your ability to craft compelling and search-friendly content for improved online visibility.', 5, 5, 'intermediate', 'seo_course4.jpg', 4.4, 18, 22, 'English', 74.99),
    ('E-commerce SEO Strategies', 'Elevate your e-commerce websites search engine rankings with advanced SEO strategies. This course focuses on optimizing product pages, improving site structure, and implementing e-commerce-specific SEO techniques. Gain the expertise to enhance the online visibility of your e-commerce store.', 6, 5, 'advanced', 'seo_course5.jpg', 4.7, 22, 25, 'English', 84.99),
    ('Technical SEO Implementation', 'Master the implementation of technical SEO strategies for website improvement. In this intermediate course, delve into technical aspects such as site speed optimization, crawlability, and schema markup. Learn how to make impactful technical changes that positively influence your websites search engine performance.', 6, 5, 'intermediate', 'seo_course6.jpg', 4.5, 20, 28, 'English', 79.99),
    ('SEO Analytics and Reporting', 'Harness the power of analytics tools for monitoring and reporting SEO performance. This advanced course provides insights into tracking key metrics, interpreting data, and making informed decisions. Learn to create comprehensive SEO reports that showcase the impact of your optimization efforts.', 6, 5, 'advanced', 'seo_course7.jpg', 4.8, 25, 35, 'English', 109.99),
    ('Mobile SEO Optimization', 'Optimize websites for search engines on mobile devices with this intermediate-level course. Explore mobile SEO best practices, responsive design, and mobile-friendly strategies to improve your sites visibility on mobile search. Enhance your skills in catering to the growing mobile audience.', 5, 5, 'intermediate', 'seo_course8.jpg', 4.3, 16, 20, 'English', 64.99);

-- Add Enrollments
INSERT INTO Enrollments (user_id, course_id, enrollment_date, completion_status, grade)
VALUES
    (1, 1, '2024-01-18', 'completed', 95.0),
    (1, 2, '2024-01-18', 'completed', 100),
    (1, 3, '2024-01-18', 'completed', 100),
    (1, 4, '2024-01-18', 'completed', 100),
    (2, 1, '2024-01-19', 'in progress', 0),
    (2, 2, '2024-01-19', 'in progress', 0),
    (2, 6, '2024-01-19', 'in progress', 0),
    (3, 3, '2024-01-20', 'in progress', 0),
    (3, 4, '2024-01-20', 'in progress', 0),
    (4, 5, '2024-01-21', 'completed', 88.5),
    (4, 6, '2024-01-21', 'completed', 88.5),
    (4, 7, '2024-01-21', 'completed', 88.5),
    (5, 5, '2024-01-22', 'completed', 92.3),
    (5, 7, '2024-01-22', 'completed', 92.3),
    (5, 8, '2024-01-22', 'completed', 92.3),
    (5, 9, '2024-01-22', 'completed', 92.3),
    (6, 10, '2024-01-23', 'in progress', 0),
    (6, 11, '2024-01-23', 'in progress', 0),
    (6, 12, '2024-01-23', 'in progress', 0),
    (6, 13, '2024-01-23', 'in progress', 0),
    (6, 14, '2024-01-23', 'in progress', 0),
    (6, 15, '2024-01-23', 'in progress', 0),
    (7, 16, '2024-01-24', 'in progress', 0),
    (8, 1, '2024-01-25', 'completed', 78.9),
    (8, 4, '2024-01-25', 'completed', 99.2),
    (8, 15, '2024-01-25', 'completed', 78.9),
    (9, 1, '2024-01-26', 'completed', 96.2),
    (9, 2, '2024-01-26', 'completed', 96.2),
    (9, 3, '2024-01-26', 'completed', 96.2),
    (10, 5, '2024-01-27', 'in progress', 0);
