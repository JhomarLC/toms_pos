<?php
session_start();
require("./db_connection.php");

date_default_timezone_set('Asia/Manila');


if (isset($_POST['action']) && $_POST['action'] == "get_weekly_sales") {
    $query = "SELECT
            DATE_FORMAT(calendar_date, '%a') AS shorten_day,
            DAYOFWEEK(calendar_date) AS day_of_week,
            DAYOFWEEK(curdate()) as day_today,
            calendar_date AS sale_day,
            COALESCE(SUM(CASE WHEN status != 'refunded' THEN total ELSE 0 END), 0) AS daily_sales
        FROM
            (
                SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
            ) calendar
            LEFT JOIN orders ON DATE(orders.order_date) = calendar.calendar_date AND orders.status != 'refunded'
        WHERE calendar_date >= CURDATE() - INTERVAL 6 DAY
        GROUP BY sale_day
        HAVING day_of_week >= 1 and day_of_week <= day_today
        ORDER BY sale_day ASC;";

    $stmt = $connection->prepare($query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $dailyName = array();
        $dailySalesArray = array();

        while ($sales = $result->fetch_assoc()) {
            $dailySalesArray[] = $sales['daily_sales'];
            $dailyName[] = $sales['shorten_day'];
        }

        echo json_encode(array("sales" => $dailySalesArray, "days" => $dailyName));
        exit;
    } else {
        // Handle the case where the query execution fails
        echo json_encode(array("error" => "Query execution failed"));
        exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == "get_monthly_sales") {
    $query = "SELECT
             DATE_FORMAT(calendar_date, '%b %e') AS shorten_day,
            calendar_date AS sale_day,
            COALESCE(SUM(CASE WHEN status != 'refunded' THEN total ELSE 0 END), 0) AS daily_sales
        FROM
            (
                SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                WHERE MONTH(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) = MONTH(CURDATE())
            ) calendar
            LEFT JOIN orders ON DATE(orders.order_date) = calendar.calendar_date AND orders.status != 'refunded'
        WHERE MONTH(calendar_date) = MONTH(CURDATE()) AND YEAR(calendar_date) = YEAR(CURDATE())
        GROUP BY sale_day
        ORDER BY sale_day ASC;";

    $stmt = $connection->prepare($query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $dailyName = array();
        $dailySalesArray = array();

        while ($sales = $result->fetch_assoc()) {
            $dailySalesArray[] = $sales['daily_sales'];
            $dailyName[] = $sales['shorten_day'];
        }

        echo json_encode(array("sales" => $dailySalesArray, "days" => $dailyName));
        exit;
    } else {
        // Handle the case where the query execution fails
        echo json_encode(array("error" => "Query execution failed"));
        exit;
    }
}
?>