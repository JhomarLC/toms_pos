<?php
session_start();
require("./db_connection.php");

date_default_timezone_set('Asia/Manila');


if (isset($_POST['action'])){
    if($_POST['action'] == "get_weekly_sales") {
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
    if($_POST['action'] == "get_weekly_sales_chicken") {
        $category = mysqli_real_escape_string($connection, $_POST['category']);

        if($category == 'Others'){
            $query = "SELECT
                    DATE_FORMAT(calendar_date, '%a') AS shorten_day,
                    DAYOFWEEK(calendar_date) AS day_of_week,
                    DAYOFWEEK(CURDATE()) AS day_today,
                    calendar_date AS sale_day,
                    COALESCE(SUM(si.expense_total), 0) AS weekly_expense
                FROM
                    (
                        SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                        FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                        CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                        CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                    ) calendar
                    LEFT JOIN expenseinventory si ON DATE(si.stock_date) = calendar.calendar_date
                WHERE
                    calendar_date >= CURDATE() - INTERVAL 6 DAY
                GROUP BY
                    sale_day
                HAVING
                    day_of_week >= 1 AND day_of_week <= day_today
                ORDER BY
                    sale_day ASC;";
                    
            $stmt = $connection->prepare($query);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $dailyName = array();
                $dailySalesArray = array();

                while ($sales = $result->fetch_assoc()) {
                    $dailySalesArray[] = $sales['weekly_expense'];
                    $dailyName[] = $sales['shorten_day'];
                }

                echo json_encode(array("sales" => $dailySalesArray, "days" => $dailyName));
                exit;
            } else {
                // Handle the case where the query execution fails
                echo json_encode(array("error" => "Query execution failed"));
                exit;
            }
            $stmt->close();
        } else {
            $query = "SELECT
                DATE_FORMAT(calendar_date, '%a') AS shorten_day,
                DAYOFWEEK(calendar_date) AS day_of_week,
                DAYOFWEEK(CURDATE()) AS day_today,
                calendar_date AS sale_day,
                COALESCE(SUM(CASE WHEN si.stock_category = ? THEN si.expense_today ELSE 0 END), 0) AS weekly_expense
            FROM
                (
                    SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                    FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                ) calendar
                LEFT JOIN stockinventory si ON DATE(si.stock_date) = calendar.calendar_date
            WHERE
                calendar_date >= CURDATE() - INTERVAL 6 DAY
            GROUP BY
                sale_day
            HAVING
                day_of_week >= 1 AND day_of_week <= day_today
            ORDER BY
                sale_day ASC;
            ";
    
            $stmt = $connection->prepare($query);
            $stmt->bind_param("s", $category);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $dailyName = array();
                $dailySalesArray = array();

                while ($sales = $result->fetch_assoc()) {
                    $dailySalesArray[] = $sales['weekly_expense'];
                    $dailyName[] = $sales['shorten_day'];
                }

                echo json_encode(array("sales" => $dailySalesArray, "days" => $dailyName));
                exit;
            } else {
                // Handle the case where the query execution fails
                echo json_encode(array("error" => "Query execution failed"));
                exit;
            }
            $stmt->close();
        }
        
    }
    if($_POST['action'] == "get_weekly_orders") {
        $category  = mysqli_real_escape_string($connection, $_POST['category']);
        $query = "SELECT
                DATE_FORMAT(calendar_date, '%a') AS shorten_day,
                DAYOFWEEK(calendar_date) AS day_of_week,
                DAYOFWEEK(CURDATE()) AS day_today,
                calendar_date AS sale_day,
                COALESCE(COUNT(DISTINCT CASE WHEN c.category_id = ? THEN o.order_id END), 0) AS daily_orders
            FROM
                (
                    SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                    FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                ) calendar
            LEFT JOIN
                orders o ON DATE(o.order_date) = calendar.calendar_date AND o.status != 'refunded'
            LEFT JOIN
                orderItems oi ON o.order_id = oi.order_id
            LEFT JOIN
                items i ON oi.item_id = i.item_id
            LEFT JOIN
                category c ON i.category_id = c.category_id
            WHERE
                calendar_date >= CURDATE() - INTERVAL 6 DAY
            GROUP BY
                day_of_week, sale_day
            HAVING
                day_of_week >= 1 AND day_of_week <= day_today
            ORDER BY
                sale_day ASC;";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $category);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $dailyName = array();
            $dailySalesArray = array();

            while ($sales = $result->fetch_assoc()) {
                $dailySalesArray[] = $sales['daily_orders'];
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
    if($_POST['action'] == "get_monthly_sales") {
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
     
    if($_POST['action'] == "get_monthly_sales_chicken") {
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        if($category == "Others"){
            $query = "SELECT
                DATE_FORMAT(calendar_date, '%b %e') AS shorten_day,
                calendar_date AS sale_day,
                COALESCE(SUM(e.expense_total), 0) AS monthly_expense
            FROM
                (
                    SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                    FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                    WHERE MONTH(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) = MONTH(CURDATE())
                ) calendar
                LEFT JOIN expenseinventory e ON DATE(e.stock_date) = calendar.calendar_date
            WHERE
                MONTH(calendar_date) = MONTH(CURDATE()) AND YEAR(calendar_date) = YEAR(CURDATE())
            GROUP BY
                sale_day
            ORDER BY
                sale_day ASC;";
                    
                $stmt = $connection->prepare($query);
        } else {
        $query = "SELECT
                DATE_FORMAT(calendar_date, '%b %e') AS shorten_day,
                calendar_date AS sale_day,
                COALESCE(SUM(CASE WHEN si.stock_category = ? THEN si.expense_today ELSE 0 END), 0) AS monthly_expense
            FROM
                (
                    SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                    FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                    WHERE MONTH(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) = MONTH(CURDATE())
                ) calendar
                LEFT JOIN stockinventory si ON DATE(si.stock_date) = calendar.calendar_date
            WHERE
                MONTH(calendar_date) = MONTH(CURDATE()) AND YEAR(calendar_date) = YEAR(CURDATE())
            GROUP BY
                sale_day
            ORDER BY
                sale_day ASC;";
                
                $stmt = $connection->prepare($query);
                $stmt->bind_param("s", $category);
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $dailyName = array();
            $dailySalesArray = array();
    
            while ($sales = $result->fetch_assoc()) {
                $dailySalesArray[] = $sales['monthly_expense'];
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
    if($_POST['action'] == "get_monthly_orders") {
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $query = "SELECT
                DATE_FORMAT(calendar_date, '%b %e') AS shorten_day,
                DAYOFWEEK(calendar_date) AS day_of_week,
                DAYOFWEEK(CURDATE()) AS day_today,
                calendar_date AS sale_day,
                COALESCE(COUNT(DISTINCT CASE WHEN c.category_id = ? THEN o.order_id END), 0) AS monthly_orders
            FROM
                (
                    SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as calendar_date
                    FROM (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                    CROSS JOIN (SELECT 0 as a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) c
                    WHERE MONTH(CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY) = MONTH(CURDATE())
                ) calendar
            LEFT JOIN
                orders o ON DATE(o.order_date) = calendar.calendar_date AND o.status != 'refunded'
            LEFT JOIN
                orderItems oi ON o.order_id = oi.order_id
            LEFT JOIN
                items i ON oi.item_id = i.item_id
            LEFT JOIN
                category c ON i.category_id = c.category_id
            WHERE
                calendar_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01') -- First day of the current month
                AND calendar_date < DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH) -- First day of the next month
            GROUP BY
                day_of_week, sale_day
            ORDER BY
                sale_day ASC;";
    
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $category);
    
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $dailyName = array();
            $dailySalesArray = array();
    
            while ($sales = $result->fetch_assoc()) {
                $dailySalesArray[] = $sales['monthly_orders'];
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
}
?>