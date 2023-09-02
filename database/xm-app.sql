-- Create a table to store company symbols
CREATE TABLE company_symbols (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(255) NOT NULL
);

-- Create a table to store historical data
CREATE TABLE historical_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol_id INT NOT NULL,
    date DATE NOT NULL,
    open DECIMAL(10, 2) NOT NULL,
    high DECIMAL(10, 2) NOT NULL,
    low DECIMAL(10, 2) NOT NULL,
    close DECIMAL(10, 2) NOT NULL,
    volume INT NOT NULL,
    FOREIGN KEY (symbol_id) REFERENCES company_symbols(id)
);

-- Create a table to store user data (for email submission)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL
);
