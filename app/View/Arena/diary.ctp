<?php $this->assign('title', 'Diary'); ?>

<script> $(document).ready(function(){
    $('#event').DataTable();
});
</script> 

<div>
    <h1>Events</h1>
    <table id="event" class= "table table-striped table-bordered fixed">
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
            $events = array_reverse($events);
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