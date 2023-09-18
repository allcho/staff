<?php require 'model.php';?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php $data = Model::getJobsByDay($_GET["date"]); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Данные за <?php echo $_GET["date"]?></li>
        </ol>
    </nav>
    <?php if(count($data) > 0):
        $fullPrice = 0;
        $priceForBed = 30; 
        $priceForTowel= 10; 
    ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Номер</th>
              <th scope="col">Категория номера</th>
              <th scope="col">Тип уборки</th>
              <th scope="col">Начало уборки</th>
              <th scope="col">Конец уборки</th>
              <th scope="col">Сумма за уборку</th>
              <th scope="col">Сумма за смену белья</th>
              <th scope="col">Сумма за смену полотенец</th>
              <th scope="col">Итого сумма</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data as $one):
            $fullPrice = $fullPrice + $one['price'] + ($one['bed'] * $priceForBed) + ($one['towels'] * $priceForTowel);
            ?>
              <tr>
                <td><?php echo $one['num']?> (Корпус: <?php echo $one['frame']?>)</td>
                <td><?php echo $one['room_type']?></td>
                <td><?php echo $one['work_type']?></td>
                <td><?php echo $one['start'] ?></td>
                <td><?php echo $one['end'] ?></td>
                <td><?php echo $one['price']?></td>
                <td><?php echo ($one['bed'] * $priceForBed)?> руб. (<?php echo $one['bed'] ?> шт.)</td>
                <td><?php echo ($one['towels'] * $priceForTowel)?> руб. (<?php echo $one['towels'] ?> шт.)</td>
                <td><?php echo $one['price'] + ($one['bed'] * $priceForBed) + ($one['towels'] * $priceForTowel)?>руб.</td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <th scope="row" colspan="8">Итого за день:</th>
              <td colspan="1"><b><?php echo $fullPrice?> руб.</b> </td>
            </tr>
          </tbody>
        </table>
    <?php else: ?>
        <div>Нет данных</div>
    <?php endif; ?>
</body>
</html>