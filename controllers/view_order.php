<?php
session_start();
require("./db_connection.php");

if (isset($_POST['action'])) {
    if ($_POST['action'] == "get_order_items") {
        $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);

        $query = "SELECT oi.*, i.*, o.order_date, o.total, o.cash, o.change_amount, o.discount, o.leftover FROM orderItems as oi INNER JOIN items as i ON oi.item_id = i.item_id INNER JOIN orders as o ON o.order_id = oi.order_id WHERE oi.order_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $order_id);
        $stmt->execute();   
        $result = $stmt->get_result();
        $order_date = "";
        $total_summary = "";
        $order_items = "";
        
        if($result->num_rows > 0){
            $order_item = $result->fetch_assoc();
            $order_date = date("M d, Y | h:i:s A", strtotime($order_item['order_date']));
            
            $total_summary .= '<div class="d-flex justify-content-between mb-2">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-5">Subtotal </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light fw-bold fs-5">P' . number_format(($order_item['discount'] + $order_item['total']) - $order_item['leftover'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
            // ------------------------------
            $total_summary .= '<div class="d-flex justify-content-between mb-2">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-5">Leftover </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light fw-bold fs-5">+ P' . number_format($order_item['leftover'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
            // ------------------------------
            $total_summary .= '<div class="d-flex justify-content-between mb-2">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-5">Discount </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light fw-bold fs-5">- P' . number_format($order_item['discount'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
            $total_summary .= '<div class="separator my-3"></div>'; 
            // ------------------------------
            $total_summary .= '<div class="d-flex justify-content-between mb-5">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-1">TOTAL </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light-success fw-bold fs-1">P' . number_format($order_item['total'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
            // ------------------------------
            $total_summary .= '<div class="d-flex justify-content-between mb-2">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-5">Cash </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light fw-bold fs-5">P' . number_format($order_item['cash'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
             // ------------------------------
            
            $total_summary .= '<div class="d-flex justify-content-between mb-2">';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="fw-bold fs-5">Change </div>';
                $total_summary .= '</div>';
                $total_summary .= '<div>';
                    $total_summary .= '<div class="badge badge-light fw-bold fs-5">P' . number_format($order_item['change_amount'], 2)  . '</div>';
                $total_summary .= '</div>';
            $total_summary .= '</div>';
            
            do{
                $order_items .= '<div class="d-flex justify-content-between mb-2">';
                    $order_items .= '<div>';
                        $order_items .= '<div class="badge badge-light-primary fw-bold fs-2">' . $order_item['item_name'] . '</div>';
                    $order_items .= '</div>';
                    $order_items .= '<div>';
                        $order_items .= '<div class="badge badge-light-success fw-bold fs-2">P' . number_format($order_item['item_total'], 2)  . '</div>';
                    $order_items .= '</div>';
                $order_items .= '</div>';
                $order_items .= '<div class="row justify-content-between">';
                    $order_items .= '<div class="col-3">' . $order_item['quantity'] . ' x P' . number_format($order_item['price'], 2);
                $order_items .= '</div>';
                $order_items .= '<div class="separator my-3"></div>'; 
            }while($order_item = $result->fetch_assoc());
            
            echo json_encode(
                array(
                    "order_items" => $order_items,
                    "order_id" => $order_id,
                    "order_date_time" => $order_date,
                    "total_summary" => $total_summary
                )
            );
        }
    }
    if ($_POST['action'] == "refund_order") {
        $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);
        $status = "refunded";
        
        $query = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $status, $order_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $activity_description = "Refunded an order $order_id";
            $activity_category = "Refund";
            include("./activitylog.php");
            
            echo json_encode(
                array(
                    "message" => "Order successfully refunded.",
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "Order failed to refund.",
                    "type" => "danger"
                )
            );
            exit;
        }
        $stmt->close();
    }
}
?>