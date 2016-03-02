desc stock_info_table;

INSERT INTO stock_current_table 
VALUES ('30','2000','1900','2100','2100','1900','2016-30-02','3000');

select * from stock_current_table;

select * from stock_info_table;

desc stock_info_table;
-- checking eventScheduler status
show processlist;

-- for switching event scheduler=on.
set global event_scheduler = on;

-- for switching event scheduler=off.
SET GLOBAL event_scheduler = OFF;
-- --------------------------------------------------------------
-- copying daily entry from current Table to older Table. 

INSERT INTO stock_info_table ( 
SELECT * from stock_current_table
where stock_current_table.Date = curdate());

-- -------------------------------------------------------------
-- Event to copy new entry from stock_current_table to stock_info_Table every 1 day. 

CREATE EVENT test_event
ON SCHEDULE EVERY 2 minute STARTS CURRENT_TIMESTAMP ON COMPLETION PRESERVE
DO
   INSERT INTO stock_info_table ( 
SELECT * from stock_current_table
where stock_current_table.Date = curdate());


DROP EVENT test_event;