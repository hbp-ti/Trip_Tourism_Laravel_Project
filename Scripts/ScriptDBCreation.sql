CREATE TABLE if not exists "user"(
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    birthDate DATE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    username VARCHAR(20) UNIQUE NOT NULL,
    phone INT NOT NULL,
    password TEXT NOT NULL,
    image TEXT NOT NULL,

    CONSTRAINT chk_age CHECK (age(birthDate) >= INTERVAL '16 years')
);

CREATE TABLE if not exists notification(
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    description VARCHAR(100) NOT NULL,
    is_read BOOLEAN NOT NULL,
    user_id INT NOT NULL,

    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES "user"(id)
);

CREATE TABLE if not exists review(
    id SERIAL NOT NULL PRIMARY KEY,
    title VARCHAR(30) NOT NULL,
    description VARCHAR(200) NOT NULL,
    rating INT NOT NULL,
    user_id INT NOT NULL,
    item INT NOT NULL,

    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES "user"(id),
    CONSTRAINT fk_item FOREIGN KEY (item) REFERENCES Item(id),
    CONSTRAINT chk_rating CHECK ( rating BETWEEN 1 AND 5)
);

CREATE TABLE if not exists Item(
    id SERIAL NOT NULL PRIMARY KEY,
    item_type VARCHAR(30) NOT NULL,

    CONSTRAINT chk_type CHECK ( item_type == 'Hotel' OR item_type == 'Activity' OR item_type == 'Ticket')
);

CREATE TABLE if not exists image(
    id SERIAL PRIMARY KEY,
    url TEXT NOT NULL,
    item INT NOT NULL,

    CONSTRAINT fk_item FOREIGN KEY (item) REFERENCES item(id)
);

CREATE TABLE if not exists ticket(
    id_item INT PRIMARY KEY,
    transport_type VARCHAR(15) NOT NULL,
    train_class VARCHAR(15),
    departure_hour TIMESTAMP NOT NULL,
    quantity SMALLINT NOT NULL,
    total_price FLOAT NOT NULL,
    origin VARCHAR(30) NOT NULL,
    destination VARCHAR(30) NOT NULL,
    is_used BOOLEAN NOT NULL,

    CONSTRAINT fk_item FOREIGN KEY (id_item) REFERENCES Item(id),
    CONSTRAINT chk_trans_type CHECK (transport_type = 'Train' OR transport_type = 'Bus'),
    CONSTRAINT chk_trans_class CHECK (train_class = 'first' OR train_class = 'second')
);

CREATE TABLE if not exists hotel(
    id_item INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    price_night float NOT NULL,
    stars SMALLINT NOT NULL,
    average_guest_rating float DEFAULT 0,
    free_wifi BOOLEAN NOT NULL,
    parking BOOLEAN NOT NULL,
    gym BOOLEAN NOT NULL,
    pool BOOLEAN NOT NULL,
    spa_wellness BOOLEAN NOT NULL,
    hotel_restaurant BOOLEAN NOT NULL,
    bar BOOLEAN NOT NULL,
    refundable_reservations BOOLEAN NOT NULL,
    country VARCHAR(30) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    city VARCHAR(30) NOT NULL,
    street VARCHAR(60) NOT NULL,

    CONSTRAINT fk_item FOREIGN KEY (id_item) REFERENCES Item(id),
    CONSTRAINT chk_stars CHECK (stars >= 0 AND stars <= 5),
    CONSTRAINT aver_guest_rating CHECK (average_guest_rating >= 0 AND average_guest_rating <= 5)
);

CREATE TABLE if not exists activity(
    id_item INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    address_id INT NOT NULL,
    price_hour FLOAT NOT NULL,
    cancel_anytime BOOLEAN NOT NULL,
    reserve_now_pay_later BOOLEAN NOT NULL,
    guide BOOLEAN NOT NULL,
    small_groups BOOLEAN NOT NULL,
    language VARCHAR(20) NOT NULL,
    country VARCHAR(30) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    city VARCHAR(30) NOT NULL,
    street VARCHAR(60) NOT NULL,

    CONSTRAINT fk_item FOREIGN KEY (id_item) REFERENCES Item(id)
);

CREATE TABLE if not exists room(
    id SERIAL PRIMARY KEY,
    hotel_id INT NOT NULL,
    type VARCHAR(20) NOT NULL,
    bed_type VARCHAR(20) NOT NULL,
    bed_count SMALLINT NOT NULL,

    CONSTRAINT fk_hotel FOREIGN KEY (hotel_id) REFERENCES hotel(id_item)
);

CREATE TABLE if not exists cart(
    id SERIAL PRIMARY KEY,
    subtotal float NOT NULL,
    taxes int NOT NULL,
    total float NOT NULL,
    user_id INT NOT NULL,

    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES "user"(id)
);

CREATE TABLE if not exists cart_item(
    id SERIAL NOT NULL PRIMARY KEY,
    numb_people_hotel SMALLINT,
    room_type_hotel VARCHAR(20),
    reservation_date_hotel DATE,
    numb_people_activity SMALLINT,
    hours_activity TIME,
    train_type VARCHAR(20),
    train_people_count SMALLINT,
    cart_id INT NOT NULL,
    item_id INT NOT NULL,


    CONSTRAINT fk_cart FOREIGN KEY (cart_id) REFERENCES cart(id),
    CONSTRAINT fk_item FOREIGN KEY (item_id) REFERENCES Item(id)
);

CREATE TABLE if not exists "order"(
    id SERIAL PRIMARY KEY,
    subtotal float NOT NULL,
    taxes int NOT NULL,
    total float NOT NULL,
    date DATE NOT NULL,
    payment_method VARCHAR(20) NOT NULL,
    billing_country VARCHAR(20) NOT NULL,
    billing_city VARCHAR(20) NOT NULL,
    billing_address VARCHAR(50) NOT NULL,
    billing_postal_code VARCHAR(10) NOT NULL,
    user_id INT NOT NULL,

    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES "user"(id)
);

CREATE TABLE if not exists order_item(
    id SERIAL NOT NULL PRIMARY KEY,
    numb_people_hotel SMALLINT,
    room_type_hotel VARCHAR(20),
    reservation_date_hotel DATE,
    numb_people_activity SMALLINT,
    hours_activity TIME,
    train_type VARCHAR(20),
    train_people_count SMALLINT,
    order_id INT NOT NULL,
    item_id INT NOT NULL,


    CONSTRAINT fk_order FOREIGN KEY (order_id) REFERENCES "order"(id),
    CONSTRAINT fk_item FOREIGN KEY (item_id) REFERENCES Item(id)
);