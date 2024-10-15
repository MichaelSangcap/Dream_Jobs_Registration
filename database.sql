CREATE TABLE engineers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    years_of_experience INT NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    programming_languages VARCHAR(100) NOT NULL
);
