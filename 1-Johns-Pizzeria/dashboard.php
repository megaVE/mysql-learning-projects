<?php
    include_once("templates/header.php");
    include_once("process/orders.php");
?>
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="cold-md-12">
                    <h2>Manage orders:</h2>
                </div>
                <div class="col-md-12 table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><span>Order</span> #</th>
                                <th scope="col">Edge</th>
                                <th scope="col">Dough</th>
                                <th scope="col">Flavors</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pizzas as $pizza): ?>
                                <tr>
                                    <td>#<?= $pizza['id'] ?></td>
                                    <td><?= $pizza['edge'] ?></td>
                                    <td><?= $pizza['dough'] ?></td>
                                    <td>
                                        <ul>
                                            <?php foreach($pizza['flavors'] as $flavor): ?>
                                                <li><?= $flavor; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="process/orders.php" method="POST" class="form-group update-form">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="id" value="<?= $pizza['id'] ?>">
                                            <select name="status" class="form-control status-input">
                                                <?php foreach($status as $state): ?>
                                                    <option value="<?= $state['id'] ?>" <?php echo ($state['id'] == $pizza['status']) ? "selected" : ""; ?>><?= $state['tipo'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="update-btn">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="process/orders.php" method="POST">
                                            <input type="hidden" name="type" value="delete">
                                            <input type="hidden" name="id" value="<?= $pizza['id'] ?>">
                                            <button type="submit" class="delete-btn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
<?php
    include_once("templates/footer.php");
?>