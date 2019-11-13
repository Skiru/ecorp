CREATE TABLE IF NOT EXISTS users_aggregate_roots (
     id UUID NOT NULL,
     event_data text NOT NULL,
     event_class_name varchar(255) NOT NULL,
     created_at TIMESTAMP NOT NULL,
     PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS users (
     id UUID NOT NULL,
     username VARCHAR(255) NOT NULL,
     email VARCHAR(255) NOT NULL,
     age SMALLINT NOT NULL,
     PRIMARY KEY (id)
);



