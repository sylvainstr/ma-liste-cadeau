<h2>Mes listes de cadeaux</h2>

  <?php foreach($lists as $list): ?>

    <p>NEW LIST</p>
    
    <h3><?= $list->getEvent() ?></h3>
    <h3><?= $list->getTitle() ?></h3>
    <h3><?= $list->getMessage() ?></h3>


  <?php endforeach; ?>