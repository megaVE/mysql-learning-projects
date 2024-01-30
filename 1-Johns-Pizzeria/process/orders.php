<?php

    include_once("conn.php");

    $method = $_SERVER['REQUEST_METHOD'];

    if($method === "GET"){
        $orderQuery = $conn->query("SELECT * FROM pedidos;");

        $orders = $orderQuery->fetchAll();

        $pizzas = [];
        foreach($orders as $order){
            $pizza = [];
            $pizza['id'] = $order['pizza_id'];

            // Pizza
            $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");

            $pizzaQuery->bindParam(":pizza_id", $pizza['id']);

            $pizzaQuery->execute();

            $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

            // Edge
            $edgeQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :edge_id");

            $edgeQuery->bindParam(":edge_id", $pizzaData['borda_id']);

            $edgeQuery->execute();

            $edge = $edgeQuery->fetch(PDO::FETCH_ASSOC);

            $pizza['edge'] = $edge['tipo'];

            // Dough
            $doughQuery = $conn->prepare("SELECT * FROM massas WHERE id = :dough_id");

            $doughQuery->bindParam(":dough_id", $pizzaData['massa_id']);

            $doughQuery->execute();

            $dough = $doughQuery->fetch(PDO::FETCH_ASSOC);

            $pizza['dough'] = $dough['tipo'];

            // Flavors
            $flavorsQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");

            $flavorsQuery->bindParam(":pizza_id", $pizza['id']);

            $flavorsQuery->execute();

            $flavors = $flavorsQuery->fetchAll(PDO::FETCH_ASSOC);

            // Flavor
            $pizzaFlavors = [];

            $flavorQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :flavor_id");

            foreach($flavors as $flavor){
                $flavorQuery->bindParam(":flavor_id", $flavor['sabor_id']);
                $flavorQuery->execute();

                $flavorPizza = $flavorQuery->fetch(PDO::FETCH_ASSOC);

                array_push($pizzaFlavors, $flavorPizza['nome']);
            }

            $pizza['flavors'] = $pizzaFlavors;

            $pizza['status'] = $order['status_id'];

            array_push($pizzas, $pizza);
        }
        $statusQuery = $conn->query("SELECT * FROM status;");

        $status = $statusQuery->fetchAll();        
    } else if($method === "POST"){
        $type = $_POST['type'];

        $pizzaId = $_POST['id'];

        if($type == "delete"){
            $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id;");
            $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
            $deleteQuery->execute();

            $_SESSION['msg'] = "Order removed successfully!";
        } else if($type == "update"){
            $statusId = $_POST['status'];

            $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id");
            $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
            $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);
            $updateQuery->execute();

            $_SESSION['msg'] = "Order updated successfully!";
        }
        $_SESSION['status'] = "success";
        
        header("Location: ../dashboard.php");
    }

?>