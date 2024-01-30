<?php

    include_once("conn.php");

    $method = $_SERVER["REQUEST_METHOD"];

    if($method === "GET"){
        // Fetches the data, processes the order
        $edgesQuery = $conn->query("SELECT * FROM bordas;");

        $edges = $edgesQuery->fetchAll();

        $doughsQuery = $conn->query("SELECT * FROM massas;");

        $doughs = $doughsQuery->fetchAll();

        $flavorsQuery = $conn->query("SELECT * FROM sabores;");

        $flavors = $flavorsQuery->fetchAll();
        
    } else if($method === "POST"){
        // Creates the order
        $data = $_POST;
        $edge = $data["edge"];
        $dough = $data["dough"];
        $flavors = $data["flavors"];

        if(count($flavors) > 3){
            $_SESSION['msg'] = "Select up to 3 flavors!";
            $_SESSION['status'] = "warning";
        }else{
            $stmt = $conn->prepare("INSERT INTO pizzas (borda_id, massa_id) VALUES (:edge, :dough)");
        
            $stmt->bindParam(":edge", $edge, PDO::PARAM_INT);
            $stmt->bindParam(":dough", $dough, PDO::PARAM_INT);
            $stmt->execute();

            $pizzaId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO pizza_sabor (pizza_id, sabor_id) VALUES (:pizza, :flavor)");

            foreach($flavors as $flavor){
                $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
                $stmt->bindParam(":flavor", $flavor, PDO::PARAM_INT);
                $stmt->execute();
            }

            $stmt = $conn->prepare("INSERT INTO pedidos (pizza_id, status_id) VALUES (:pizza, :status)");
            $statusId = 1;
            
            $stmt->bindParam(":pizza", $pizzaId);
            $stmt->bindParam(":status", $statusId);
            $stmt->execute();

            $_SESSION['msg'] = "Order successful!";
            $_SESSION['status'] = "success";
        }

        header("Location: ..");
    }
?>