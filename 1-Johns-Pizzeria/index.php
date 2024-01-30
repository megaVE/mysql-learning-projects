<?php
    include_once("templates/header.php");
    include_once("process/pizza.php");
?>
    <div id="main-banner">
        <h1>Make your Order</h1>
    </div>
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Custom your pizza as you wish:</h2>
                    <form action="process/pizza.php" method="POST" id="pizza-form">
                        <div class="form-group">
                            <label for="edge">Edge:</label>
                            <select name="edge" id="edge" class="form-control">
                                <option value="">Select the edge</option>
                                <?php foreach($edges as $edge): ?>
                                    <option value="<?= $edge['id'] ?>"><?= $edge['tipo'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dough">Dough:</label>
                            <select name="dough" id="dough" class="form-control">
                                <option value="">Select the dough</option>
                                <?php foreach($doughs as $dough): ?>
                                    <option value="<?= $dough['id'] ?>"><?= $dough['tipo'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="flavors">Flavors: (Max 3)</label>
                            <select multiple name="flavors[]" id="flavors" class="form-control">
                                <?php foreach($flavors as $flavor): ?>
                                    <option value="<?= $flavor['id'] ?>"><?= $flavor['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Finish Order">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once("templates/footer.php");
?>