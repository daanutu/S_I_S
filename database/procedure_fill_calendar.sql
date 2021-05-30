DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fill_calendar`(start_date DATE, end_date DATE)
BEGIN
       DECLARE crt_date DATE;
       SET crt_date=start_date;
       WHILE crt_date <= end_date DO INSERT INTO calendar VALUES(crt_date); 
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY); 
    END WHILE; END$$
DELIMITER ;