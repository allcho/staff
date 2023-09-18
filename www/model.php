<?php
    require 'db.php';

    class Model
    {

        public function getAllJobs(): array {
            $connect = new db();

            $statistics = $connect->query("SELECT  `s`.`created`, `s`.`start`, `s`.`work`, `s`.`end`, `s`.`bed`, `s`.`towels`, `p`.`price`
                FROM `statistics`  as `s`
                LEFT JOIN `users` as `u` ON `u`.`id` = `s`.`staff`
                LEFT JOIN `rooms` as `r` ON `r`.`id` = `s`.`room`
                LEFT JOIN `prices` as `p` ON `p`.`work` = `s`.`work` 
                AND `p`.`room_type` = `r`.`type` AND `p`.`hotel` = `u`.`hotel`
                WHERE `u`.`name` = 'Чистых Елена' AND `s`.`created` BETWEEN '2020-09-01 00:00:00' AND '2020-09-30 23:59:59'")->all();

            $data = [];
            foreach($statistics as $one){
                $date = date('Y-m-d', strtotime($one['created']));
                switch ((int)$one['work']) {
                    case 0:
                        $data[$date]['start'] = date('H:m:s', strtotime($one['strat']));
                        $data[$date]['end'] = date('H:m:s', strtotime($one['end']));
                        break;
                    case 1:
                        $data[$date]['checkIn'] = (int)$data[$date]['checkIn'] + 1;
                        break;
                    case 2:
                        $data[$date]['springCleaning'] = (int)$data[$date]['springCleaning'] + 1;
                        break;
                    case 3:
                        $data[$date]['currentCleaning'] = (int)$data[$date]['currentCleaning'] + 1;
                        break;
                }

                $data[$date]['bed'] = (int)$data[$date]['bed'] + (int)$one['bed'];
                $data[$date]['towels'] = (int)$data[$date]['towels'] + (int)$one['towels'];
                $data[$date]['price'] = (int)$data[$date]['price'] + (int)$one['price'];

            }

            return $data;
        }


        public static function getJobsByDay(string $date): array {
            $connect = new db();

            $filter = '"' . $date . ' 00:00:00" AND "' . $date . ' 23:59:59" ';

            return $connect->query("SELECT  `r`.`num`, `r`.`build`, `p`.`price`, `p`.`room_type`
            , `b`.`name` as `frame`, `s`.`start`, `s`.`end`, `w`.`name` as work_type, `s`.`bed`, `s`.`towels`
            FROM `statistics`  as `s`
            LEFT JOIN `users` as `u` ON `u`.`id` = `s`.`staff`
            LEFT JOIN `rooms` as `r` ON `r`.`id` = `s`.`room`
            LEFT JOIN `prices` as `p` ON `p`.`work` = `s`.`work` 
            AND `p`.`room_type` = `r`.`type` AND `p`.`hotel` = `u`.`hotel`
            LEFT JOIN `builds` as `b` ON `b`.`id` = `r`.`build` AND `b`.`hotel` = `u`.`hotel`
            LEFT JOIN `works` as `w` ON `w`.`id` = `s`.`work`
            WHERE `u`.`name` = 'Чистых Елена' AND `s`.`work` <> 0 AND `s`.`created` BETWEEN " . $filter )->all();
        }

    }
?>