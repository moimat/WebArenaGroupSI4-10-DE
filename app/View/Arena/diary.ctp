<?php $this->assign('title', 'Diary'); ?>
<div>
    <h1>WebArena Events</h1>
    <table class= "table table-striped table-bordered fixed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Coordinate x</th>
                <th>Coordinate y</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // Display table in reverse order (most recent events first)
            foreach ($events as $key => $value) {
                $eventDate = $value['Event']['date'];
                $yesterday = date("Y-m-d H:i:s", strtotime("-1 day"));
                if (strtotime($eventDate) > strtotime($yesterday)) {
                    echo '<tr>';
                    echo '<td>' . $value['Event']['id'] . '</td>';
                    echo '<td>' . $value['Event']['name'] . '</td>';
                    echo '<td>' . TIME_CELL . ' ' . $value['Event']['date'] . '</td>';
                    echo '<td>' . COORDINATE_X_CELL . ' ' . $value['Event']['coordinate_x'] . '</td>';
                    echo '<td>' . COORDINATE_Y_CELL . ' ' . $value['Event']['coordinate_y'] . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table> 
     <p><br><br></p>
</div>