<?php require 'model.php';?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php $data = Model::getAllJobs();?>
    <?php if(count($data) > 0):
        $fullPrice = 0;
        $priceForBed = 30; 
        $priceForTowel= 10; 
    ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Дата</th>
              <th scope="col">Начало работы</th>
              <th scope="col">Конец работы</th>
              <th scope="col">Кол-во заездов</th>
              <th scope="col">Кол-во генеральных уборок</th>
              <th scope="col">Кол-во текущих уборок</th>
              <th scope="col">Сумма за уборки</th>
              <th scope="col">Сумма за смену белья</th>
              <th scope="col">Сумма за смену полотенец</th>
              <th scope="col">Итого сумма за день</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data as $key => $one):
              $fullPrice = $fullPrice + $one['price'] + ($one['bed'] * $priceForBed) + ($one['towels'] * $priceForTowel);
              ?>
              <tr>
                <th scope="row"><a href='/day.php?date=<?php echo $key?>'><?php echo $key?></a></th>
                <td><?php echo $one['start']?></td>
                <td><?php echo $one['end']?></td>
                <td><?php echo $one['checkIn'] ?? 0 ?></td>
                <td><?php echo $one['springCleaning'] ?? 0 ?></td>
                <td><?php echo $one['currentCleaning'] ?? 0 ?></td>
                <td><?php echo $one['price']?> руб.</td>
                <td><?php echo ($one['bed'] * $priceForBed)?> руб. (<?php echo $one['bed'] ?> шт.)</td>
                <td><?php echo ($one['towels'] * $priceForTowel)?> руб. (<?php echo $one['towels'] ?> шт.)</td>
                <td><?php echo $one['price'] + ($one['bed'] * $priceForBed) + ($one['towels'] * $priceForTowel)?>руб.</td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <th scope="row" colspan="9">Итого за сентябрь:</th>
              <td colspan="1"><b><?php echo $fullPrice?> руб. </b></td>
            </tr>
          </tbody>
        </table>
    <?php else: ?>
        <div>Нет данных</div>
    <?php endif; ?>
</body>
</html>