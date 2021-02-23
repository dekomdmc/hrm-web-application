
create TABLE if not exists chart_of_account_groups(
    id int primary key auto_increment,
    name varchar(100) not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
insert into chart_of_account_groups(name)values('Income'),('Expenses');

create TABLE if not exists chart_of_accounts(
    id int primary key auto_increment,
    group_id int, Foreign key (group_id) references chart_of_account_groups(id),
    name varchar(100),
    created_by int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);